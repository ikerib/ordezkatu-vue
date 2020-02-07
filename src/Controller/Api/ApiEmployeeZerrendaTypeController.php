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
class ApiEmployeeZerrendaTypeController extends AbstractFOSRestController
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
     * @Rest\Get("/employeezerrendatype/{employeeid}/{zerrendaid}", name="get_employeezerrendatype", options={ "expose": true})
     *
     * @param $employeeid
     * @param $zerrendaid
     *
     * @return View|Response
     */
    public function getEmpZer($employeeid,$zerrendaid)
    {
//        $ezt = $this->entityManager->getRepository( 'App:EmployeeZerrendaType' )->getEmployeeZerrenda( $employeeid, $zerrendaid );
        $ezt = $this->entityManager->getRepository( 'App:EmployeeZerrendaType' )->findBy([
            'employee'=> $employeeid,
            'zerrenda' => $zerrendaid
                                                                                         ]);

        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $ezt, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );
    }


}
