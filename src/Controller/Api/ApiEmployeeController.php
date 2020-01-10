<?php

namespace App\Controller\Api;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiEmployeeController extends AbstractFOSRestController
{

    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Rest\Get("/search/{q}", name="api_employee_handle_search", options={ "expose": true})
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @param                                           $q
     *
     * @return \FOS\RestBundle\View\View
     */
    public function search(Request $request, $q): \FOS\RestBundle\View\View
    {
        $employees = $this->em->getRepository(Employee::class)->hangleSearch($q);
        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($employees, Response::HTTP_OK)->setContext($ctx);
    }
}
