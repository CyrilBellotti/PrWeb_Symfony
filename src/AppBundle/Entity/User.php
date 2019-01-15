<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="avatarPath", type="string", length=255, nullable=true)
     */

    private $avatarPath;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="user")
     */

    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Participante", mappedBy="user")
     */

    private $participantes;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Purchase", mappedBy="user")
     */

    private $purchases;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Vote", mappedBy="user")
     */
    private $votes;

    public function __construct() {
        parent::__construct();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->participantes = new ArrayCollection();
        $this->purchases = new ArrayCollection();
        $this->votes = new ArrayCollection();
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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
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

    public function addImage(Image $image){
        $this->images->add($image);
    }

    public function removeImage(Image $image){
        $this->images->remove($image->getId());
    }

    /**
     * @return ArrayCollection
     */
    public function getImages() {
        return $this->images;
    }

    public function addParticipante(Participante $participante){
        $this->participantes->add($participante);
    }

    public function removeParticipante(Participante $participante){
        $this->participantes->remove($participante->getId());
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipantes() {
        return $this->participantes;
    }

    public function addPurchase(Purchase $purchase){
        $this->purchases->add($purchase);
    }

    public function removePurchase(Purchase $purchase){
        $this->purchases->remove($purchase->getId());
    }

    /**
     * @return ArrayCollection
     */
    public function getPurchases() {
        return $this->purchases;
    }

    public function addVote(Vote $vote){
        $this->votes->add($vote);
    }

    public function removeVote(Vote $vote){
        $this->votes->remove($vote->getId());
    }

    /**
     * @return ArrayCollection
     */
    public function getVotes() {
        return $this->votes;
    }

    public function setEmail($email) {
        $this->email = $email;

        if(preg_match("/^[a-z]+\\.[a-z]+@viacesi\\.fr$/i", $email )){
            $i = 0;
            $firstName = '';
            $lastname ='';
            while($email[$i] != '.'){
                $firstName.=$email[$i];
                $i++;
            }
            $i++;
            while($email[$i] != '@'){
                $lastname.=$email[$i];
                $i++;
            }
            $this->setFirstName($firstName);
            $this->setLastName($lastname);
            $this->setUsername($firstName." ".$lastname);
        }

        else if(preg_match("/^[a-z]+@cesi\\.fr$/i", $email )){
            $i = 0;
            $firstName = '';
            while($email[$i] != '@'){
                $firstName.=$email[$i];
                $i++;
            }
            $this->setFirstName($firstName);
            $this->setUsername($firstName);

        }
    }

    /**
     * @return string
     */
    public function getAvatarPath() {
        return $this->avatarPath;
    }

    /**
     * @param string $avatarPath
     */
    public function setAvatarPath($avatarPath) {
        $this->avatarPath = $avatarPath;
    }


}

