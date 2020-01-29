<?php

namespace App\Controller\Api;

use App\Entity\Job;
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
class ApiJobController extends AbstractFOSRestController
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
     * @Rest\Get("/jobs", name="get_jobs", options={ "expose": true})
     */
    public function getJobs(): View
    {
        $jobs = $this->entityManager->getRepository(Job::class)->findAll();
        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($jobs, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Get("/job/{id}", name="get_job", options={ "expose": true})
     * @param Job $job
     *
     * @return View
     */
    public function getJob(Job $job): View
    {
        $ctx = new Context();
        $ctx->addGroup('main');

        return View::create($job, Response::HTTP_OK)->setContext($ctx);
    }

    /**
     * @Rest\Post("/job", name="post_job", options={ "expose":true })
     * @Rest\RequestParam(name="name", description="The name of the job", nullable=false)
     * @param ParamFetcher $paramFetcher
     *
     * @return View
     */
    public function postJob(ParamFetcher $paramFetcher): View
    {
        $name = $paramFetcher->get('name');
        $saila = $paramFetcher->get('saila');
        if ($name) {
            $job = new Job();
            $job->setName($name);
            if ($saila) {
                $job->setSaila($saila);
            }
            $this->entityManager->persist($job);
            $this->entityManager->flush();
            $ctx = new Context();
            $ctx->addGroup('main');

            return View::create($job, Response::HTTP_CREATED)->setContext($ctx);
        }

        return View::create(['name' => 'This cannot be null.'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Put("/job/{id}", name="put_job", options={ "expose": true })
     * @Rest\RequestParam(name="name", description="Jobren izena", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param Job          $job
     *
     * @return View
     */
    public function putJob(ParamFetcher $paramFetcher, Job $job): View
    {
        $name = $paramFetcher->get('name');
        if ('' !== trim($name)) {
            $job->setName($name);
            $this->entityManager->persist($job);
            $this->entityManager->flush();

            return View::create(null, Response::HTTP_NO_CONTENT);
        }

        return View::create(['name' => 'Ezin du hutsik egon'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @Rest\Delete("/job/{id}", name="delete_job", options={ "expose": true})
     * @param Job $job
     *
     * @return View
     */
    public function deleteJob(Job $job): View
    {
        $this->entityManager->remove($job);
        $this->entityManager->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
    }
}
