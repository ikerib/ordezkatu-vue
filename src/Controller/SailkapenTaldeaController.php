<?php

namespace App\Controller;

use App\Entity\SailkapenTaldea;
use App\Form\SailkapenTaldeaType;
use App\Repository\SailkapenTaldeaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sailkapen/taldea")
 */
class SailkapenTaldeaController extends AbstractController
{
    /**
     * @Route("/", name="sailkapen_taldea_index", methods={"GET"})
     * @param SailkapenTaldeaRepository $sailkapenTaldeaRepository
     *
     * @return Response
     */
    public function index(SailkapenTaldeaRepository $sailkapenTaldeaRepository): Response
    {
        return $this->render('sailkapen_taldea/index.html.twig', [
            'sailkapen_taldeas' => $sailkapenTaldeaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sailkapen_taldea_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $sailkapenTaldea = new SailkapenTaldea();
        $form = $this->createForm(SailkapenTaldeaType::class, $sailkapenTaldea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sailkapenTaldea);
            $entityManager->flush();

            return $this->redirectToRoute('sailkapen_taldea_index');
        }

        return $this->render('sailkapen_taldea/new.html.twig', [
            'sailkapen_taldea' => $sailkapenTaldea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sailkapen_taldea_show", methods={"GET"})
     * @param SailkapenTaldea $sailkapenTaldea
     *
     * @return Response
     */
    public function show(SailkapenTaldea $sailkapenTaldea): Response
    {
        return $this->render('sailkapen_taldea/show.html.twig', [
            'sailkapen_taldea' => $sailkapenTaldea,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sailkapen_taldea_edit", methods={"GET","POST"})
     * @param Request         $request
     * @param SailkapenTaldea $sailkapenTaldea
     *
     * @return Response
     */
    public function edit(Request $request, SailkapenTaldea $sailkapenTaldea): Response
    {
        $form = $this->createForm(SailkapenTaldeaType::class, $sailkapenTaldea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sailkapen_taldea_index');
        }

        return $this->render('sailkapen_taldea/edit.html.twig', [
            'sailkapen_taldea' => $sailkapenTaldea,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="sailkapen_taldea_delete", methods={"DELETE"})
     * @param Request         $request
     * @param SailkapenTaldea $sailkapenTaldea
     *
     * @return Response
     */
    public function delete(Request $request, SailkapenTaldea $sailkapenTaldea): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sailkapenTaldea->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sailkapenTaldea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sailkapen_taldea_index');
    }
}
