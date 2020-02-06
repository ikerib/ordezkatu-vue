<?php

namespace App\Controller;

use App\Entity\Saila;
use App\Form\SailaType;
use App\Repository\SailaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/saila")
 */
class SailaController extends AbstractController
{
    /**
     * @Route("/", name="saila_index", methods={"GET"})
     * @param SailaRepository $sailaRepository
     *
     * @return Response
     */
    public function index(SailaRepository $sailaRepository): Response
    {
        return $this->render('saila/index.html.twig', [
            'sailas' => $sailaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="saila_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $saila = new Saila();
        $form = $this->createForm(SailaType::class, $saila);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($saila);
            $entityManager->flush();

            return $this->redirectToRoute('saila_index');
        }

        return $this->render('saila/new.html.twig', [
            'saila' => $saila,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="saila_show", methods={"GET"})
     * @param Saila $saila
     *
     * @return Response
     */
    public function show(Saila $saila): Response
    {
        return $this->render('saila/show.html.twig', [
            'saila' => $saila,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="saila_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Saila   $saila
     *
     * @return Response
     */
    public function edit(Request $request, Saila $saila): Response
    {
        $form = $this->createForm(SailaType::class, $saila);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('saila_index');
        }

        return $this->render('saila/edit.html.twig', [
            'saila' => $saila,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="saila_delete", methods={"DELETE"})
     * @param Request $request
     * @param Saila   $saila
     *
     * @return Response
     */
    public function delete(Request $request, Saila $saila): Response
    {
        if ($this->isCsrfTokenValid('delete'.$saila->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($saila);
            $entityManager->flush();
        }

        return $this->redirectToRoute('saila_index');
    }
}
