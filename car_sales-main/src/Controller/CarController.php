<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/car", name="car_list")
     */
    public function listAction()
    {
        $cars = $this->getDoctrine()
            ->getRepository(Car::class)
            ->findAll();
        return $this->render('car/index.html.twig', [
            'cars' => $cars
        ]);
    }
    /**
     * @Route("/car/details/{id}", name="car_details")
     */
    public
    function detailsAction($id)
    {
        $cars = $this->getDoctrine()
            ->getRepository(Car::class)
            ->find($id);

        return $this->render('car/details.html.twig', [
            'car' => $cars
        ]);
    }
    /**
     * @Route("/car/delete/{id}", name="car_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository(Car::class)->find($id);
        $em->remove($car);
        $em->flush();

        $this->addFlash(
            'error',
            'Deleted successful'
        );

        return $this->redirectToRoute('car_list');
    }
    /**
     * @Route("/car/edit/{id}", name="car_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $car = $em->getRepository(Car::class)->find($id);

        $form = $this->createForm(CarType::class, $car);

        if ($this->saveChanges($form, $request, $car)) {
            $this->addFlash(
                'notice',
                'Edited Successful'
            );
            return $this->redirectToRoute('car_list');
        }

        return $this->render('car/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/car/create", name="car_create", methods={"GET","POST"})
     */
    public function createAction(Request $request)
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);

        if ($this->saveChanges($form, $request, $car)) {
            $this->addFlash(
                'notice',
                'Added Successful'
            );

            return $this->redirectToRoute('car_list');
        }

        return $this->render('car/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function saveChanges($form, $request, $car)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $car->setCarname($request->request->get('car')['Carname']);
            $car->setCarbrand($request->request->get('car')['Carbrand']);
            $car->setCarprice($request->request->get('car')['Carprice']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($car);
            $em->flush();

            return true;
        }
        return false;
    }
}
