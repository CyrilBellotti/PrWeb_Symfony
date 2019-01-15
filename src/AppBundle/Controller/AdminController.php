<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin", name="admin")
 */
class AdminController extends Controller{

    /**
     * @Route("/users", name="adminuser")
     */
    public function adminUser(Request $request){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $userTable = $em->getRepository("AppBundle:User");
        if($request->getMethod()=='GET'){
            if(isset($user)){
                $users = $userTable->findAll();
                return $this->render('@App/admin/adminuser.html.twig',[
                    'users' => $users,
                ]);
            }

        }
        $user = $userTable->find($_POST['userid']);
        $userRole = $user->getRoles();
        if($userRole[0]!='ROLE_SUPER_ADMIN'){
            $user->setRoles(array($_POST['role']));
            $em->persist($user);
            $em->flush();
        }
        return $this->redirectToRoute('adminuser');


    }

    /**
     * @Route("/", name="admin")
     */
    public function admin(){
        return $this->render('@App/admin/adminmenu.html.twig');
    }
}
