<?php

namespace App\Repository;

use App\Entity\Reaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reaction[]    findAll()
 * @method Reaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReactionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reaction::class);
    }

    public function countPostReactionsByLegend($legendName, $postId)
    {
        try {
            return $this->createQueryBuilder('r')
                ->select('count(r.id)')
                ->Where('r.legend = :val')
                ->andWhere('r.post = :val2')
                ->setParameter('val', $legendName)
                ->setParameter('val2', $postId)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return $e;
        }
    }

    public function countPostReactionsById($postId)
    {
        try {
            return $this->createQueryBuilder('r')
                ->select('count(r.id)')
                ->andWhere('r.post = :val')
                ->setParameter('val', $postId)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NonUniqueResultException $e) {
            return $e;
        }
    }
}
