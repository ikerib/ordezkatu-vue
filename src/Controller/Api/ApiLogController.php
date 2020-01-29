<?php

namespace App\Controller\Api;

use App\Entity\Log;
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
class ApiLogController extends AbstractFOSRestController
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
     * @Rest\Get("/logs/employeezerrenda/{employeezerrendaid}", name="get_all_logs_by_employeezerrenda", options={ "expose": true})
     *
     * @param $employeezerrendaid
     *
     * @return View|Response
     */
    public function getLogsByEmployeeZerrenda($employeezerrendaid)
    {
        $employeezerrenda = $this->entityManager->getRepository( 'App:Log' )->getLogsByEmployeeZerrenda( $employeezerrendaid );

        if (!$employeezerrenda) {
            throw new HttpException( 400, 'Ez da zerrenda topatu.' );
        }


        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $employeezerrenda, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );

    }


    /**
     * @Rest\Get("/log/{zerrendaid}/{employeeid}/{userid}", name="post_call", options={ "expose": true})
     * @param $zerrendaid
     * @param $employeeid
     * @param $userid
     *
     * @return View|Response
     */
    public function getZerrenda($zerrendaid, $employeeid, $userid)
    {
        $zerrenda = $this->entityManager->getRepository( 'App:Zerrenda' )->find( $zerrendaid );
        $employee = $this->entityManager->getRepository( 'App:Employee' )->find( $employeeid );
        $employeeZerrenda = $this->entityManager->getRepository( 'App:EmployeeZerrenda' )->findOneByEmployeeZerrenda( $employeeid, $zerrendaid );
        $user = $this->entityManager->getRepository( 'App:User' )->find( $userid );

        if ((!$user)||(!$zerrenda)||(!$employee) ){
            throw new HttpException( 400, 'Zerrenda, Langilea edo deiaren egilea ez da topatu.' );
        }

        /** @var Log $log */
        $log = new Log();
        $log->setEmployee( $employee );
        $log->setZerrenda( $zerrenda );
        $log->setEmployeezerrenda( $employeeZerrenda );
        $log->setUser( $user );
        $log->setName( 'Deia' );
        $log->setDescription( $user->getDisplayname() . ' erabiltzaileak dei berria: ' . $employee->getName() . ' ' . $employee->getAbizena1() . '-ri.
            Zerrenda: ' . $employeeZerrenda->getName() . ''
         );
        $this->entityManager->persist($log);
        $this->entityManager->flush();


        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $log, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );

    }


    /**
     * @Rest\Post("/logs", name="post_log", options={ "expose":true })
     * @Rest\RequestParam(name="employeezerrendaid", description="Id of the EmployeeZerrenda", nullable=false)
     * @param ParamFetcher               $paramFetcher
     *
     * @param EmployeeZerrendaRepository $employeeZerrendaRepository
     *
     * @return View
     */
    public function postLog(ParamFetcher $paramFetcher, EmployeeZerrendaRepository $employeeZerrendaRepository): View
    {
        $employeeZerrendaid = $paramFetcher->get('employeezerrendaid');
        $employeeZerrenda = $employeeZerrendaRepository->find( $employeeZerrendaid );
        $user = $this->getUser();

        if ($employeeZerrenda) {
            /** @var Log $log */
            $log = new Log();
            $log->setName( 'Dei berria' );
            $log->setUser( $user );
            $log->setEmployeezerrenda( $employeeZerrenda );
            $log->setEmployee( $employeeZerrenda->getEmployee() );
            $log->setZerrenda( $employeeZerrenda->getZerrenda() );

            $this->entityManager->persist($log);
            $this->entityManager->flush();
            $ctx = new Context();
            $ctx->addGroup('main');

            return View::create($log, Response::HTTP_CREATED)->setContext($ctx);
        }

        return View::create(['name' => 'This cannot be null.'], Response::HTTP_BAD_REQUEST);
    }
}
