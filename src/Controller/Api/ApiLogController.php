<?php

namespace App\Controller\Api;

use App\Entity\Log;
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
}
