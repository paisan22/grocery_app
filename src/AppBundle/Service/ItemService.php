<?php

/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 25/04/2017
 * Time: 18:40
 */
namespace AppBundle\Service;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Item;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ItemService
 * @package AppBundle\Service
 */
class ItemService
{
    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * ItemService constructor.
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @return JsonResponse
     */
    public function addItem(\stdClass $jsonData) {

        $item = new Item();
        $item->setName($jsonData->name);
        $item->setAmount($jsonData->amount);
        $item->setPrice($jsonData->price);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return new JsonResponse(true);
    }

    /**
     * @param string $name
     * @return JsonResponse
     */
    public function getItemByName(string $name) {
        $itemRepository = $this->entityManager->getRepository('AppBundle:Item');
        $item = $itemRepository->findOneByName($name);

        if ($item instanceof Item) {
            return new JsonResponse(json_decode($this->serialize($item)));
        } else {
            return new JsonResponse(array('result' => 'item not exists'));
        }
    }

    /**
     */
    public function getAllItems() {
        $repo = $this->entityManager->getRepository('AppBundle:Item');
        $items = $repo->findAll();

        return $this->serialize($items);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteItem(int $id) {
        $item = $this->entityManager->getRepository('AppBundle:Item')->find($id);

        $this->entityManager->remove($item);
        $this->entityManager->flush();

        return new JsonResponse(array('result' => 'item deleted'));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateItem(Request $request) {

        $data = json_decode($request->getContent());

        $item = $this->entityManager->getRepository('AppBundle:Item')->find($data->id);
        $item->setName($data->name);
        $item->setAmount($data->amount);
        $item->setPrice($data->price);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return new JsonResponse(json_decode($this->serialize($item)));

    }

    /**
     * @param $data
     * @return string|\Symfony\Component\Serializer\Encoder\scalar
     */
    public function serialize($data) {
        $encoder = array(new JsonEncoder());
        $normalizer = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoder);

        return $serializer->serialize($data, 'json');
    }


    public function searchItem(string $search) {
        return $this->serialize($this->entityManager->getRepository('AppBundle:Item')->search($search));
    }

    public function getTotalPriceItems() {
        $items = $this->entityManager->getRepository("AppBundle:Item")->findAll();
        $price = 0.00;
        foreach ($items as $item) {
            $price+= $item->getPrice() * $item->getAmount();
        }
        return round($price, 2);
    }

    public function getNumberOfItems() {
        return count($this->entityManager->getRepository("AppBundle:Item")->findAll());
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