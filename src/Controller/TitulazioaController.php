<?php

namespace App\Controller;

use App\Entity\Titulazioa;
use App\Form\TitulazioaType;
use App\Repository\TitulazioaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/titulazioa")
 */
class TitulazioaController extends AbstractController
{
    /**
     * @Route("/", name="titulazioa_index", methods={"GET"})
     * @param TitulazioaRepository $titulazioaRepository
     *
     * @return Response
     */
    public function index(TitulazioaRepository $titulazioaRepository): Response
    {
        return $this->render('titulazioa/index.html.twig', [
            'titulazioas' => $titulazioaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="titulazioa_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $titulazioa = new Titulazioa();
        $form = $this->createForm(TitulazioaType::class, $titulazioa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($titulazioa);
            $entityManager->flush();

            return $this->redirectToRoute('titulazioa_index');
        }

        return $this->render('titulazioa/new.html.twig', [
            'titulazioa' => $titulazioa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="titulazioa_show", methods={"GET"})
     * @param Titulazioa $titulazioa
     *
     * @return Response
     */
    public function show(Titulazioa $titulazioa): Response
    {
        return $this->render('titulazioa/show.html.twig', [
            'titulazioa' => $titulazioa,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="titulazioa_edit", methods={"GET","POST"})
     * @param Request    $request
     * @param Titulazioa $titulazioa
     *
     * @return Response
     */
    public function edit(Request $request, Titulazioa $titulazioa): Response
    {
        $form = $this->createForm(TitulazioaType::class, $titulazioa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('titulazioa_index');
        }

        return $this->render('titulazioa/edit.html.twig', [
            'titulazioa' => $titulazioa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="titulazioa_delete", methods={"DELETE"})
     * @param Request    $request
     * @param Titulazioa $titulazioa
     *
     * @return Response
     */
    public function delete(Request $request, Titulazioa $titulazioa): Response
    {
        if ($this->isCsrfTokenValid('delete'.$titulazioa->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($titulazioa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('titulazioa_index');
    }
}
