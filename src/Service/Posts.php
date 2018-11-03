<?php


namespace App\Service;

use App\Entity\Comments;
use App\Entity\Post;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class Posts
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repo;

    private $commentRepo;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repo = $this->em->getRepository(Post::class);
        $this->commentRepo = $this->em->getRepository(Comments::class);
    }

    /**
     * @return Post[]
     * @return Comments []
     */
    public function getAll()
    {
        return $this->repo->findAll();
    }

    /**
     * @return Post
     * @return Comments
     */
    public function getById($id): ?Post
    {
        return$this->repo->find($id);
    }
}