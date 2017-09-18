<?php
/**
 *
 * @author Arnaud Amant <contact@arnaudamant.fr>
 */

namespace Aamant\GedBundle\Service;


use Aamant\GedBundle\Entity\Directory;
use Aamant\GedBundle\Entity\Document;
use Doctrine\ORM\EntityManager;

/**
 * Class Manager
 * @package Aamant\GedBundle\Service
 */
class Manager
{
    /**
     * @var \Gaufrette\FilesystemMap
     */
    private $filesystemMap;
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var \Aamant\GedBundle\Repository\DirectoryRepository
     */
    private $directoryRepository;

    /**
     * Manager constructor.
     * @param \Knp\Bundle\GaufretteBundle\FilesystemMap $filesystemMap
     * @param EntityManager $entityManager
     */
    public function __construct(\Knp\Bundle\GaufretteBundle\FilesystemMap $filesystemMap, EntityManager $entityManager)
    {
        $this->filesystemMap = $filesystemMap;
        $this->entityManager = $entityManager;
        $this->directoryRepository = $entityManager->getRepository('AamantGedBundle:Directory');
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Gaufrette\FilesystemMap
     */
    public function getFilesystemMap()
    {
        return $this->filesystemMap;
    }

    /**
     * @param \Gaufrette\FilesystemMap $filesystemMap
     */
    public function setFilesystemMap($filesystemMap)
    {
        $this->filesystemMap = $filesystemMap;
    }

    /**
     * @param Document $document
     * @return string
     */
    public function show(Document $document)
    {
        return $this->filesystemMap->get($document->getDomain())->read($document->getFilename());
    }

    /**
     * @param Directory $directory
     * @return $this
     */
    public function removeDirectory(Directory $directory)
    {
        foreach ($directory->getDocuments() as $document){
            if ($this->filesystemMap->get($document->getDomain())->has($document->getFilename())) {
                $this->filesystemMap->get($document->getDomain())->delete($document->getFilename());
            }
            $this->entityManager->remove($document);
            $this->entityManager->flush();
        }

        foreach ($directory->getChildren() as $child) {
            $this->removeDirectory($child);
        }

        $this->directoryRepository->removeFromTree($directory);
//        $this->entityManager->clear();
//        $this->entityManager->flush();

        return $this;
    }

    /**
     * @param Document $document
     * @return $this
     */
    public function removeDocument(Document $document)
    {
        $this->filesystemMap->get($document->getDomain())->delete($document->getFilename());
        $this->entityManager->remove($document);

        $this->entityManager->flush();
        return $this;
    }

    public function createRoot()
    {

    }
}