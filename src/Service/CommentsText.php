<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 29.10.2018
 * Time: 1:07
 */

namespace App\Service;


use App\Entity\Comments;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class CommentsText
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repo;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository(Comments::class);

    }

    /**
     * @return CommentsText[]
     */
    public function getAll()
    {
        return $this->repo->findAll();
    }

}