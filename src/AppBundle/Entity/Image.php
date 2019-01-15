<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="isReactive", type="boolean")
     */
    private $isReactive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insertionDate", type="datetime")
     */
    private $insertionDate;


    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Comment")
     * @ORM\JoinTable(name="images_comments",
     *     joinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id", unique=true)}
     *     )
     */
    private $comments;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="images")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */

    private $user;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Liked")
     * @ORM\JoinTable(name="images_likeds",
     *     joinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="liked_id", referencedColumnName="id", unique=true)}
     *     )
     */

    private $likeds;


    public function __construct() {
        $this->comments = new ArrayCollection();
        $this->likeds = new ArrayCollection();
    }


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
     * Set path
     *
     * @param string $path
     *
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Image
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set isReactive
     *
     * @param boolean $isReactive
     *
     * @return Image
     */
    public function setIsReactive($isReactive)
    {
        $this->isReactive = $isReactive;

        return $this;
    }

    /**
     * Get isReactive
     *
     * @return bool
     */
    public function getIsReactive()
    {
        return $this->isReactive;
    }

    /**
     * Set insertionDate
     *
     * @param \DateTime $insertionDate
     *
     * @return Image
     */
    public function setInsertionDate($insertionDate)
    {
        $this->insertionDate = $insertionDate;

        return $this;
    }

    /**
     * Get insertionDate
     *
     * @return \DateTime
     */
    public function getInsertionDate()
    {
        return $this->insertionDate;
    }

    public function addComment(Comment $comment){
        $this->comments->add($comment);
    }

    public function removeComment(Comment $comment){
        $this->comments->remove($comment->getId());
    }

    /**
     * @return ArrayCollection
     */
    public function getComments() {
        return $this->comments;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user) {
        $this->user = $user;
    }

    public function addLiked(Liked $liked){
        $this->likeds->add($liked);
    }

    public function removeLiked(Liked $liked){
        $this->likeds->remove($liked->getId());
    }

    /**
     * @return ArrayCollection
     */
    public function getLikeds() {
        return $this->likeds;
    }

}

