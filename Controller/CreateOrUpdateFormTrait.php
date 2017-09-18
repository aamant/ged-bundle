<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\Controller;

use Aamant\GedBundle\Entity\Directory;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class CreateOrUpdateFormTrait
 * @package Aamant\GedBundle\Controller
 */
Trait CreateOrUpdateFormTrait
{
    /**
     * @param Directory $node
     * @return \Symfony\Component\Form\Form
     */
    protected function getCreateOrUpdateForm(Directory $node, $domain)
    {
        $form = $this->createFormBuilder(null, [
            'action' => $this->generateUrl('aamant_ged_directory_add', [ 'node' => $node->getId(), 'domain' => $domain ]),
            'method' => 'POST',
        ])
            ->add('title', TextType::class, [
                'label' => 'form.directory',
                'attr' => ['placeholder' => 'form.name'],
            ])
            ->add('create', SubmitType::class, [
                'label' => 'form.submit',
                'attr'  => ['class' => 'btn btn-primary']
            ])
        ;

        return $form->getForm();
    }
}