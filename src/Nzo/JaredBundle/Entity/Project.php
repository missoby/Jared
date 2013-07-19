<?php

namespace Nzo\JaredBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Nzo\BookingBundle\Entity\hotel
 *
 * @ORM\Table(name="jared_projects")
 * @ORM\Entity(repositoryClass="Nzo\BookingBundle\Entity\hotelRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;    
    
    /**
     * @ORM\ManyToOne(targetEntity="Nzo\UserBundle\Entity\user")
     */
    private $user;
    
    /**
     * @ORM\Column(name="nameproject", type="string", length=256)
     * @Assert\NotBlank()
     */
    private $nameproject;
    
    /**
     * @ORM\Column(name="initials", type="string", length=256)
     * @Assert\NotBlank()
     */
    private $initials;
    
    /**
     * @ORM\Column(name="service", type="string", length=256)
     * @Assert\NotBlank()
     */
    private $service;
      
    /**
     * @ORM\Column(name="rate", type="integer")
     * @Assert\NotBlank()
     */
    private $rate;
    
    /**
     * @ORM\Column(name="hours", type="float")
     * @Assert\NotBlank()
     */
    private $hours;
    
    /**
     * @ORM\Column(name="amount", type="float")
     * @Assert\NotBlank()
     */
    private $amount;
    
    /**
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;
    
    /**
     * @ORM\Column(name="creationdate", type="date")
     * @Assert\NotBlank()
     */
    protected $creationdate; 
    
    /**
     * @ORM\Column(name="date", type="date")
     * @Assert\NotBlank()
     */
    protected $date;
    
    /**
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    public $path;
    
    /**
     * @Assert\File(maxSize="2M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage = "S'il vous plaît uploader un type d'image valide(jpg, jpeg, or png)")
     */
    public $file;
    
    public function __construct()
    {
        $this->creationdate = new \DateTime('now');
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    
    //***************** UPLOAD FILE *********************
    
    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/bundles/nzojared/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploadedfiles';
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
//            if($this->path !== null){
//                $delete = $this->getAbsolutePath();
//                unlink($delete);
//            }
            // do whatever you want to generate a unique name
            $this->path = sha1(uniqid(mt_rand(), true)).'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
           try { unlink($file); } catch (\Exception $e) {} // modified by me
        }
    }
    
    public function removeOldUpload($path)  // developed and added by me Nzo
    {
        $file = $this->getUploadRootDir().'/'.$path; 
        try { unlink($file); } catch (\Exception $e) {} // modified by me

    }
/*******************************************************************************************/

}