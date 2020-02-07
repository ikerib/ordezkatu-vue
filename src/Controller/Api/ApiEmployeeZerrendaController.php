<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiEmployeeZerrendaController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\Get("/employeezerrenda/{zerrendaid}", name="get_employeezerrenda", options={ "expose": true})
     *
     * @param $zerrendaid
     *
     * @return View|Response
     */
    public function getZerrenda($zerrendaid)
    {
        $employeezerrenda = $this->entityManager->getRepository( 'App:EmployeeZerrenda' )->findAllEmployeesFromZerrenda( $zerrendaid );

        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $employeezerrenda, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );
//        return View::create($zerrenda, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Get("/employeezerrenda/{zerrendaid}/position/{employeeid}", name="get_employeezerrenda_position_employee", options={ "expose": true})
     *
     * @param $zerrendaid
     *
     * @param $employeeid
     *
     * @return View|Response
     */
    public function getPosition($zerrendaid, $employeeid)
    {
        $employeezerrenda = $this->entityManager->getRepository( 'App:EmployeeZerrenda' )->findPosition( $employeeid, $zerrendaid );

        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $employeezerrenda, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );
    }
}
