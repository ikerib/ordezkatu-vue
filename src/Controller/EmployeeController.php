<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\EmployeeZerrenda;
use App\Entity\EmployeeZerrendaType;
use App\Entity\User;
use App\Entity\Zerrenda;
use App\Form\EmployeeSelectType;
use App\Form\EmployeeType;
use App\Form\EmployeeZerrendaTypeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/employee")
 */
class EmployeeController extends AbstractController
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
     * @Route("/", name="employee_index", methods={"GET"})
     * @param EmployeeRepository $employeeRepository
     *
     * @return Response
     */
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/select/tolist/{listid}", name="employee_select", methods={"GET", "POST"})
     * @param Request $request
     * @param int     $listid
     *
     * @return Response
     */
    public function select(Request $request, int $listid): Response
    {
        /** @var Zerrenda $zerrenda */
        $zerrenda       = $this->em->getRepository(Zerrenda::class)->find($listid);
        $employess      = $this->em->getRepository(Employee::class)->findAll();
        $employeeInList = $this->em->getRepository(Employee::class)->findAllWithinList($listid);
        $form           = $this->createForm(EmployeeSelectType::class, null, [
            'action' => $this->generateUrl('employee_select', ['listid' => $listid]),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if (count($data['select'])) {
                $position = (int)$this->em->getRepository(EmployeeZerrenda::class)->getMaxPositionZerrenda($zerrenda->getId());

                /** @var Employee $employee */
                foreach ($data['select'] as $employee) {
                    $position++;
                    $ez = new EmployeeZerrenda();
                    $ez->setZerrenda($zerrenda);
                    $ez->setEmployee($employee);
                    $ez->setPosition($position);
                    $type = $this->em->getRepository( 'App:Type' )->find( 1 ); // ALTA TODO: kendu hardcoding
                    $ez->setType( $type );
                    $employee->addEmployeeZerrenda($ez);
                    $this->em->persist($ez);
                    $this->em->persist($employee);
                }
                $this->em->flush();
            }
            return $this->redirectToRoute('zerrenda_edit', ['id' => $zerrenda->getId()]);
        }

        return $this->render('employee/select.html.twig', [
            'form'           => $form->createView(),
            'employess'      => $employess,
            'employeeInList' => $employeeInList
        ]);
    }

    /**
     * @Route("/new", name="employee_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $employee = new Employee();
        $form     = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('employee/new.html.twig', [
            'employee' => $employee,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="employee_show", methods={"GET"}, options={"expose":true})
     * @param Employee $employee
     *
     * @return Response
     */
    public function show(Employee $employee): Response
    {
        $ezts = $this->em->getRepository(EmployeeZerrendaType::class)->getAllForEmployee($employee->getId());
        /** @var EmployeeZerrendaType $ezt */
        $ezt = new EmployeeZerrendaType();
        $ezt->setEmployee($employee);
        $formEmployeeZerrendaType = $this->createForm(EmployeeZerrendaTypeType::class, $ezt,[
            'action' => $this->generateUrl('employee_zerrenda_type_new', [
                'employeeid' => $employee->getId()
            ]),
            'employeeid' => $employee->getId(),
            'method' => 'POST'
        ]);

        return $this->render('employee/show.html.twig', [
            'employee'  => $employee,
            'ezts'      => $ezts,
            'formEmployeeZerrendaType' => $formEmployeeZerrendaType->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="employee_edit", methods={"GET","POST"}, options={"expose":true})
     * @param Request  $request
     * @param Employee $employee
     *
     * @return Response
     */
    public function edit(Request $request, Employee $employee): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_index');
        }

        return $this->render('employee/edit.html.twig', [
            'employee' => $employee,
            'form'     => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="employee_delete", methods={"DELETE"})
     * @param Request  $request
     * @param Employee $employee
     *
     * @return Response
     */
    public function delete(Request $request, Employee $employee): Response
    {
        if ($this->isCsrfTokenValid('delete' . $employee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_index');
    }

    /**
     * @Route("/{employeeid}/zerrenda/{zerrendaid}", name="employee_delete_zerrenda", methods={"DELETE"})
     *
     * @param Request                                   $request
     * @param                                           $employeeid
     * @param int                                       $zerrendaid
     *
     * @return Response
     */
    public function deletefromlist(Request $request, $employeeid, int $zerrendaid): Response
    {
        if ($this->isCsrfTokenValid('delete' . $employeeid . $zerrendaid, $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var EmployeeZerrenda $ez */
            $ez = $this->em->getRepository(EmployeeZerrenda::class)->findOneByEmployeeZerrenda($employeeid, $zerrendaid);
            $entityManager->remove($ez);
            $entityManager->flush();
            // reorden
            $ezs = $this->em->getRepository(EmployeeZerrenda::class)->findAllEmployeesFromZerrenda($zerrendaid);
            $position=0;
            /** @var EmployeeZerrenda $ez */
            foreach ($ezs as $ez)
            {
                $position++;
                if ($ez->getPosition() !== $position) {
                    // hemendik aurrerakoak eguneratu
                    $ez->setPosition($position);
                    $this->em->persist($ez);
                }
            }
            $entityManager->flush();
        }

        return $this->redirectToRoute('zerrenda_edit', ['id' => $zerrendaid]);
    }
}
