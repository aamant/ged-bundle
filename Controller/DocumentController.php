<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */
namespace Aamant\GedBundle\Controller;

use Aamant\GedBundle\Entity\Directory;
use Aamant\GedBundle\Entity\Document;
use Aamant\GedBundle\Entity\File;
use Gaufrette\Exception\FileNotFound;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{
    use UploadFormTrait;
    use ManagerTrait;
    
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAction(Request $request, Directory $directory, $domain)
    {
        if (!$this->get('aamant_ged.auth')->isGrantedToWrite($directory)){
            throw $this->createAccessDeniedException();
        }

        try {
            $document = new Document();
            $document->setDirectory($directory)
                ->setDomain($domain);

            $form = $this->getUploadFileForm($document, $directory, $domain);
            $form->handleRequest($request);

            if ($form->isValid()){

                $em = $this->getDoctrine()->getManager();
                $em->persist($document);
                $em->flush();

                return new JsonResponse([
                    'status'    => 'done',
                    'files'     => [ $document->getRealname() ]
                ]);
            }
            return new Response($form->getErrors(), 500);
        }
        catch (\Exception $e){
            return new Response($e->getMessage(), 500);
        }
    }

    /**
     * @param Document $document
     * @return Response
     */
    public function showAction(Document $document)
    {
        if (!$this->get('aamant_ged.auth')->isGrantedToRead($document->getDirectory())){
            throw $this->createAccessDeniedException();
        }

        try {
            $file = $this->getGaufrette( $document->getDomain() );

            $response = new Response( $file->read($document->getFilename()) );
            $response->headers->add(['Content-Type' => $file->mimeType($document->getFilename())]);

            return $response;
        }
        catch (FileNotFound $e) {
            return new Response("Ce fichier n'existe plus sur le serveur");
        }
    }

    /**
     * @param Document $document
     * @return Response
     */
    public function removeAction(Document $document)
    {
        if (!$this->get('aamant_ged.auth')->isGrantedToWrite($document->getDirectory())){
            throw $this->createAccessDeniedException();
        }

        try {
            $fs = $this->getGaufrette( $document->getDomain() );
            $fs->removeFromRegister($document->getFilename());

            $this->getDoctrine()->getManager()->remove($document);
            $this->getDoctrine()->getManager()->flush();
        }
        catch (\Exception $e){
            return new Response($e->getMessage(), 500);
        }

        return $this->redirectToRoute('aamant_ged_directory_show', ['domain' => $document->getDomain(), 'directory' => $document->getDirectory()]);
    }
}
