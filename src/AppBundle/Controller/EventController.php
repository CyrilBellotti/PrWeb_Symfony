<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\DateEvent;
use AppBundle\Entity\Event;

use AppBundle\Entity\Participante;
use Doctrine\Common\Collections\ArrayCollection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Class EventController
 * @package AppBundle\Controller
 * @Route("/event",name="events")
 */
class EventController extends Controller{
    /**
     *
     * @Route("/{id}",requirements={"id" = "\d+"}, name="eventdetails")
     */

    public function eventAction( $id){
        $user = $this->getUser();
        if(isset($user)) {
            $em = $this->getDoctrine();
            $eventTable = $em->getRepository("AppBundle:Event");
            $recurrenceTable = $em->getRepository("AppBundle:Recurrence");
            $imageTable = $em->getRepository("AppBundle:Comment");
            $voteTable = $em->getRepository("AppBundle:Vote");
            $event = $eventTable->find($id);
            if (!isset($event)) {
                return $this->render("@App/event/event.html.twig", [
                    'event' => 'pas d event',
                ]);
            }
            $recurrence = $recurrenceTable->find($event->getRecurrence());
            $comments = $event->getComments();
            $images = $event->getImages();
            $participations = $user->getParticipantes();
            $hasRegistered = false;
            foreach ($participations as $participation){
                if($participation->getEvent()==$event){
                    $hasRegistered = true;
                }

            }
            $dates = $event->getDateEvents();
            $hasVoted = false;
            $validdate = null;
            foreach ($dates as $date){

                if($date->getIsValid()){
                    $validdate = $date;
                }
                $votes = $date->getVotes();
                foreach ($votes as $vote){
                    if($vote->getUser() == $this->getUser()){
                        $hasVoted = true;
                    }
                }
            }
            if(isset($validdate)){
                $validdate = $validdate->getDate();
            }

            $event = $eventTable->find($id);
            $participanteTable = $em->getRepository("AppBundle:Participante");
            $participantes = $participanteTable->findBy(array('event' => $event));
            $users = new ArrayCollection();
            foreach ($participantes as $participante){
                $users->add($participante->getUser());
            }


            return $this->render("@App/event/event.html.twig", [
                'event' => $event->getName(),
                'recurrence' => $recurrence->getName(),
                'description' => $event->getDescription(),
                'creationdate' => $event->getCreationDate()->format('d-m-Y'),
                'deadline' => $event->getDeadlineDate()->format('d-m-Y'),
                'comments' => $comments,
                'images' => $images,
                'isValid' => $event->getIsValid(),
                'id' => $event->getId(),
                'hasregistered' => $hasRegistered,
                'price' => $event->getPrice(),
                'locationCity' => $event->getCity(),
                'locationCountry' => $event->getCountry(),
                'locationPostal' => $event->getPostalCode(),
                'locationAddress' => $event->getAddress(),
                'dates' => $event->getDateEvents(),
                'hasVoted' => $hasVoted,
                'validDate' => $validdate,
                'users' => $users,
            ]);
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * @Route("/", name="eventlist")
     */
    public function listEvent(){
        $user = $this->getUser();
        if(isset($user)) {
            $em = $this->getDoctrine();
            $eventTable = $em->getRepository("AppBundle:Event");
            $events = $eventTable->findBy(array('isValid' => '1'), array('id' => 'desc'), 20);
            return $this->render("@App/event/eventlist.html.twig", [
                'events' => $events,
            ]);
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * @Route("/proposition", name="propositionlist")
     */
    public function listProposition(){
        $user = $this->getUser();
        if(isset($user)) {
            $em = $this->getDoctrine();
            $eventTable = $em->getRepository("AppBundle:Event");
            $events = $eventTable->findBy(array('isValid' => '0'), array('id' => 'desc'), 20);
            return $this->render("@App/event/propositionlist.html.twig", [
                'events' => $events,
            ]);
        }
        return $this->redirectToRoute('fos_user_security_login');
    }


    /**
     * @Route("/new_event",name="newevent")
     *
     */
    public function newEvent(Request $request){
        $user = $this->getUser();
        if(isset($user)) {
            if($request->getMethod() == "GET"){
                return $this->render("@App/event/newevent.html.twig");
            }
            elseif ($request->getMethod() == "POST"){
                $em = $this->getDoctrine()->getManager();
                $event = new Event();
                $event->setName($_POST['name']);
                $event->setDescription($_POST['description']);
                $recurrencePost = $_POST['recurrence'];
                $recurrenceTable = $em->getRepository('AppBundle:Recurrence');
                $recurrence = $recurrenceTable->findOneBy(array('name' => $recurrencePost));
                $event->setRecurrence($recurrence);
                $year = $_POST['Year'];
                $month = $_POST['Month'];
                $day = $_POST['Day'];
                $dateString = "".$year."-".$month."-".$day;
                $date = new \DateTime($dateString);
                $dateEvent = new DateEvent();
                $dateEvent->setDate($date);
                $dateEvent->setIsValid(false);
                $event->addDateEvent($dateEvent);
                if(isset($_POST['Day2']) && isset($_POST['Month2']) && isset($_POST['Year2'])){
                    $day2 = $_POST['Day2'];
                    $year2 = $_POST['Year2'];
                    $month2 = $_POST['Month2'];
                    $date2String = "".$year2."-".$month2."-".$day2;
                    $date2 = new \DateTime($date2String);
                    $dateEvent2 = new DateEvent();
                    $dateEvent2->setDate($date2);
                    $dateEvent2->setIsValid(false);
                    $event->addDateEvent($dateEvent2);
                    $em->persist($dateEvent2);
                }
                if(isset($_POST['Day3']) && isset($_POST['Month3']) && isset($_POST['Year3'])){
                    $day3 = $_POST['Day3'];
                    $year3 = $_POST['Year3'];
                    $month3 = $_POST['Month3'];
                    $date3String = "".$year3."-".$month3."-".$day3;
                    $date3 = new \DateTime($date3String);
                    $dateEvent3 = new DateEvent();
                    $dateEvent3->setDate($date3);
                    $dateEvent3->setIsValid(false);
                    $event->addDateEvent($dateEvent3);
                    $em->persist($dateEvent3);
                }

                $event->setIsValid(false);
                $event->setPrice($_POST['price']);
                $event->setCreationDate(new \DateTime('now'));
                $event->setAddress($_POST['address']);
                $event->setCity($_POST['city']);
                $event->setPostalCode($_POST['code']);
                $event->setCountry($_POST['country']);
                $event->setDeadlineDate($date->modify('-7 days'));
                $em->persist($dateEvent);
                $em->persist($event);
                $em->flush();
                return $this->redirectToRoute('eventdetails',array('id' => $event->getId()));
            }
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

    /**
     * @Route("/register", name="eventregistration")
     */
    public function registerEvent(){
        $em = $this->getDoctrine()->getManager();
        $eventid = $_POST["id"];
        $event = $em->getRepository("AppBundle:Event")->find($eventid);
        $user = $this->getUser();
        $participante = new Participante();
        $participante->setUser($user);
        $participante->setEvent($event);
        $user->addParticipante($participante);

        $em->persist($user);
        $em->persist($participante);
        $em->flush();
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/comment", name="comment")
     */
    public function comment(){
        $commentcontent = $_POST['comment'];
        $eventid = $_POST['eventid'];
        $em = $this->getDoctrine()->getManager();
        $eventTable = $em->getRepository('AppBundle:Event');
        $event = $eventTable->find($eventid);
        $comment = new Comment();
        $comment->setContent($commentcontent);
        $comment->setUser($this->getUser());
        $comment->setDate(new \DateTime());
        $event->addComment($comment);
        $em->persist($event);
        $em->persist($comment);
        $em->flush();
        return $this->redirectToRoute('eventdetails',array('id' => $eventid));


    }

    /**
     * @Route("/active", name="activeEvent")
     */
    public function activeEvent(Request $request){
        $em = $this->getDoctrine()->getManager();
        $eventTable = $em->getRepository("AppBundle:Event");
        if($request->getMethod() == 'GET'){
            $user = $this->getUser();

            if(isset($user)) {

                $events = $eventTable->findBy(array('isValid' => '0'), array('id' => 'desc'), 20);
                return $this->render("@App/event/activeEvent.html.twig", [
                    'events' => $events,
                ]);
            }
            return $this->redirectToRoute('fos_user_security_login');
        }
        else{
            $eventID = $_POST['proposition'];
            $event = $eventTable->find($eventID);
            $event->setIsValid(true);
            $dates = $event->getDateEvents();
            $validDate = $dates[0];
            foreach ($dates as $date){
                if($date->getVotes()->count() > $validDate->getVotes()->count()){
                    $validDate = $date;
                }
            }
            $validDate->setisValid(true);

            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute("activeEvent");
        }
    }
}
