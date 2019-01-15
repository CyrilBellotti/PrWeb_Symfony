<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Involve
 *
 * @ORM\Table(name="participante")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParticipanteRepository")
 */
class Participante
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
     * @ORM\Column(name="informationAsked", type="text", nullable=true)
     */
    private $informationAsked;

    /**
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="participantes")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */

    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="participantes")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */

    private $user;


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
     * Set informationAsked
     *
     * @param string $informationAsked
     *
     * @return Involve
     */
    public function setInformationAsked($informationAsked)
    {
        $this->informationAsked = $informationAsked;

        return $this;
    }

    /**
     * Get informationAsked
     *
     * @return string
     */
    public function getInformationAsked()
    {
        return $this->informationAsked;
    }

    /**
     * @return mixed
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent($event) {
        $this->event = $event;
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



}

