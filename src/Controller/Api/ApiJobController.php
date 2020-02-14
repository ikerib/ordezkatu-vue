<?php


namespace App\Controller\Api;

use App\Entity\Calls;
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
     * @Rest\Get("/job/{id}", name="get_job", options={ "expose": true})
     *
     * @param Job $job
     *
     * @return View|Response
     */
    public function getJob(Job $job)
    {
        $ctx = new Context();
        $ctx->addGroup('main');

        $view = $this->view( $job, Response::HTTP_OK )->setContext( $ctx );

        return $this->handleView( $view );
    }

    /**
     * @Rest\Post("/job/{id}/employee", name="post_job_add_employee", options={ "expose":true })
     * @Rest\RequestParam(name="employeeid", description="Id of the Employee", nullable=false)
     * @Rest\RequestParam(name="position", description="position on the list", nullable=false)
     * @param ParamFetcher $paramFetcher
     *
     * @param Job          $job
     *
     * @return View
     */
    public function postAddOneEmployeesToJob(ParamFetcher $paramFetcher, Job $job): View
    {
        $employeeid = $paramFetcher->get('employeeid');
        $employee = $this->em->getRepository( 'App:Employee' )->find( $employeeid );
        $position = $paramFetcher->get('position');

        if ($employee) {
            /** @var JobDetail $jobd */
            $jobd = new JobDetail();
            $jobd->setPosition( $position );
            $jobd->setJob( $job );
            $jobd->setEmployee( $employee );
            $this->em->persist($jobd);

            $this->em->flush();
            $ctx = new Context();
            $ctx->addGroup('main');
            return View::create($job, Response::HTTP_CREATED)->setContext($ctx);
        }

        return View::create(['employees' => 'This cannot be null.'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Rest\Delete("/jobdetail/{id}/delete", name="delete_jobdetail", options={ "expose": true})
     *
     *
     * @param JobDetail $jobDetail
     *
     * @return View
     */
    public function deleteZerrenda(JobDetail $jobDetail): View
    {
        $this->em->remove($jobDetail);
        $this->em->flush();

        return View::create(null, Response::HTTP_NO_CONTENT);
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
        $cont = 0;
        if ($employees) {
            $cont++;
            foreach ($employees as $emp) {
                /** @var Employee $employee */
                $employee = $this->em->getRepository( 'App:Employee' )->find( $emp[ 'id' ] );
                /** @var JobDetail $jobd */
                $jobd = new JobDetail();
                $jobd->setPosition( $cont );
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
