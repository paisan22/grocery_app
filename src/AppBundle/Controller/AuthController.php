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
class AuthController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Method({"GET", "POST"})
     */
    public function login(Request $request) {

        $authenticationUtils = $this->get('security.authentication_utils');

        $authenticationException = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(':default:auth.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $authenticationException
        ));
    }

    /**
     * @Route("/logout", name="logout")
     * @Method("GET")
     */
    public function logout() {
        $this->render(':default:auth.html.twig');
    }

}