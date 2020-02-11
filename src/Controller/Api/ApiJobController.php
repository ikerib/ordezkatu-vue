<?php


namespace App\Controller\Api;

use App\Entity\Employee;
use App\Entity\Job;
use App\Entity\JobDetail;
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
class ApiJobController extends AbstractFOSRestController
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
     * @Rest\Post("/job/{id}/employees", name="post_job_employee", options={ "expose":true })
     * @Rest\RequestParam(name="employees", description="array of employees", nullable=false)
     * @param ParamFetcher $paramFetcher
     *
     * @param Job          $job
     *
     * @return View
     */
    public function postAddEmployeesToJob(ParamFetcher $paramFetcher, Job $job): View
    {
        $employees = $paramFetcher->get('employees');
        if ($employees) {
            foreach ($employees as $emp) {
                /** @var Employee $employee */
                $employee = $this->em->getRepository( 'App:Employee' )->find( $emp[ 'id' ] );
                /** @var JobDetail $jobd */
                $jobd = new JobDetail();
                $jobd->setJob( $job );
                $jobd->setEmployee( $employee );
                $this->em->persist($jobd);
            }
            $this->em->flush();
            $ctx = new Context();
            $ctx->addGroup('main');
            return View::create($job, Response::HTTP_CREATED)->setContext($ctx);
        }

        return View::create(['employees' => 'This cannot be null.'], Response::HTTP_BAD_REQUEST);
    }

}
