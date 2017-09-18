<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\EventListener;


use AppBundle\Entity\Agency;
use Axcenteo\GedBundle\Entity\Directory;
use Doctrine\ORM\Event\LifecycleEventArgs;

class CreateRootTreeListener
{
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $reflection = new \ReflectionClass($entity);
        if ( $reflection->hasMethod('getGed') && $entity->getGed() == null){
            /** @var \Aamant\GedBundle\Repository\DirectoryRepository $repository */
            $repository = $args->getEntityManager()->getRepository('AxcenteoGedBundle:Directory');
            $root = new Directory();
            $root->setTitle( 'ged_'.str_replace( '\\', '_', get_class($entity) ) );

            $repository->persistAsFirstChild($root);
            $entity->setGed($root);
        }
    }
}