<?php

/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 25/04/2017
 * Time: 18:45
 */

namespace AppBundle\Mediator;

use AppBundle\Service\ItemService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Mediator
 * @package AppBundle\Mediator
 */
class Mediator
{
    /**
     * @var ItemService
     */
    private $itemService;

    /**
     * Mediator constructor.
     * @param ItemService $itemService
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addItem(Request $request) {
        return $this->itemService->addItem($request);
    }

    /**
     * @param string $name
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getItemByName(string $name) {
        return $this->itemService->getItemByName($name);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
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

}