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
class ItemService
{
    /**
     * @var ObjectManager
     */
    private $entityManager;
    private $container;

    /**
     * ItemService constructor.
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager, Container $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }


    /**
     * @return JsonResponse
     */
    public function addItem(\stdClass $jsonData) {

        $item = new Item();
        $item->setName($jsonData->name);
        $item->setAmount($jsonData->amount);
        $item->setPrice($jsonData->price);

        $category = $this->entityManager->getRepository('AppBundle:Category')->findOneBy(
            array('name' => $jsonData->category)
        );

        $item->setCategory($category);

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $item->setUser($user);


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
            return new JsonResponse($item);
        } else {
            return new JsonResponse(array('result' => 'item not exists'));
        }
    }

    /**
     */
    public function getAllItems() {
        $repo = $this->entityManager->getRepository('AppBundle:Item');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $items = $repo->findBy(array('user' => $user));

        return $items;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function deleteItem(int $id) {
        $item = $this->entityManager->getRepository('AppBundle:Item')->find($id);

        $this->entityManager->remove($item);
        $this->entityManager->flush();

        return new JsonResponse(true);
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

        return new JsonResponse($item);

    }

    public function searchItem(string $search) {
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        return $this->entityManager->getRepository('AppBundle:Item')->search($search, $user);
    }

    public function getAllItemsByCategory(int $id) {
        $category = $this->entityManager->getRepository('AppBundle:Category')->find($id);
        return $this->entityManager->getRepository('AppBundle:Item')->findBy(array('category' => $category));
    }

    public function changeCheckedStatus(int $itemID, bool $checked) {
        $item = $this->entityManager->getRepository('AppBundle:Item')->find($itemID);
        $item->setIsChecked($checked);

        $this->entityManager->flush();

        return true;
    }
}