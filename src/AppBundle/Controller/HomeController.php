<?php
/**
 * Created by PhpStorm.
 * User: Geert
 * Date: 19/06/2016
 * Time: 15:59
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('homepage/index.html.twig');
    }
}
{

}