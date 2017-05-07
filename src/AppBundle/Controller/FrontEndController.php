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
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
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
        $categories = $mediator->getAllCategories();

        return array(
            'items' => $allItems,
            'categories' => $categories
        );
    }

    /**
     * @Route("/delete", name="delete_item")
     * @Method("DELETE")
     */
    public function deleteItem(Request $request) {
        $mediator = $this->get('mediator');

        $itemId = $request->get('id');
        if (!$mediator->deleteItem($itemId)) {
            return new JsonResponse("cannot get items");
        }
        return new JsonResponse($mediator->getAllSerializedItems());
    }

    /**
     * @Route("/search", name="search_action")
     * @Method("GET")
     */
    public function searchItems(Request $request) {
        $searchField = $request->get('searchField');

        $mediator = $this->get('mediator');

        $result = $mediator->searchItem($searchField);


        return new JsonResponse($mediator->serialize($result));
    }

    /**
     * @Route("/add", name="add_item")
     * @Method("POST")
     */
    public function addNewItem(Request $request) {

        $mediator = $this->get('mediator');

        $data = json_decode($request->get('item'));

        if ($mediator->addItem($data)) {
            return new JsonResponse($mediator->getAllSerializedItems());
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

    /**
     * @Route("/add_category", name="add_category")
     * @Method("POST")
     */
    public function addCategory(Request $request) {
        $mediator = $this->get('mediator');
        if (!$mediator->addCategory($request)) {
            return new JsonResponse("cannot get categories");
        }
        return new JsonResponse($mediator->getAllSerializedCategories());
    }

    /**
     * @Route("/get_all_cat", name="get_all_cat")
     */
    public function getAllCat() {
        return $this->get('mediator')->getAllCategories();
    }

    /**
     * @Route("/get_all_by_category", name="get_all_by_category")
     * @Method("GET")
     */
    public function getAllItemsByCategory(Request $request) {
        $mediator = $this->get('mediator');
        $id = $request->get('id');
        $items = $mediator->getAllItemsByCategory($id);

        return new JsonResponse($mediator->serialize($items));
    }

    /**
     * @Route("/get_all_items", name="get_all_items")
     * @Method("GET")
     */
    public function getAllItems() {
        return new JsonResponse($this->get('mediator')->getAllSerializedItems());
    }

}