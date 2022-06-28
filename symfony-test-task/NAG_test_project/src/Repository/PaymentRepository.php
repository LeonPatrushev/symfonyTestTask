<?php

namespace App\Repository;

use App\Entity\Acnt;
use App\Entity\Client;
use App\Entity\Pay;
use App\Entity\Payment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Payment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Payment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Payment[]    findAll()
 * @method Payment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Payment::class);
    }

    public function getSelectTypeClient(int $selectType, \DateTime $date): array
    {
        $start_date = new \DateTime($date->format("Y-m"."-01"));
        $end_date = new \DateTime($date->format("Y-m"."-31"));
        $prev_month = $start_date->modify('-1 month');

        return $this->createQueryBuilder('c')
            ->select('acnt.name as acnt_name')
            ->addSelect("SUM(CASE WHEN c.data BETWEEN :prevMonth AND :from THEN c.summa ELSE :null END) balance")
            ->addSelect("SUM(CASE WHEN c.data BETWEEN :from AND :to AND (c.pay = 1 OR c.pay = 4) THEN c.summa ELSE :null END) profit")
            ->addSelect("SUM(CASE WHEN c.data BETWEEN :from AND :to AND c.pay = 2 THEN c.summa ELSE :null END) expenditure")
            ->addSelect("SUM(CASE WHEN c.data BETWEEN :from AND :to AND c.pay = 3 THEN c.summa ELSE :null END) recalculation")
            ->addSelect("SUM(CASE WHEN c.data BETWEEN :from AND :to THEN c.summa ELSE :null END) total")
            ->leftJoin(Acnt::class, 'acnt', 'with', 'c.acnt = acnt.id')
            ->leftJoin(Client::class, 'client', 'with', 'c.client = client.id')
            ->leftJoin(Pay::class, 'pay', 'with', 'c.pay = pay.id')
            ->where("client.type = CASE WHEN (:client = 1 OR :client = 2) THEN :client ELSE client.type END")
            ->groupBy('c.acnt')
            ->setParameters(array(
                'from' => $start_date,
                'to' => $end_date,
                'client' => $selectType,
                'prevMonth' => $prev_month,
                'null' => NULL
                ))
            ->getQuery()
            ->getResult();

    }
}
