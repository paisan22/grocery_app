<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 07/05/2017
 * Time: 16:06
 */

namespace AppBundle\Service;


use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CategoryService
{
    private $entityManager;
    private $container;

    /**
     * CategoryService constructor.
     * @param $entityManager
     */
    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    public function addCategory(Request $request) {

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $category = new Category();
        $category->setName($request->get('name'));
        $category->setUser($user);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return true;
    }

    public function getAllCategories() {
        return $this->entityManager->getRepository('AppBundle:Category')->findAll();
    }

    public function getNumberOfCategories() {
        return count($this->getAllCategories());
    }

}