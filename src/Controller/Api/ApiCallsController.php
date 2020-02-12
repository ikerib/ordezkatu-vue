<?php

namespace App\Controller\Api;

use App\Entity\Calls;
use App\Repository\CallsRepository;
use App\Repository\EmployeeRepository;
use App\Repository\EmployeeZerrendaRepository;
use App\Repository\ErantzunaRepository;
use App\Repository\JobDetailRepository;
use App\Repository\TypeRepository;
use App\Repository\ZerrendaRepository;
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

    public function __construct( EntityManagerInterface $entityManager )
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\Get("/calls/{employeezerrendaid}", name="get_all_calls_by_employeezerrenda", options={ "expose": true})
     *
     * @param $employeezerrendaid
     *
     * @return View|Response
     */
    public function getCallsByEmployeeZerrenda( $employeezerrendaid )
    {
        $calls = $this->entityManager->getRepository( 'App:Calls' )->getCallsByEmployeeZerrenda( $employeezerrendaid );


        $ctx = new Context();
        $ctx->addGroup( 'main' );

        $view = $this->view( $calls, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );

    }

    /**
     * @Rest\Get("/calls/employeezerrenda/{employeezerrendaid}/{employeeid}", name="get_all_calls_by_employeezerrenda", options={ "expose": true})
     *
     * @param $employeezerrendaid
     *
     * @param $employeeid
     *
     * @return View|Response
     */
    public function getCallsByEmployeeZerrendaAndEmproyeeid( $employeezerrendaid, $employeeid )
    {
        $calls = $this->entityManager->getRepository( 'App:Calls' )->getCallsByEmployeeZerrendaAndEmployeeid( $employeezerrendaid, $employeeid );

        $ctx = new Context();
        $ctx->addGroup( 'main' );

        $view = $this->view( $calls, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );

    }


    /**
     * @Rest\Post("/calls", name="post_calls", options={ "expose":true })
     * @Rest\RequestParam(name="jobdetailid", description="Id of the JobDetail entity", nullable=false)
     * @Rest\RequestParam(name="employeeid", description="Id of the Employee", nullable=false)
     * @param ParamFetcher        $paramFetcher
     *
     * @param JobDetailRepository $jobDetailRepository
     *
     * @return View
     */
    public function postCalls(
        ParamFetcher $paramFetcher,
        JobDetailRepository $jobDetailRepository): View
    {
        $jobdetailid = $paramFetcher->get( 'jobdetailid' );
        $jobdetail = $this->entityManager->getRepository( 'App:JobDetail' )->find( $jobdetailid );

        $user = $this->getUser();

        if ( ( $jobdetail ) && ( $user ) ) {
            /** @var Calls $log */
            $call = new Calls();
            $call->setUser( $user );
            $call->setJobdetail( $jobdetail );
            $this->entityManager->persist( $call );
            $this->entityManager->flush();
            $ctx = new Context();
            $ctx->addGroup( 'main' );

            return View::create( $call, Response::HTTP_CREATED )->setContext( $ctx );
        }

        return View::create( [ 'name' => 'This cannot be null.' ], Response::HTTP_BAD_REQUEST );
    }

    /**
     * @Rest\Put("/calls/{id}", name="put_calls", options={ "expose":true })
     *
     * @Rest\RequestParam(name="erantzunaid", description="Id of the Erantzuna", nullable=false)
     * @Rest\RequestParam(name="notes", description="Notes of the call", nullable=true)
     * @param ParamFetcher        $paramFetcher
     *
     * @param ErantzunaRepository $erantzunaRepository
     * @param CallsRepository     $callsRepository
     *
     * @param                     $id
     *
     * @return View
     */
    public function putCalls( ParamFetcher $paramFetcher,
                              ErantzunaRepository $erantzunaRepository,
                              CallsRepository $callsRepository,
                              $id
    ): View
    {
        $call = $callsRepository->find( $id );

        $erantzunaid = $paramFetcher->get( 'erantzunaid' );
        $erantzuna   = $erantzunaRepository->find( $erantzunaid );

        $notes =$paramFetcher->get( 'notes' );

        if ( ( $call ) && ( $erantzuna ) ) {

            $call->setErantzuna( $erantzuna );
            $call->setNotes( $notes );
            $this->entityManager->persist($call);

            $this->entityManager->flush();
            $ctx = new Context();
            $ctx->addGroup( 'main' );

            return View::create( $call, Response::HTTP_CREATED )->setContext( $ctx );
        }

        return View::create( [ 'name' => 'This cannot be null.' ], Response::HTTP_BAD_REQUEST );
    }

    /**
     * @Rest\Delete("/calls/{id}", name="delete_calls", options={ "expose": true})
     *
     *
     * @param Calls $calls
     *
     * @return View
     */
    public function deleteZerrenda(Calls $calls): View
    {
        $this->entityManager->remove($calls);
        $this->entityManager->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
