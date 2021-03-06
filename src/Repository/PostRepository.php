<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function pagination()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->getQuery();
    }

    public function search($search)
    {
        $query = $this->createQueryBuilder('p')
            ->where('p.title LIKE :s');

        if ($search->body) {
            $query->orWhere('p.body LIKE :s');
        }
        if ($search->comment) {
            $query->leftJoin('p.comments', 'c')
                ->orWhere('c.body LIKE :s');
        }

        return $query->setParameter('s', '%'.$search->title.'%')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $slug
     *
     * @return mixed
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getBySlugOrId($slug)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->Where('p.slug = :val')
            ->orWhere('p.id = :val')
            ->setParameter('val', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function newsletter()
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
