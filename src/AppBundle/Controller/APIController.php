<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 25/04/2017
 * Time: 18:48
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class APIController
 * @package AppBundle\Controller
 *
 * @Route("/api", name="api")
 */
class APIController extends Controller
{
    /**
     * @Route("/item", name="add_product")
     * @Method("POST")
     */
    public function addItem(Request $request) {
        return $this->get('mediator')->addItem($request);
    }

    /**
     * @Route("/item/{name}", name="get_item")
     * @Method("GET")
     */
    public function getItemByName(string $name) {
        $mediator = $this->get('mediator');
        return $mediator->getItemByName($name);

    }

    /**
     * @Route("/items", name="get_all_items")
     * @Method("GET")
     */
    public function getAllItems() {
        return $this->get('mediator')->getAllItems();
    }

    /**
     * @Route("/item/{id}", name="delete_item", requirements={"id": "\d+"})
     * @Method("DELETE")
     */
    public function deleteItem($id) {
        return $this->get('mediator')->deleteItem($id);
    }

}