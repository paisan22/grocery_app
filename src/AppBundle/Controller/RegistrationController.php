<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 06/05/2017
 * Time: 15:38
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegistrationController
 * @package AppBundle\Controller
 */
class RegistrationController extends Controller
{
    /**
     * @Route("/register", name = "register")
     */
    public function registration() {

        return $this->render(':login:registration.html.twig');
    }

    /**
     * @Route("/register_action", name = "register_action")
     * @Method("POST")
     */
    public function registerAction(Request $request) {

        $registerUser = $this->get('mediator')->registerUser($request);

        if (isset($registerUser['error'])) {
            return $this->render('login/registration.html.twig', $registerUser);
        }
        return $this->redirectToRoute('login');
    }
}