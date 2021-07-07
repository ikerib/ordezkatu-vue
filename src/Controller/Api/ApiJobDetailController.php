<?php

namespace App\Controller\Api;

use App\Entity\JobDetail;
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
class ApiJobDetailController extends AbstractFOSRestController
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
     * @Rest\Put("/jobdetail/{id}/position", name="put_job_detail_set_position", options={ "expose":true })
     * @Rest\RequestParam(name="position", description="Number. Position to set.", nullable=false)
     * @param ParamFetcher $paramFetcher
     * @param JobDetail    $jobDetail
     *
     * @return View
     */
    public function putDoChangePosition(ParamFetcher $paramFetcher, JobDetail $jobDetail) {
        $position = $paramFetcher->get( 'position' );
        $this->entityManager->persist($jobDetail->setPosition($position));
        $this->entityManager->flush();

        $ctx = new Context();
        $ctx->addGroup('main');
        return View::create($jobDetail, Response::HTTP_CREATED)->setContext($ctx);
    }

}
