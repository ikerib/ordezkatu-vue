<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\User;
use App\Form\JobType;
use App\Repository\EmployeeZerrendaRepository;
use App\Repository\JobRepository;
use App\Repository\TypeRepository;
use App\Repository\ZerrendaRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/admin/job")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/", name="job_index", methods={"GET"})
     * @param JobRepository $jobRepository
     *
     * @return Response
     */
    public function index(JobRepository $jobRepository): Response
    {
        return $this->render('job/index.html.twig', [
            'jobs' => $jobRepository->findBy([],['id'=>'DESC']),
        ]);
    }

    /**
     * @Route("/new", name="job_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $job = new Job();
        $job->setUser( $this->getUser() );
        $job->setCreated( new \DateTime() );
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($job);

            $entityManager->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/new.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="job_show", methods={"GET"})
     * @param Job                        $job
     *
     * @param TypeRepository             $typeRepository
     * @param EmployeeZerrendaRepository $employeeZerrendaRepository
     * @param SerializerInterface        $serializer
     *
     * @return Response
     */
    public function show(Job $job,
                         TypeRepository $typeRepository,
                         EmployeeZerrendaRepository $employeeZerrendaRepository,
                         SerializerInterface $serializer): Response

    {
        $types = $typeRepository->findAll();


        return $this->render('job/show.html.twig', [
            'job'       => $serializer->serialize($job, 'json',  ['groups' => 'main']),
            'zerrenda'  => $serializer->serialize($job, 'json',  ['groups' => 'main']),
            'types'     => $serializer->serialize($types, 'json',  ['groups' => 'main']),

        ]);
    }

    /**
     * @Route("/{id}/edit", name="job_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Job     $job
     *
     * @return Response
     */
    public function edit(Request $request, Job $job): Response
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job_index');
        }

        return $this->render('job/edit.html.twig', [
            'job' => $job,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="job_delete", methods={"DELETE"})
     * @param Request $request
     * @param Job     $job
     *
     * @return Response
     */
    public function delete(Request $request, Job $job): Response
    {
        if ($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($job);
            $entityManager->flush();
        }

        return $this->redirectToRoute('job_index');
    }
}
