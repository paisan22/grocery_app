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
     * @Route("/login_check", name="login_check")
     */
    public function loginCheck() {

    }

    /**
     * @Route("/login_success", name="login_success")
     */
    public function loginSuccess () {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_overview');
        } else {
            return $this->redirectToRoute('homepage');
        }
    }

    /**
     * @Route("/login_failure", name="login_failure")
     */
    public function loginFailure()
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('login/login.html.twig', array(
            'error' => $error,
        ));
    }
}