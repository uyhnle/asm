<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    /**
     * @Route("/customer", name="customer_list")
     */
    public function listAction()
    {
        $customers = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAll();
        return $this->render('customer/index.html.twig', [
            'customers' => $customers
        ]);
    }
    /**
     * @Route("/customer/details/{id}", name="customer_details")
     */
    public
    function detailsAction($id)
    {
        $customers = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->find($id);

        return $this->render('customer/details.html.twig', [
            'customers' => $customers
        ]);
    }
    /**
     * @Route("/customer/delete/{id}", name="customer_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository(Customer::class)->find($id);
        $em->remove($customer);
        $em->flush();

        $this->addFlash(
            'error',
            'Deleted successful'
        );

        return $this->redirectToRoute('customer_list');
    }
    /**
     * @Route("/customer/create", name="customer_create", methods={"GET","POST"})
     */
    public function createAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        if ($this->saveChanges($form, $request, $customer)) {
            $this->addFlash(
                'notice',
                'Added Successful'
            );

            return $this->redirectToRoute('customer_list');
        }

        return $this->render('customer/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function saveChanges($form, $request, $customer)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $customer->setCustomername($request->request->get('customer')['Customername']);
            $customer->setCustomermail($request->request->get('customer')['Customermail']);
            $customer->setCustomerphone($request->request->get('customer')['Customerphone']);
            $customer->setCustomeraddress($request->request->get('customer')['Customeraddress']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return true;
        }
        return false;
    }
    /**
     * @Route("/customer/edit/{id}", name="customer_edit")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository(Customer::class)->find($id);

        $form = $this->createForm(CustomerType::class, $customer);

        if ($this->saveChanges($form, $request, $customer)) {
            $this->addFlash(
                'notice',
                'Edited Successful'
            );
            return $this->redirectToRoute('customer_list');
        }

        return $this->render('customer/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
