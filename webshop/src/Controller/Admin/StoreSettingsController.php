<?php

namespace App\Controller\Admin;

use App\Form\StoreSettingsFormType;
use App\Repository\StoreSettingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StoreSettingsController extends AbstractController
{
    /**
     * @Route("/admin/storeSettings", name="store_settings")
     * @param Request $request
     * @param StoreSettingsRepository $settingsRepository
     * @return Response
     */
    public function index(Request $request, StoreSettingsRepository $settingsRepository): Response
    {
        $storeSettings = $settingsRepository->find(1);
        $form = $this->createForm(StoreSettingsFormType::class, $storeSettings);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $storeSettings=$form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($storeSettings);
            $entityManager->flush();
            $this->addFlash('success', 'Store settings updated');

            return $this->redirectToRoute('admin');
        }

        return $this->render('bundles/EasyAdminBundle/store_settings.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
