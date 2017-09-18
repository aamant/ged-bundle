<?php

namespace Aamant\GedBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ORM\Table(name="aamant_ged_document")
 * @ORM\Entity(repositoryClass="Aamant\GedBundle\Repository\DocumentRepository")
 */
class Document
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="realname", type="string", length=255)
     */
    private $realname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $filename;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Directory", inversedBy="documents")
     * @ORM\JoinColumn(name="directory_id", referencedColumnName="id")
     */
    private $directory;

    /**
     * @var string
     *
     * @ORM\Column(name="domain", type="string", length=255)
     */
    private $domain;

    /**
     * @Assert\File(
     *     maxSize="6000000",
     *     mimeTypes = {
     *      "image/jpeg", "image/png", "image/gif", "application/pdf", "application/x-pdf", "text/plain",
     *      "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *      "application/vnd.openxmlformats-officedocument.wordprocessingml.template",
     *      "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.ms-excel",
     *      "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *      "application/vnd.openxmlformats-officedocument.spreadsheetml.template", "application/vnd.ms-powerpoint",
     *      "application/vnd.openxmlformats-officedocument.presentationml.presentation",
     *      "application/vnd.openxmlformats-officedocument.presentationml.template",
     *      "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
     *      "application/octet-stream"
     *    }
     * )
     */
    private $file;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return File
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string 
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set directory
     *
     * @param integer $directory
     * @return File
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * Get directory
     *
     * @return integer 
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Document
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set domain
     *
     * @param string $domain
     * @return Document
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return string 
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
