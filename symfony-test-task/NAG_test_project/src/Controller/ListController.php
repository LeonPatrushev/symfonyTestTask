<?php

namespace App\Controller;

use App\Entity\Acnt;
use App\Entity\Client;
use App\Entity\Payment;
use App\Repository\ClientRepository;
use App\Repository\PaymentRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{

    #[Route('/list', name: 'list')]
    public function indexAction(ManagerRegistry $doctrine): Response
    {

        $type_client = $doctrine->getRepository(Client::class)->findAll();

        return $this->render('list/index.html.twig', [
            'type_client' => $type_client,
        ]);
    }

    #[Route('/list/show', name: 'showReport', methods:"POST")]
    public function showAction(PaymentRepository $doctrine, Request $request): Response
    {

        $select_type_client = $request->request->get('select_type_client');
        $select_date = $request->request->get('month');
        $select_date = new DateTime($select_date);
        
        $report = $doctrine->getSelectTypeClient($select_type_client, $select_date);

        $full_report = $this->render('layouts/report_table.html.twig', [
            'report' => $report,
        ]);

        return new Response ($full_report);
    }
}
