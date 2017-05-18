<?php
/**
 * Created by PhpStorm.
 * User: paisanrietbroek
 * Date: 06/05/2017
 * Time: 15:55
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

class UserService
{
    private $entityManager;
    private $container;

    public function __construct(EntityManager $entityManager, Container $container)
    {
        $this->entityManager = $entityManager;
        $this->container = $container;
    }

    public function registerUser(Request $request) {

        try {
            $user = new User();
            $user->setUsername($request->get('username'));
            $user->setEmail($request->get('email'));
            $user->setRole('ROLE_USER');

            $userPasswordEncoder = $this->container->get('security.password_encoder');
            $encodePassword = $userPasswordEncoder->encodePassword($user, $request->get('password'));

            $user->setPassword($encodePassword);

            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $exception) {
            return array('error' => 'This username or e-mail is already exist');
        }
        return true;
    }

    public function getALlUsers() {
        return $this->entityManager->getRepository('AppBundle:User')->getUsersExceptAdmin();
    }

}