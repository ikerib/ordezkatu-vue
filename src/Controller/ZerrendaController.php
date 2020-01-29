<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Entity\EmployeeZerrenda;
use App\Entity\Log;
use App\Entity\Municipio;
use App\Entity\User;
use App\Entity\Zerrenda;
use App\Form\ZerrendaInportType;
use App\Form\ZerrendaTemplateType;
use App\Form\ZerrendaType;
use App\Repository\TypeRepository;
use App\Repository\ZerrendaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/admin/zerrendak")
 */
class ZerrendaController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    /**
     * @Route("/", name="zerrenda_index", methods={"GET"})
     * @param ZerrendaRepository $zerrendaRepository
     *
     * @return Response
     */
    public function index(ZerrendaRepository $zerrendaRepository): Response
    {
        return $this->render('zerrenda/index.html.twig', [
            'zerrendas' => $zerrendaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="zerrenda_new", methods={"GET","POST"})
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $zerrenda = new Zerrenda();
        $form = $this->createForm(ZerrendaType::class, $zerrenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            /** @var Log $log */
            $log = new Log();
            /** @var User $user */
            $user = $this->getUser();
            $log->setUser($user);
            $log->setZerrenda($zerrenda);
            $log->setName('Zerrenda berria sortua da');
            $log->setDescription("$zerrenda zerrenda sortua izan da.");
            $entityManager->persist($zerrenda);
            $entityManager->persist($log);
            $entityManager->flush();

            return $this->redirectToRoute('zerrenda_edit', ['id' => $zerrenda->getId()]);
        }

        return $this->render('zerrenda/new.html.twig', [
            'zerrenda' => $zerrenda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="zerrenda_show", methods={"GET"})
     *
     * @param                     $id
     * @param TypeRepository      $typeRepository
     * @param ZerrendaRepository  $zerrendaRepository
     *
     * @param SerializerInterface $serializer
     *
     * @return Response
     */
    public function show($id, TypeRepository $typeRepository, ZerrendaRepository $zerrendaRepository, SerializerInterface $serializer): Response
    {
        $zerrenda   = $zerrendaRepository->findZerrendaBat( $id );
        $types = $typeRepository->findAll();

        return $this->render('zerrenda/show.html.twig', [
            'zerrenda'  =>$serializer->serialize($zerrenda, 'json',  ['groups' => 'main']),
            'types'     =>$serializer->serialize($types, 'json',  ['groups' => 'main']),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="zerrenda_edit", methods={"GET","POST"})
     * @param Request            $request
     * @param Zerrenda           $zerrenda
     * @param ZerrendaRepository $zerrendaRepository
     *
     * @return Response
     */
    public function edit(Request $request, Zerrenda $zerrenda, ZerrendaRepository $zerrendaRepository): Response
    {
        $form = $this->createForm(ZerrendaType::class, $zerrenda);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Log $log */
            $log = new Log();
            /** @var User $user */
            $user = $this->getUser();
            $log->setUser($user);
            $log->setZerrenda($zerrenda);
            $log->setName('Zerrenda editatu');
            $log->setDescription("$zerrenda zerrenda editatua izan da");
            $this->em->persist($log);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('zerrenda_edit', [ 'id' => $zerrenda->getId()]);
        }

        $uploadForm = $this->createForm(ZerrendaTemplateType::class, $zerrenda, [
            'action' => $this->generateUrl('admin_zerrenda_add_employees_from_file', [
                'zerrendaid' => $zerrenda->getId(),
            ]),
            'method' => 'POST',
        ]);

        $formZerrendaGuztiak = $this->createForm(ZerrendaInportType::class, null, [
            'action' => $this->generateUrl('admin_zerrenda_add_employees_from_zerrenda', [
                'sourceid' => $zerrenda->getId()
            ]),
            'method' => 'POST'
        ]);

        return $this->render('zerrenda/edit.html.twig', [
            'zerrenda' => $zerrenda,
            'formZerrendaGuztiak' => $formZerrendaGuztiak->createView(),
            'form' => $form->createView(),
            'uploadForm' => $uploadForm->createView(),
        ]);
    }

    /**
     * @Route("/parsefile/{zerrendaid}", name="admin_zerrenda_add_employees_from_file", methods={"POST"})
     *
     * @param Request            $request
     * @param int                $zerrendaid
     *
     * @param ZerrendaRepository $zerrendaRepository
     *
     * @return RedirectResponse|null
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws Exception
     */
    public function addEmployeesFromFile(Request $request, int $zerrendaid, ZerrendaRepository $zerrendaRepository): ?RedirectResponse
    {
        /** @var Zerrenda $zerrenda */
        $zerrenda = $zerrendaRepository->find($zerrendaid);
        $uploadForm = $this->createForm(ZerrendaTemplateType::class);
        $uploadForm->handleRequest($request);
        if ($uploadForm->isSubmitted() && $uploadForm->isValid()) {
            $myFile = $uploadForm->getData();
            /**  Identify the type of $inputFileName  **/
            $inputFileType = IOFactory::identify($myFile['fitxategiaFile']);
            /**  Create a new Reader of the type that has been identified  **/
            $reader = IOFactory::createReader($inputFileType);
            /**  Load $inputFileName to a Spreadsheet Object  **/
            $spreadsheet = $reader->load($myFile['fitxategiaFile']);
            $reader->setReadDataOnly(true);

            $dataSpreadsheet = $spreadsheet->getActiveSheet()->toArray();
            $position = (int)$this->em->getRepository(EmployeeZerrenda::class)->getMaxPositionZerrenda($zerrenda->getId());
            foreach ($dataSpreadsheet as $data) {
                // check first row is heading
                if (('Izena' === $data[0]) && ('Abizena1' === $data[1]) && ('Abizena2' === $data[2])) {
                    continue;
                }

                $position++;

                /** @var Log $log */
                $log = new Log();
                /** @var User $user */
                $user = $this->getUser();
                $log->setUser($user);

                // Check if employee exists in DB
                /** @var Employee $emp */
                $emp = $this->em->getRepository(Employee::class)->finyOneByNan($data[3]);
                if (!$emp) {
                    /** @var Employee $emp */
                    $emp = new Employee();
                    $ez = new EmployeeZerrenda();
                    $ez->setEmployee($emp);
                    $ez->setZerrenda($zerrenda);
                    $ez->setPosition($position);
                    $this->em->persist($ez);
                    $emp->addEmployeeZerrenda($ez);
                    $emp->setName($data[0]);
                    $emp->setAbizena1($data[1]);
                    $emp->setAbizena2($data[2]);
                    $emp->setNan($data[3]);
                    $emp->setEmail($data[4]);
                    $emp->setTelefono($data[5]);
                    $emp->setHelbidea($data[6]);
                    /** @var Municipio $municipio */
                    $municipio = $this->em->getRepository(Municipio::class)->findMunicipioByCodPostal($data[7]);
                    if ($municipio) {
                        $emp->setMunicipio($municipio);
                    }
                    $log->setEmployee($emp);
                    $log->setZerrenda($zerrenda);
                    $log->setEmployeezerrenda($ez);
                    $log->setName('Hautagai berria inportatu da');
                    $log->setDescription("$emp hautagaia $zerrenda zerrendara inportatu da fitxategitik");

                } else {
                    // Check if Employee is in the list already
                    $dago = $this->em->getRepository(EmployeeZerrenda::class)->findOneByEmployeeZerrenda($emp->getId(), $zerrenda->getId());
                    if (!$dago) {
                        $ez = new EmployeeZerrenda();
                        $ez->setEmployee($emp);
                        $ez->setZerrenda($zerrenda);
                        $emp->addEmployeeZerrenda($ez);
                        $ez->setPosition($position);

                        $log->setZerrenda($zerrenda);
                        $log->setEmployeezerrenda($ez);
                        $log->setName('Existitzen zen hautagaia zerrendara inportatu da');
                        $log->setDescription("$emp hautagaia $zerrenda zerrendara inportatu da " . $myFile['fitxategiaFile'] . ' fitxategitik');

                    } else {
                        $this->addFlash('warning',$emp->getName().' '.$emp->getAbizena1().' '.$emp->getAbizena2(). ' iadanik zerrendan dago.');
                    }
                }
                $this->em->persist($emp);
                $this->em->persist($log);
            }
            $this->em->flush();

            return $this->redirectToRoute('zerrenda_edit', ['id' => $zerrendaid]);
        }

        $referer = $request->headers->get('referer');

        return $this->redirect($referer);
    }

    /**
     * @Route("/import/from/{sourceid}", name="admin_zerrenda_add_employees_from_zerrenda", options={ "expose": true})
     * @param Request            $request
     * @param int                $sourceid
     * @param ZerrendaRepository $zerrendaRepository
     *
     * @return RedirectResponse|null
     */
    public function addEmployeesFromZerrenda(Request $request, int $sourceid, ZerrendaRepository $zerrendaRepository): ?RedirectResponse
    {

        $formSelect = $this->createForm(ZerrendaInportType::class);
        $formSelect->handleRequest($request);
        if ($formSelect->isSubmitted() && $formSelect->isValid())
        {
            /** @var Zerrenda $zerrenda */
            $oriZerrenda = $zerrendaRepository->find($sourceid);

            $data = $formSelect->getData();
            /** @var Zerrenda $desZerrenda */
            $desZerrenda = $data['zerrenda'];

            if ($desZerrenda !== null) {
                if ($oriZerrenda !== null) {
                    $position = (int)$this->em->getRepository(EmployeeZerrenda::class)->getMaxPositionZerrenda($oriZerrenda->getId());
                    foreach ($desZerrenda->getEmployeeZerrenda() as $ez)
                    {
                        $position++;
                        // Check if Employee is in the list already
                        /** @var Employee $destEmployee */
                        $destEmployee = $ez->getEmployee();
                        $dago = $this->em->getRepository(EmployeeZerrenda::class)->findOneByEmployeeZerrenda($destEmployee->getId(), $oriZerrenda->getId());
                        if (!$dago) {
                            /** @var EmployeeZerrenda $ez */
                            $newEz = new EmployeeZerrenda();
                            $newEz->setEmployee($ez->getEmployee());
                            $newEz->setZerrenda($oriZerrenda);
                            $newEz->setPosition((int)$position);
                            /** @var Log $log */
                            $log = new Log();
                            /** @var User $user */
                            $user = $this->getUser();
                            $log->setUser($user);
                            $log->setEmployeezerrenda($newEz);
                            $log->setEmployee($ez->getEmployee());
                            $log->setZerrenda($ez->getZerrenda());
                            $log->setName('Zerrenda inportatu');
                            $log->setDescription($ez->getEmployee() . ' ' . $oriZerrenda . '-tik inportatua izan da');
                            $this->em->persist($log);
                            $this->em->persist($newEz);
                        } else {
                            $this->addFlash('warning',$destEmployee->getName().' '.$destEmployee->getAbizena1().' '.$destEmployee->getAbizena2(). ' iadanik zerrendan dago.');
                        }

                    }
                }
                $this->em->flush();
            }
        }

        return $this->redirectToRoute('zerrenda_edit', ['id' => $sourceid]);
    }

    /**
     * @Route("/{id}", name="zerrenda_delete", methods={"DELETE"})
     * @param Request  $request
     * @param Zerrenda $zerrenda
     *
     * @return Response
     */
    public function delete(Request $request, Zerrenda $zerrenda): Response
    {
        if ($this->isCsrfTokenValid('delete'.$zerrenda->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($zerrenda);
            /** @var Log $log */
            $log = new Log();
            /** @var User $user */
            $user = $this->getUser();
            $log->setUser($user);
            $log->setZerrenda($zerrenda);
            $log->setName('Zerrenda ezabatu');
            $log->setDescription("$zerrenda zerrenda ezabatua izan da.");
            $this->em->persist($log);
            $entityManager->flush();
        }

        return $this->redirectToRoute('zerrenda_index');
    }
}
