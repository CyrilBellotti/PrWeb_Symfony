<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $user=$this->getUser();
        if(isset($user)){
            $em = $this->getDoctrine();
            $eventTable = $em->getRepository("AppBundle:Event");
            $productTable = $em->getRepository("AppBundle:Product");
            $products = $productTable->findBy(array('isAvailable' => '1'), array('id' => 'desc'), 3);
            $propositions = $eventTable->findBy(array('isValid' => '0'), array('id' => 'desc'), 3);
            $events = $eventTable->findBy(array('isValid' => '1'), array('id' => 'desc'), 3);
            return $this->render(':default:index.html.twig',[
                'events' => $events,
                'propositions' => $propositions,
                'products' => $products,
                'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,

            ]);
        }
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }




}
