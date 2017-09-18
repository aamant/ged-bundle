<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\EventListener;

use Aamant\GedBundle\Entity\Document;
use Aamant\GedBundle\Service\Manager;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Class UploadListener
 * @package Aamant\GedBundle\EventListener
 */
class UploadListener
{
    /**
     * @var \Knp\Bundle\GaufretteBundle\FilesystemMap
     */
    private $filesystemMap;

    /**
     * UploadListener constructor.
     * @param \Knp\Bundle\GaufretteBundle\FilesystemMap $filesystemMap
     */
    public function __construct(\Knp\Bundle\GaufretteBundle\FilesystemMap $filesystemMap)
    {
        $this->filesystemMap = $filesystemMap;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $document = $args->getEntity();

        if ($document instanceof Document && $document->getFile()){

            $file = $document->getFile();

            $realname = $file->getClientOriginalName();
            $filename = md5(uniqid()).'.'.$file->guessExtension();

            $fs = $this->filesystemMap->get($document->getDomain());
            $fs->write($filename, file_get_contents($file) );

            $document
                ->setFilename($filename)
                ->setRealname($realname);
        }
    }
}