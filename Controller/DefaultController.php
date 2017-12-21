<?php

namespace Aamant\GedBundle\Controller;

use Aamant\GedBundle\Entity\Directory;
use Aamant\GedBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{
    use CreateOrUpdateFormTrait;
    use UploadFormTrait;

    /**
     * @param $domain
     * @param Directory $directory
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($domain, Directory $directory)
    {
        if (!$this->get('aamant_ged.auth')->isGrantedToRead($directory)){
            throw $this->createAccessDeniedException();
        }

        /** @var \Aamant\GedBundle\Repository\DirectoryRepository $repository */
        $repository = $this->getDoctrine()->getRepository('AamantGedBundle:Directory');
        $repository->reorder($directory,
            $this->getParameter('aamant_ged.default_sort.attribute'),
            $this->getParameter('aamant_ged.default_sort.order'),
            false
        );
        $this->getDoctrine()->getManager()->flush();

        $options = array(
            'decorate' => false,
            'rootOpen' => '<ul class="list-group text-left">',
            'rootClose' => '</ul>',
            'childOpen' => '<li class="list-group-item">',
            'childClose' => '</li>',
            'nodeDecorator' => function($node) {
                $url = $this->generateUrl('aamant_ged_homepage', ['node' => $node['id']], UrlGeneratorInterface::ABSOLUTE_URL);
                return '<div class="dd-handle dd3-handle"><div class="dd-content"><a href="'.$url.'">'.$node['title'].'</a></div></div>';
            },
        );

        $htmlTree = $repository->childrenHierarchy(
            $directory,
            true,
            $options
        );

        $path = $repository->getPath($directory);

        $document = new Document();
        $document->setDirectory($directory);

        return $this->render('AamantGedBundle:Default:index.html.twig', [
            'tree'      => $htmlTree,
            'current'   => $directory,
            'domain'    => $domain,
            'form'      => $this->getCreateOrUpdateForm($directory, $domain)->createView(),
            'upload'    => $this->getUploadFileForm($document, $directory, $domain)->createView(),
            'path'      => $path
        ]);
    }
}
