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
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ItemService
 * @package AppBundle\Service
 */
class ItemService extends Container
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
     * @param Request $request
     * @return JsonResponse
     */
    public function addItem(Request $request) {

        $jsonData = json_decode($request->getContent());
        $item = new Item();
        $item->setName($jsonData->name);
        $item->setAmount($jsonData->amount);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return new JsonResponse(array(
            'result' => 'item added'
        ));
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
     * @return JsonResponse
     */
    public function getAllItems() {
        $repo = $this->entityManager->getRepository('AppBundle:Item');
        $items = $repo->findAll();

        return new JsonResponse(json_decode($this->serialize($items)));
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
     * @param $data
     * @return string|\Symfony\Component\Serializer\Encoder\scalar
     */
    public function serialize($data) {
        $encoder = array(new JsonEncoder());
        $normalizer = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizer, $encoder);

        return $serializer->serialize($data, 'json');
    }
}