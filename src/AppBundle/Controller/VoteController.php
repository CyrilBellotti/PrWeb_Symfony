<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vote;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class VoteController
 * @package AppBundle\Controller
 * @Route("/vote")
 */
class VoteController extends Controller {

    /**
     * @Route("/", name="vote")
     */
    public function vote(){
        if($user = $this->getUser()){
            $em = $this->getDoctrine()->getManager();
            $vote = new Vote();
            $vote->setDate(new \DateTime());
            $vote->setUser($user);

            $dateEventTable = $em->getRepository("AppBundle:DateEvent");
            $dateEvent = $dateEventTable->find($_POST['dateid']);
            $dateEvent->addVote($vote);
            $vote->setDateEvent($dateEvent);
            $em->persist($vote);
            $em->persist($dateEvent);
            $em->flush();
            return $this->redirectToRoute('eventdetails',array('id' => $_POST['eventid']));

        }
    }



}
