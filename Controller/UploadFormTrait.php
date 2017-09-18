<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\Controller;

use Aamant\GedBundle\Entity\Directory;
use Aamant\GedBundle\Entity\Document;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class UploadFormTrait
 * @package Aamant\GedBundle\Controller
 */
trait UploadFormTrait
{
    /**
     * @param Directory $directory
     * @return \Symfony\Component\Form\Form
     */
    public function getUploadFileForm(Document $document, Directory $directory = null, $domain)
    {
        $form = $this->createFormBuilder($document, [
            'action'    => $this->generateUrl('aamant_ged_document_upload', [ 'directory' => $directory->getId(), 'domain' => $domain ]),
            'method'    => 'post',
            'csrf_protection'   => false
        ])
            ->add('file', FileType::class, ['multiple' => true])
        ;

        return $form->getForm();
    }
}