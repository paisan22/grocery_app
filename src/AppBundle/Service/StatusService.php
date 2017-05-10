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

    public function getTotalPriceItems() {
        $items = $this->itemService->getAllItems();
        $price = 0.00;
        foreach ($items as $item) {
            $price += $item->getPrice() * $item->getAmount();
        }
        return round($price, 2);
    }

    public function getNumberOfItems() {
        return count($this->itemService->getAllItems());
    }

    public function getEstimateShoppingTime() {
        return $this->getNumberOfItems() * 1.5;
    }

    public function getStatus() {
        return array(
            'price' => $this->getTotalPriceItems(),
            'number' => $this->getNumberOfItems(),
            'time' => $this->getEstimateShoppingTime()
        );
    }

}