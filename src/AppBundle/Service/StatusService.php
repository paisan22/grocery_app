<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 10/05/2017
 * Time: 21:48
 */

namespace AppBundle\Service;

use AppBundle\Entity\Item;

class StatusService
{
    private $itemService;
    private $categoryService;

    /**
     * StatusService constructor.
     * @param $itemService
     * @param $categoryService
     */
    public function __construct(ItemService $itemService, CategoryService $categoryService)
    {
        $this->itemService = $itemService;
        $this->categoryService = $categoryService;
    }

    public function getTotalPriceItems(int $catID) {

        $items = $this->getItems($catID);

        $price = 0.00;
        foreach ($items as $item) {
            $price += $item->getPrice() * $item->getAmount();
        }

        return round($price, 2);
    }

    public function getNumberOfItems(int $catID) {
        return count($this->getItems($catID));
    }

    public function getEstimateShoppingTime(int $catID) {
        return $this->getNumberOfItems($catID) * 1.5;
    }

    public function getStatus(int $catID) {
        return array(
            'price' => $this->getTotalPriceItems($catID),
            'number' => $this->getNumberOfItems($catID),
            'time' => $this->getEstimateShoppingTime($catID)
        );
    }

    public function getItems(int $catID) {
        if ($catID == 0 ) {
            $items = $this->itemService->getAllItems();
        } else {
            $items = $this->itemService->getAllItemsByCategory($catID);
        }
        return $items;
    }

}