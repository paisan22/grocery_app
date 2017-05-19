<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 15/05/2017
 * Time: 00:31
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;

/**
 * Class AdminController
 * @package AppBundle\Controller
 *
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin_overview")
     * @Method("GET")
     */
    public function adminOverview() {
        return $this->render(':admin:dashboard.html.twig', array(
            'users' => $this->get('mediator')->getAllUsers()
        ));
    }

    /**
     * @Route("/add_user_page", name="add_user_page")
     * @Method("GET")
     */
    public function addUserPage() {
         return $this->render('admin/add_user.html.twig');
    }

    /**
     * @Route("/add_user", name="add_user")
     * @Method("POST")
     */
    public function addUser(Request $request) {
        $registerUser = $this->get('mediator')->registerUser($request);

        return $this->render('admin/dashboard.html.twig', array(
            'users' => $this->get('mediator')->getAllUsers()
        ));
    }
}