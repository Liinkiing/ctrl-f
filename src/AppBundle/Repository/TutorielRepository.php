<?php

namespace AppBundle\Repository;
use AppBundle\Entity\Tutoriel;
use AppBundle\Entity\Utilisateur;

/**
 * TutorielRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TutorielRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param $number
     * @param string $order
     * @return \AppBundle\Entity\Tutoriel[]
     */
    public function getFirstNth($number, $order = 'DESC') {
        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb->select('tutoriel')
            ->from('AppBundle:Tutoriel', 'tutoriel')
            ->orderBy('tutoriel.createdAt', $order)
            ->setMaxResults($number)
            ->getQuery()
            ->getResult();
    }

    public function findAll($order = 'DESC'){
        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb->select('tutoriel')
            ->from('AppBundle:Tutoriel', 'tutoriel')
            ->orderBy('tutoriel.createdAt', $order)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Utilisateur $user
     * @param $showFinished
     * @return Tutoriel[]
     */
    public function getTutorielsStartedBy(Utilisateur $user, $showFinished, $order = 'DESC'){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('tutoriel')
            ->from('AppBundle:Tutoriel', 'tutoriel')
            ->innerJoin('tutoriel.userProgression', 'tup')
            ->where('tup.user = :user')
            ->setParameter('user', $user)
            ->andWhere('tup.startedAt is not NULL');
        if(!$showFinished){
            $qb->andWhere('tup.finishedAt is NULL');
        }
            $qb->addOrderBy('tup.startedAt', $order);
        return $qb->getQuery()
            ->getResult();

    }





}
