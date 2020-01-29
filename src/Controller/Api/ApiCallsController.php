<?php

namespace App\Controller\Api;

use App\Entity\Call;
use App\Entity\Calls;
use App\Repository\EmployeeRepository;
use App\Repository\EmployeeZerrendaRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiCallsController extends AbstractFOSRestController
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
     * @Rest\Get("/calls/employeezerrenda/{employeezerrendaid}", name="get_all_calls_by_employeezerrenda", options={ "expose": true})
     *
     * @param $employeezerrendaid
     *
     * @return View|Response
     */
    public function getCallsByEmployeeZerrenda($employeezerrendaid)
    {
        $calls = $this->entityManager->getRepository( 'App:Calls' )->getCallsByEmployeeZerrenda( $employeezerrendaid );


        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $calls, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );

    }


    /**
     * @Rest\Post("/calls", name="post_calls", options={ "expose":true })
     * @Rest\RequestParam(name="employeezerrendaid", description="Id of the EmployeeZerrenda", nullable=false)
     * @Rest\RequestParam(name="employeeid", description="Id of the Employee", nullable=false)
     * @param ParamFetcher               $paramFetcher
     *
     * @param EmployeeZerrendaRepository $employeeZerrendaRepository
     *
     * @param EmployeeRepository         $employeeRepository
     *
     * @return View
     */
    public function postCalls(ParamFetcher $paramFetcher, EmployeeZerrendaRepository $employeeZerrendaRepository, EmployeeRepository $employeeRepository): View
    {
        $employeeZerrendaid = $paramFetcher->get('employeezerrendaid');
        $employeeZerrenda = $employeeZerrendaRepository->find( $employeeZerrendaid );

        $employeeid = $paramFetcher->get('employeeid');
        $employee = $employeeRepository->find( $employeeid );

        $user = $this->getUser();

        if (($employeeZerrenda) && ($employee) && ($user) ) {
            /** @var Calls $log */
            $call = new Calls();
            $call->setUser( $user );
            $call->setEmployeezerrenda( $employeeZerrenda );
            $call->setEmployee( $employeeZerrenda->getEmployee() );
            $this->entityManager->persist($call);
            $this->entityManager->flush();
            $ctx = new Context();
            $ctx->addGroup('main');

            return View::create($call, Response::HTTP_CREATED)->setContext($ctx);
        }

        return View::create(['name' => 'This cannot be null.'], Response::HTTP_BAD_REQUEST);
    }
}
