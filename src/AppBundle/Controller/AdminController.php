<?php
/**
 * Created by PhpStorm.
 * User: Geert
 * Date: 18/06/2016
 * Time: 19:38
 */

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{

    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction() {

        return $this->render('admin/admin.html.twig', array(
            'user' => $this->getUser()
        ));
    }
}