<?php

namespace App\Controller;

use App\Entity\Hizkuntza;
use App\Form\HizkuntzaType;
use App\Repository\HizkuntzaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/hizkuntza")
 */
class HizkuntzaController extends AbstractController
{
    /**
     * @Route("/", name="hizkuntza_index", methods={"GET"})
     * @param HizkuntzaRepository $hizkuntzaRepository
     *
     * @return Response
     */
    public function index(HizkuntzaRepository $hizkuntzaRepository): Response
    {
        return $this->render('hizkuntza/index.html.twig', [
            'hizkuntzas' => $hizkuntzaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hizkuntza_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $hizkuntza = new Hizkuntza();
        $form = $this->createForm(HizkuntzaType::class, $hizkuntza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hizkuntza);
            $entityManager->flush();

            return $this->redirectToRoute('hizkuntza_index');
        }

        return $this->render('hizkuntza/new.html.twig', [
            'hizkuntza' => $hizkuntza,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hizkuntza_show", methods={"GET"})
     * @param Hizkuntza $hizkuntza
     *
     * @return Response
     */
    public function show(Hizkuntza $hizkuntza): Response
    {
        return $this->render('hizkuntza/show.html.twig', [
            'hizkuntza' => $hizkuntza,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hizkuntza_edit", methods={"GET","POST"})
     * @param Request   $request
     * @param Hizkuntza $hizkuntza
     *
     * @return Response
     */
    public function edit(Request $request, Hizkuntza $hizkuntza): Response
    {
        $form = $this->createForm(HizkuntzaType::class, $hizkuntza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hizkuntza_index');
        }

        return $this->render('hizkuntza/edit.html.twig', [
            'hizkuntza' => $hizkuntza,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hizkuntza_delete", methods={"DELETE"})
     * @param Request   $request
     * @param Hizkuntza $hizkuntza
     *
     * @return Response
     */
    public function delete(Request $request, Hizkuntza $hizkuntza): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hizkuntza->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hizkuntza);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hizkuntza_index');
    }
}
