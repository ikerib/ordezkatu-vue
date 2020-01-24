<?php

namespace App\Controller\Api;

use App\Entity\Zerrenda;
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
class ApiZerrendaController extends AbstractFOSRestController
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
     * @Rest\Get("/zerrendas", name="get_zerrendas", options={ "expose": true})
     */
    public function getZerrendas(): View
    {
        $zerrendas = $this->entityManager->getRepository(Zerrenda::class)->findAll();
        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($zerrendas, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Get("/zerrenda/{id}", name="get_zerrenda", options={ "expose": true})
     * @param Zerrenda $zerrenda
     *
     * @return View|Response
     */
    public function getZerrenda(Zerrenda $zerrenda)
    {
        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $zerrenda, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );
//        return View::create($zerrenda, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Post("/zerrenda", name="post_zerrenda", options={ "expose":true })
     * @Rest\RequestParam(name="name", description="The name of the list", nullable=false)
     * @param ParamFetcher $paramFetcher
     *
     * @return View
     */
    public function postZerrenda(ParamFetcher $paramFetcher): View
    {
        $name = $paramFetcher->get('name');
        if ($name) {
            $zerrenda = new Zerrenda();
            $zerrenda->setName($name);
            $this->entityManager->persist($zerrenda);
            $this->entityManager->flush();
            $ctx = new Context();
            $ctx->addGroup('main');

            return View::create($zerrenda, Response::HTTP_CREATED)->setContext($ctx);
        }

        return View::create(['name' => 'This cannot be null.'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Put("/zerrenda/{id}", name="put_zerrenda", options={ "expose": true })
     * @Rest\RequestParam(name="name", description="Zerrendaren izena", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param Zerrenda     $zerrenda
     *
     * @return View
     */
    public function putZerrenda(ParamFetcher $paramFetcher, Zerrenda $zerrenda): View
    {
        $name = $paramFetcher->get('name');
        if ('' !== trim($name)) {
            $zerrenda->setName($name);
            $this->entityManager->persist($zerrenda);
            $this->entityManager->flush();

            return View::create(null, Response::HTTP_NO_CONTENT);
        }

        return View::create(['name' => 'Ezin du hutsik egon'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\Delete("/zerrenda/{id}", name="delete_zerrenda", options={ "expose": true})
     * @param Zerrenda $zerrenda
     *
     * @return View
     */
    public function deleteZerrenda(Zerrenda $zerrenda): View
    {
        $this->entityManager->remove($zerrenda);
        $this->entityManager->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
