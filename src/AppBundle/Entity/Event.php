<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="isValid", type="boolean")
     */
    private $isValid;

    /**
     * @var string
     *
     * @ORM\Column(name="necessaryInformation", type="text", nullable=true)
     */
    private $necessaryInformation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creationDate", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadlineDate", type="datetime")
     */
    private $deadlineDate;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=50)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=15)
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=50)
     */
    private $country;

    /**
     * @ORM\ManyToOne(targetEntity="Recurrence")
     * @ORM\JoinColumn(name="recurrence_id", referencedColumnName="id")
     */

    private $recurrence;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Comment")
     * @ORM\JoinTable(name="events_comments",
     *     joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="comment_id", referencedColumnName="id", unique=true)}
     *     )
     */

    private $comments;


    /**
     * @ORM\OneToMany(targetEntity="Participante", mappedBy="event")
     */

    private $participantes;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="DateEvent")
     * @ORM\JoinTable(name="events_dateEvents",
     *     joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="dateEvent_id", referencedColumnName="id", unique=true)}
     *     )
     */

    private $dateEvents;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Image")
     * @ORM\JoinTable(name="events_images",
     *     joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="image_id", referencedColumnName="id", unique=true)}
     *     )
     */

    private $images;

    public function  __construct() {

        $this->comments = new ArrayCollection();
        $this->participantes = new ArrayCollection();
        $this->dateEvents = new ArrayCollection();
        $this->images = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * Set price
     *
     * @param float $price
     *
     * @return Event
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     *
     * @return Event
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid
     *
     * @return bool
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Set necessaryInformation
     *
     * @param string $necessaryInformation
     *
     * @return Event
     */
    public function setNecessaryInformation($necessaryInformation)
    {
        $this->necessaryInformation = $necessaryInformation;

        return $this;
    }

    /**
     * Get necessaryInformation
     *
     * @return string
     */
    public function getNecessaryInformation()
    {
        return $this->necessaryInformation;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Event
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set deadlineDate
     *
     * @param \DateTime $deadlineDate
     *
     * @return Event
     */
    public function setDeadlineDate($deadlineDate)
    {
        $this->deadlineDate = $deadlineDate;

        return $this;
    }

    /**
     * Get deadlineDate
     *
     * @return \DateTime
     */
    public function getDeadlineDate()
    {
        return $this->deadlineDate;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Event
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Event
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Event
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return mixed
     */
    public function getRecurrence() {
        return $this->recurrence;
    }

    /**
     * @param mixed $recurrence
     */
    public function setRecurrence($recurrence) {
        $this->recurrence = $recurrence;
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

    public function addDateEvent(DateEvent $dateEvent){
        $this->dateEvents->add($dateEvent);
    }

    public function removeDateEvent(DateEvent $dateEvent){
        $this->dateEvents->remove($dateEvent->getId());
    }

    /**
     * @return ArrayCollection
     */
    public function getDateEvents() {
        return $this->dateEvents;
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

}

