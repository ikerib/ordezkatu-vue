<?php

namespace App\Controller\Api;

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
class ApiMunicipiosController extends AbstractFOSRestController
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
     * @Rest\Get("/provincias", name="get_provincias", options={ "expose": true})
     */
    public function getProvincias(): View
    {
        $provincias = $this->em->getRepository(Municipio::class)->findAllProvincias();

        if (null === $provincias) {
            return new View('There is no template with such id', Response::HTTP_NOT_FOUND);
        }

        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($provincias, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Get("/provincia/{provincia}/municipios", name="get_provincia_municipios", options={ "expose": true})
     *
     * @param $provincia
     *
     * @return View
     */
    public function getProvincia($provincia): View
    {
        $municipios = $this->em->getRepository(Municipio::class)->findAllMunicipiosByProvincia($provincia);

        if (null === $municipios) {
            return new View('There is no template with such id', Response::HTTP_NOT_FOUND);
        }

        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($municipios, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Get("/municipio/{codpostal}", name="get_municipios_by_codpostal", options={ "expose": true})
     *
     * @param $codpostal
     *
     * @return View
     */
    public function getMunicipio($codpostal): View
    {
        $municipio = $this->em->getRepository(Municipio::class)->findMunicipioByCodPostal($codpostal);
        if (null === $municipio) {
            return new View('There is no template with such id', Response::HTTP_NOT_FOUND);
        }

        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($municipio, Response::HTTP_OK)->setContext($ctx);
    }
}
