<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\EmployeeZerrenda;
use App\Entity\EmployeeZerrendaType;
use App\Entity\User;
use App\Entity\Zerrenda;
use App\Form\EmployeeZerrendaTypeType;
use App\Repository\EmployeeZerrendaTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/employee/zerrenda/type")
 */
class EmployeeZerrendaTypeController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/", name="employee_zerrenda_type_index", methods={"GET"})
     * @param EmployeeZerrendaTypeRepository $employeeZerrendaTypeRepository
     *
     * @return Response
     */
    public function index(EmployeeZerrendaTypeRepository $employeeZerrendaTypeRepository): Response
    {
        return $this->render('employee_zerrenda_type/index.html.twig', [
            'employee_zerrenda_types' => $employeeZerrendaTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{employeeid}", name="employee_zerrenda_type_new", methods={"GET","POST"}, options={"expose":true})
     * @param Request                                   $request
     *
     * @param                                           $employeeid
     *
     * @return Response
     */
    public function new(Request $request, $employeeid): Response
    {
        $zerrendaid = $request->get('zerrendaid');
        $zerrenda = null;
        if ($zerrendaid) {
            $zerrenda = $this->em->getRepository(Zerrenda::class)->find($zerrendaid);
            if (!$zerrenda) {
                throw new NotFoundHttpException('Zerrenda ez da aurkitzen');
            }
        }
        /** @var Employee $employee */
        $employee = $this->em->getRepository(Employee::class)->find($employeeid);
        if (!$employee) {
            throw  new NotFoundHttpException('Ez da hautagaia topatzen');
        }
        $employeeZerrendaType = new EmployeeZerrendaType();
        if ($employee) {
            $employeeZerrendaType->setEmployee($employee);
        }
        if ($zerrenda) {
            $employeeZerrendaType->setZerrenda($zerrenda);
        }

        $form = $this->createForm(EmployeeZerrendaTypeType::class, $employeeZerrendaType, [
            'employeeid' => $employee->getId(),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();


            if ($employeeZerrendaType->getZerrenda()) {
                /** @var EmployeeZerrenda $employeeZerrenda */
                $employeeZerrenda = $this->em->getRepository(EmployeeZerrenda::class)->findOneByEmployeeZerrenda($employeeZerrendaType->getEmployee(), $employeeZerrendaType->getZerrenda());
                $employeeZerrenda->setType($employeeZerrendaType->getType());
                $entityManager->persist($employeeZerrenda);
            } else {
                $zerrendak = $this->em->getRepository(EmployeeZerrenda::class)->findAllZerrendasForEmployee($employeeid);
                /** @var EmployeeZerrenda $z */
                foreach ($zerrendak as $z)
                {
                    $z->setType($employeeZerrendaType->getType());
                    $this->em->persist($z);
                }
            }
            $entityManager->persist($employeeZerrendaType);
            $entityManager->flush();

            return $this->redirectToRoute('employee_show', ['id' => $employeeZerrendaType->getEmployee()->getId()]);
        } else {
            dump( $form->getErrors(true) );
        }

        return $this->render('employee_zerrenda_type/new.html.twig', [
            'employee_zerrenda_type' => $employeeZerrendaType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_zerrenda_type_show", methods={"GET"})
     * @param EmployeeZerrendaType $employeeZerrendaType
     *
     * @return Response
     */
    public function show(EmployeeZerrendaType $employeeZerrendaType): Response
    {
        return $this->render('employee_zerrenda_type/show.html.twig', [
            'employee_zerrenda_type' => $employeeZerrendaType,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employee_zerrenda_type_edit", methods={"GET","POST"})
     * @param Request              $request
     * @param EmployeeZerrendaType $employeeZerrendaType
     *
     * @return Response
     */
    public function edit(Request $request, EmployeeZerrendaType $employeeZerrendaType): Response
    {
        $form = $this->createForm(EmployeeZerrendaTypeType::class, $employeeZerrendaType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_zerrenda_type_index');
        }

        return $this->render('employee_zerrenda_type/edit.html.twig', [
            'employee_zerrenda_type' => $employeeZerrendaType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_zerrenda_type_delete", methods={"DELETE"})
     * @param Request              $request
     * @param EmployeeZerrendaType $employeeZerrendaType
     *
     * @return Response
     */
    public function delete(Request $request, EmployeeZerrendaType $employeeZerrendaType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employeeZerrendaType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employeeZerrendaType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_zerrenda_type_index');
    }
}
