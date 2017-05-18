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
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminController
 * @package AppBundle\Controller
 *
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminController
{
    /**
     * @Route("/", name="admin_overview")
     * @Method("GET")
     */
    public function adminOverview() {
        return new Response("Admin overview");
    }
}