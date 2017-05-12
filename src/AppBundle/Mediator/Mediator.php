<?php

/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 25/04/2017
 * Time: 18:45
 */

namespace AppBundle\Mediator;

use AppBundle\Service\CategoryService;
use AppBundle\Service\ItemService;
use AppBundle\Service\SerializeService;
use AppBundle\Service\StatusService;
use AppBundle\Service\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Mediator
 * @package AppBundle\Mediator
 */
class Mediator
{

    private $itemService;
    private $userService;
    private $categoryService;
    private $serializeService;
    private $statusService;

    /**
     * Mediator constructor.
     * @param ItemService $itemService
     */
    public function __construct(
        ItemService $itemService,
        UserService $userService,
        CategoryService $categoryService,
        SerializeService $serializeService,
        StatusService $statusService)
    {
        $this->itemService = $itemService;
        $this->userService = $userService;
        $this->categoryService = $categoryService;
        $this->serializeService = $serializeService;
        $this->statusService = $statusService;
    }

    public function addItem(\stdClass $data) {
        return $this->itemService->addItem($data);
    }

    /**
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getItemByName(string $name) {
        return $this->itemService->getItemByName($name);
    }

    /**
     */
    public function getAllItems() {
        return $this->itemService->getAllItems();
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteItem(int $id) {
        return $this->itemService->deleteItem($id);
    }

    public function updateItem(Request $request) {
        return $this->itemService->updateItem($request);
    }

    public function searchItem(string $search) {
        return $this->itemService->searchItem($search);
    }

    public function getStatus(int $catID) {
        return $this->statusService->getStatus($catID);
    }

    public function registerUser(Request $request) {
        return $this->userService->registerUser($request);
    }

    public function addCategory(Request $request) {
        return $this->categoryService->addCategory($request);
    }

    public function getAllCategories() {
        return $this->categoryService->getAllCategories();
    }

    public function serialize(array $data) {
        return $this->serializeService->serialize($data);
    }

    public function getAllSerializedItems() {
        return $this->serializeService->getAllSerializedItems();
    }

    public function getNumberOfCategories() {
        return $this->categoryService->getNumberOfCategories();
    }

    public function getAllSerializedCategories() {
        return $this->serializeService->getAllSerializedCategories();
    }

    public function getAllItemsByCategory(int $id) {
        return $this->itemService->getAllItemsByCategory($id);
    }

    public function deleteCategory(int $catID) {
        return $this->categoryService->deleteCategory($catID);
    }

    public function editCategory(int $catID, string $value) {
        return $this->categoryService->editCategory($catID, $value);
    }
}