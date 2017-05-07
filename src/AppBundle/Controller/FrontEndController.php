<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 26/04/2017
 * Time: 21:59
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class FrontEndController
 * @package AppBundle\Controller
 *
 * @Security("has_role('ROLE_USER')")
 */
class FrontEndController extends Controller
{

    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     * @Template("default/index.html.twig")
     */
    public function homePage() {
        $mediator = $this->get('mediator');
        $allItems = $mediator->getAllItems();

        return array('items' => json_decode($allItems));
    }

    /**
     * @Route("/delete", name="delete_item")
     * @Method("DELETE")
     */
    public function deleteItem(Request $request) {
        $itemId = $request->get('id');
        $jsonResponse = $this->get('mediator')->deleteItem($itemId);
        return new JsonResponse($this->get('mediator')->getAllItems());
    }

    /**
     * @Route("/search", name="search_action")
     * @Method("GET")
     */
    public function getItems(Request $request) {
        $searchField = $request->get('searchField');

        $result = $this->get('mediator')->searchItem($searchField);

        return new JsonResponse($result);
    }

    /**
     * @Route("/add", name="add_item")
     * @Method("POST")
     */
    public function addNewItem(Request $request) {

        $data = json_decode($request->get('item'));

        if ($this->get('mediator')->addItem($data)) {
            return new JsonResponse($this->get('mediator')->getAllItems());
        }
        return null;
    }

    /**
     * @Route("/get_status", name="get_status")
     * @Method("GET")
     */
    public function getStatus() {
        return new JsonResponse($this->get('mediator')->getStatus());
    }

}