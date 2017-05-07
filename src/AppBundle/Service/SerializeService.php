<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 07/05/2017
 * Time: 20:00
 */

namespace AppBundle\Service;


use AppBundle\Mediator\Mediator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializeService
{
    private $serializer;
    private $container;

    /**
     * SerializeService constructor.
     * @param $encoder
     * @param $normalizer
     */
    public function __construct(JsonEncoder $encoder,ObjectNormalizer $normalizer, Container $container)
    {
        $this->serializer = new Serializer(array($normalizer), array($encoder));
        $this->container = $container;
    }

    public function serialize(array $data) {
        return $this->serializer->serialize($data, 'json');
    }

    public function getAllSerializedItems() {
        $mediator = $this->container->get('mediator');
        return $this->serialize($mediator->getAllItems());
    }

    public function getAllSerializedCategories() {
        $mediator = $this->container->get('mediator');
        return $this->serialize($mediator->getAllCategories());
    }
}