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
 * @Route("/user")
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
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return array(
            'items' => $allItems,
            'categories' => $categories,
            'user' => $user->getUsername()
        );
    }

    /**
     * @Route("/category", name="category_page")
     * @Method("GET")
     * @Template("default/category.html.twig")
     */
    public function categoryPage() {
        $mediator = $this->get('mediator');
        $categories = $mediator->getAllCategories();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        return array(
            'categories' => $categories,
            'user' => $user->getUsername()
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
    public function getStatus(Request $request) {
        return new JsonResponse($this->get('mediator')->getStatus(intval($request->get('catID'))));
    }

    /**
     * @Route("/add_category", name="add_category")
     * @Method("POST")
     */
    public function addCategory(Request $request) {
        $mediator = $this->get('mediator');
        return new JsonResponse($mediator->addCategory($request));
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

    /**
     * @Route("/delete_category", name="delete_category")
     * @Method("DELETE")
     */
    public function deleteCategory(Request $request) {
        $catID = $request->get('id');

        return new JsonResponse($this->get('mediator')->deleteCategory($catID));
    }

    /**
     * @Route("/edit_category", name="edit_category")
     * @Method("PUT")
     */
    public function editCategory(Request $request) {
        $catID = $request->get('catID');
        $value = $request->get('value');

        return new JsonResponse($this->get('mediator')->editCategory($catID, $value));
    }

    /**
     * @Route("/change_check_status", name="change_check_status")
     * @Method("PUT")
     */
    public function changeCheckedStatus(Request $request) {
        $itemID = $request->get('itemID');
        $isChecked = $request->get('isChecked');

        return new JsonResponse($this->get('mediator')->changeCheckedStatus($itemID, $isChecked));
    }
}