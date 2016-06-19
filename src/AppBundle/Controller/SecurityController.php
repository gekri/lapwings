<?php
/**
 * Created by PhpStorm.
 * User: Geert
 * Date: 18/06/2016
 * Time: 19:42
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Form\ChangePasswordType;
use AppBundle\Model\ChangePassword;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {

        if ($this->getUser()) {
            return $this->redirect($this->generateUrl('admin'));
        }

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'authentication/login.html.twig', array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
                'user' => $this->getUser()
            )
        );
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {

    }

    /**
     * @Route("/admin/password", name="password")
     */
    public function changePasswordAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $changePasswordModel = new ChangePassword();
        /*
         * http://symfony.com/doc/current/best_practices/forms.html#building-forms
         */
        $form = $this->createForm(ChangePasswordType::class, $changePasswordModel);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordSubmit = $form->getData();
            $encodedPassword = password_hash($passwordSubmit->getNewPassword(), PASSWORD_BCRYPT);
            $user->setPassword($encodedPassword);
            $em->persist($user);
            $em->flush();
            return $this->redirect($this->generateUrl('admin'));
        }

        return $this->render('authentication/password.html.twig', array(
            'form' => $form->createView(),
            'user' => $this->getUser()
        ));
    }

}