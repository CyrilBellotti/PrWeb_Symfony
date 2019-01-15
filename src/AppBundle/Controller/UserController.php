<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Participante;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/user")
 */
class UserController extends Controller {

    /**
     * @Route("/", name="userdetails")
     */
    public function userAction(){
        $user = $this->getUser();
        if(isset($user)){
            $userRole = $user->getRoles();
            if($userRole[0]=="ROLE_SUPER_ADMIN"){
                $userRole="Membre staff CESI";
            }
            elseif ($userRole[0]=="ROLE_ADMIN"){
                $userRole="Membre BDE";
            }
            else{
                $userRole="Eleve";
            }
            return $this->render("@App/user/user.html.twig",[
                'user' => $user->getUsername(),
                'firstname' => $user->getFirstName(),
                'lastname' => $user->getLastName(),
                'avatar' => $user->getAvatarPath(),
                'role' => $userRole,
            ]);
        }
        return $this->redirectToRoute("fos_user_security_login");
    }

    /**
     * @Route("/participation", name="participation")
     */
    public function getParticipation(){
        $user = $this->getUser();
        $em = $this->getDoctrine();
        $participationTable = $em->getRepository("AppBundle:Participante");
        $eventTable = $em->getRepository("AppBundle:Event");
        $particpations = $participationTable->findBy(array('user' => $user));
        $events = new ArrayCollection();
        foreach ($particpations as $particpation){
            $events->add($eventTable->find($particpation->getEvent()->getId()));

        }

        return $this->render('@App/user/participation.html.twig',[
            'events' => $events,
        ]);

    }



}
