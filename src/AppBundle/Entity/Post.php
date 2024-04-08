<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use dsarhoya\DSYFilesBundle\Interfaces\IFileEnabledEntity;

/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PostRepository")
 */
class Post implements IFileEnabledEntity
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;
    
    /**
    *
    * @var string
    * @ORM\Column(type="string", nullable=true)
    */
    private $fullFileKey;
    
    /**
     *
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * @Assert\File(
     *      maxSize = "4M",
     *      maxSizeMessage = "File too big"
     * )
     */
    private $file;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Post
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Post
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set fullFileKey
     *
     * @param string $fullFileKey
     *
     * @return Post
     */
    public function setFullFileKey($fullFileKey)
    {
        $this->fullFileKey = $fullFileKey;

        return $this;
    }

    /**
     * Get fullFileKey
     *
     * @return string
     */
    public function getFullFileKey()
    {
        return $this->fullFileKey;
    }
    /**
     * Get file
     *
     * @return File
     */
    public function getFile(){
        return $this->file;
    }

    /**
     * Get fileProperties
     *
     * @return \Array
     */
    public function getFileProperties() {
        return array();
    }

    /**
     * Get fileKey
     *
     * @return string
     */
    public function getFileKey() {
        $parts = explode('/', $this->getFullFileKey());
        return $parts[count($parts)-1];
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getFilePath() {
        $parts = explode('/', $this->getFullFileKey());
        array_pop($parts);
        return implode('/', $parts);
    }

    /**
     *
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     * @return Company
     */
    public function setFile(\Symfony\Component\HttpFoundation\File\UploadedFile $file){
        $this->file = $file;
        $this->setFullFileKey(sprintf("files/file_%s.%s", md5(time()), $file->guessExtension()));
        return $this;
    }
}
