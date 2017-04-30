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
     * @Route("/item", name="api_add_item")
     * @Method("POST")
     */
    public function addItem(Request $request) {
        return $this->get('mediator')->addItem(json_decode($request->getContent()));
    }

    /**
     * @Route("/item/{name}", name="api_get_item")
     * @Method("GET")
     */
    public function getItemByName(string $name) {
        $mediator = $this->get('mediator');
        return $mediator->getItemByName($name);

    }

    /**
     * @Route("/items", name="api_get_all_items")
     * @Method("GET")
     */
    public function getAllItems() {
        return new JsonResponse(json_decode($this->get('mediator')->getAllItems()));
    }

    /**
     * @Route("/item/{id}", name="api_delete_item", requirements={"id": "\d+"})
     * @Method("DELETE")
     */
    public function deleteItem($id) {
        return $this->get('mediator')->deleteItem($id);
    }

    /**
     * @Route("/item", name="api_update_item")
     * @Method("PUT")
     */
    public function updateItem(Request $request) {
        return $this->get('mediator')->updateItem($request);
    }

}