<?php

namespace App\Controller;

use App\Entity\Erantzuna;
use App\Form\ErantzunaType;
use App\Repository\ErantzunaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/erantzuna")
 */
class ErantzunaController extends AbstractController
{
    /**
     * @Route("/", name="erantzuna_index", methods={"GET"})
     * @param ErantzunaRepository $erantzunaRepository
     *
     * @return Response
     */
    public function index(ErantzunaRepository $erantzunaRepository): Response
    {
        return $this->render('erantzuna/index.html.twig', [
            'erantzunas' => $erantzunaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="erantzuna_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $erantzuna = new Erantzuna();
        $form = $this->createForm(ErantzunaType::class, $erantzuna);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($erantzuna);
            $entityManager->flush();

            return $this->redirectToRoute('erantzuna_index');
        }

        return $this->render('erantzuna/new.html.twig', [
            'erantzuna' => $erantzuna,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="erantzuna_edit", methods={"GET","POST"})
     * @param Request   $request
     * @param Erantzuna $erantzuna
     *
     * @return Response
     */
    public function edit(Request $request, Erantzuna $erantzuna): Response
    {
        $form = $this->createForm(ErantzunaType::class, $erantzuna);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('erantzuna_index');
        }

        return $this->render('erantzuna/edit.html.twig', [
            'erantzuna' => $erantzuna,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="erantzuna_delete", methods={"DELETE"})
     * @param Request   $request
     * @param Erantzuna $erantzuna
     *
     * @return Response
     */
    public function delete(Request $request, Erantzuna $erantzuna): Response
    {
        if ($this->isCsrfTokenValid('delete'.$erantzuna->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($erantzuna);
            $entityManager->flush();
        }

        return $this->redirectToRoute('erantzuna_index');
    }
}
