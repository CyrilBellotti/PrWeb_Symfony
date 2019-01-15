<?php
/**
 * Created by PhpStorm.
 * User: cbellotti
 * Date: 19/04/2017
 * Time: 14:27
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class LegalController extends Controller
{

    /**
     * @Route("/legal", name="legalnotice")
     */
    public function legalDisplay(){
        return $this->render("@App/legal_notice/legal_mention.html.twig");
    }

}
