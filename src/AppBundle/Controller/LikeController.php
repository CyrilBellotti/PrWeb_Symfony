<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Liked;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class LikeController extends Controller{
    /**
     * @Route("/like", name="like")
     */
    public function likeAction(){
        $imageID = $_POST['idImage'];
        $eventID = $_POST['idEvent'];

        $em = $this->getDoctrine()->getManager();
        $imageTable = $em->getRepository("AppBundle:Image");
        $image=$imageTable->find($imageID);
        $Ilikes=$image->getLikeds();
        $hasLiked = false;
        foreach ($Ilikes as $ilike){
            if($ilike->getUser()==$this->getUser()){
                $hasLiked = true;
            }
        }
        if(!$hasLiked){
            $like = new Liked();
            $like->setDate(new \DateTime('now'));
            $like->setUser($this->getUser());

            $image->addLiked($like);
            $em->persist($image);
            $em->persist($like);
            $em->flush();
        }

        return $this->redirectToRoute("eventdetails",array('id' => $eventID));
    }
}
