<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use App\Form\ChangePasswordFormType;
use App\Repository\AddressRepository;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user_settings")
     */
    public function index()
    {
        return $this->render('user/settings.html.twig');
    }

    /**
     * @Route("/user/changePassword", name="changePassword")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $changePassword = $request->request->get('change_password_form');
            $oldPassword = $changePassword['oldPassword'];
            $newPassword = $changePassword['plainPassword']['first'];
            $confirmPassword = $changePassword['plainPassword']['second'];
            $hashedOldPass = $encoder->isPasswordValid($user, $oldPassword);

            if ($user->getPassword() != $hashedOldPass) {
                $this->addFlash('danger', 'Invalid old password');
                return $this->redirectToRoute('changePassword');
            }

            if ($newPassword !== $confirmPassword) {
                $this->addFlash('danger', 'Password and repeat password does not match');
                return $this->redirectToRoute('changePassword');
            }

            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $user->setPassword($encoder->encodePassword($user, $newPassword));
            $entityManager->flush();

            $this->addFlash('success', 'Password changed!');
            return $this->redirectToRoute('home');

        }
        return $this->render('user/changePassword.html.twig', [
            'changePasswordForm'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/user/changeAddress", name="changeAddress")
     * @param Request $request
     * @param AddressRepository $addressRepository
     * @return RedirectResponse|Response
     */
    public function changeAddress(Request $request, AddressRepository $addressRepository)
    {
        $user = $this->getUser();
        $form = $this->createForm(AddressType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {

            $address = $addressRepository->find($user->getAddress()->getId());
            $entityManager = $this->getDoctrine()->getManager();
            $address->setCity($form->get('city')->getData());
            $address->setPostalCode($form->get('postalCode')->getData());
            $address->setAddress($form->get('address')->getData());
            $entityManager->flush();

            $this->addFlash('success', 'Address changed!');
            return $this->redirectToRoute('home');
        }

        return $this->render('user/changeAddress.html.twig', [
            'addressForm'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/user/orders", name="user_orders")
     * @param OrderRepository $orderRepository
     * @return Response
     */
    public function myOrders(OrderRepository $orderRepository)
    {
        $orders = $orderRepository->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('user/orders.html.twig', [
            'orders' => $orders
        ]);
    }
}
