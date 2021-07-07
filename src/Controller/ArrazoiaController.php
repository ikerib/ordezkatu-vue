<?php

namespace App\Controller;

use App\Entity\Arrazoia;
use App\Form\ArrazoiaType;
use App\Repository\ArrazoiaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/arrazoia")
 */
class ArrazoiaController extends AbstractController
{
    /**
     * @Route("/", name="arrazoia_index", methods={"GET"})
     * @param ArrazoiaRepository $arrazoiaRepository
     *
     * @return Response
     */
    public function index(ArrazoiaRepository $arrazoiaRepository): Response
    {
        return $this->render('arrazoia/index.html.twig', [
            'arrazoias' => $arrazoiaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="arrazoia_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $arrazoium = new Arrazoia();
        $form = $this->createForm(ArrazoiaType::class, $arrazoium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($arrazoium);
            $entityManager->flush();

            return $this->redirectToRoute('arrazoia_index');
        }

        return $this->render('arrazoia/new.html.twig', [
            'arrazoium' => $arrazoium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="arrazoia_show", methods={"GET"})
     * @param Arrazoia $arrazoium
     *
     * @return Response
     */
    public function show(Arrazoia $arrazoium): Response
    {
        return $this->render('arrazoia/show.html.twig', [
            'arrazoium' => $arrazoium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="arrazoia_edit", methods={"GET","POST"})
     * @param Request  $request
     * @param Arrazoia $arrazoium
     *
     * @return Response
     */
    public function edit(Request $request, Arrazoia $arrazoium): Response
    {
        $form = $this->createForm(ArrazoiaType::class, $arrazoium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('arrazoia_index');
        }

        return $this->render('arrazoia/edit.html.twig', [
            'arrazoium' => $arrazoium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="arrazoia_delete", methods={"DELETE"})
     * @param Request  $request
     * @param Arrazoia $arrazoium
     *
     * @return Response
     */
    public function delete(Request $request, Arrazoia $arrazoium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$arrazoium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($arrazoium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('arrazoia_index');
    }
}
