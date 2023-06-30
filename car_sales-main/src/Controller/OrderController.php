<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order_list")
     */
    public function listAction()
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findAll();
        return $this->render('order/index.html.twig', [
            'orders' => $order
        ]);
    }
    /**
     * @Route("/order/details/{id}", name="order_details")
     */
    public
    function detailsAction($id)
    {
        $order = $this->getDoctrine()
            ->getRepository(Order::class)
            ->find($id);

        return $this->render('order/details.html.twig', [
            'orders' => $order
        ]);
    }
    /**
     * @Route("/orders/delete/{id}", name="order_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository(Order::class)->find($id);
        $em->remove($order);
        $em->flush();

        $this->addFlash(
            'error',
            'Deleted successful'
        );

        return $this->redirectToRoute('order_list');
    }
    /**
     * @Route("/order/create", name="order_create", methods={"GET","POST"})
     */
    public function createAction(Request $request)
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);

        if ($this->saveChanges($form, $request, $order)) {
            $this->addFlash(
                'notice',
                'Added Successful'
            );

            return $this->redirectToRoute('order_list');
        }

        return $this->render('order/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function saveChanges($form, $request, $order)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order->setDiscount($request->request->get('order')['Discount']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($order);
            $em->flush();

            return true;
        }
        return false;
    }
    /**
     * @Route("/order/edit/{id}", name="order_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $supplier = $em->getRepository(Order::class)->find($id);

        $form = $this->createForm(OrderType::class, $supplier);

        if ($this->saveChanges($form, $request, $supplier)) {
            $this->addFlash(
                'notice',
                'Edited Successful'
            );
            return $this->redirectToRoute('order_list');
        }

        return $this->render('order/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
