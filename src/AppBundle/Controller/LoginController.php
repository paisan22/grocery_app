<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 02/05/2017
 * Time: 21:10
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AuthController
 * @package AppBundle\Controller
 */
class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Method("GET")
     */
    public function login() {

        return $this->render('login/login.html.twig', array('error' => false));
    }

    /**
     * @Route("/login_failure", name = "login_action")
     */
    public function loginAction() {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('login/login.html.twig', array(
            'error'         => $error,
        ));
    }


    /**
     * @Route("/logout", name="logout")
     * @Method("GET")
     */
    public function logout() {
        $this->render('login/login.html.twig');
    }

}