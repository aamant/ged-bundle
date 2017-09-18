<?php
/**
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */
namespace Aamant\GedBundle\Controller;

use Aamant\GedBundle\Entity\Directory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DirectoryController
 * @package Aamant\GedBundle\Controller
 */
class DirectoryController extends Controller
{
    use CreateOrUpdateFormTrait;
    use UploadFormTrait;
    use ManagerTrait;

    /**
     * @param Directory $node
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Request $request, Directory $node, $domain)
    {
        if (!$this->get('aamant_ged.auth')->isGrantedToWrite($node)){
            throw $this->createAccessDeniedException();
        }

        /** @var \Aamant\GedBundle\Repository\DirectoryRepository $repository */
        $repository = $this->getDoctrine()->getRepository('AamantGedBundle:Directory');

        $form = $this->getCreateOrUpdateForm($node, $domain);
        $form->handleRequest($request);

        if ($form->isValid()){
            $child = new Directory();
            $child->setTitle($form->get('title')->getData());

            $repository->persistAsFirstChildOf($child, $node);

            $this->getDoctrine()->getManager()->flush();
        }
        else {
            return new Response('form is not valid', 500);
        }

        return $this->redirectToRoute('aamant_ged_directory_show', ['directory' => $node->getId(), 'domain' => $domain]);
    }

    /**
     * @param Request $request
     * @param Directory $directory
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeAction(Request $request, Directory $directory, $domain)
    {
        if (!$this->get('aamant_ged.auth')->isGrantedToWrite($directory)){
            throw $this->createAccessDeniedException();
        }

        try {
            $parent = $directory->getParent();
            $this->getManager()->removeDirectory($directory);
        }
        catch (\Exception $e){
            return new Response($e->getMessage(), 500);
        }

        return $this->redirectToRoute('aamant_ged_directory_show', ['directory' => $parent->getId(), 'domain' => $domain]);
    }
}
