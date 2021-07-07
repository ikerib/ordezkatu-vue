<?php


namespace App\Controller\Api;


use App\Entity\Arrazoia;
use App\Entity\Municipio;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiArrazoiakController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Get("/arrazoiak", name="get_arrazoiak", options={ "expose": true})
     */
    public function getArrazoiak(): View
    {
        $arrazoiak = $this->em->getRepository(Arrazoia::class)->findAll();

        if (null === $arrazoiak) {
            return new View('There is no template with such id', Response::HTTP_NOT_FOUND);
        }

        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($arrazoiak, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Get("/arrazoiak/{id}", name="get_arrazoia", options={ "expose": true})
     */
    public function getArrazoia($id): View
    {
        $arrazoia = $this->em->getRepository(Arrazoia::class)->find($id);

        if (null === $arrazoia) {
            return new View('There is no template with such id', Response::HTTP_NOT_FOUND);
        }

        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($arrazoia, Response::HTTP_OK)->setContext($ctx);
    }

}
