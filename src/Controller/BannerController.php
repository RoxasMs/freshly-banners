<?php

namespace App\Controller;

use App\Entity\Banner;
use App\Form\BannerType;
use App\Repository\BannerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/banner')]
final class BannerController extends AbstractController
{
    #[Route(name: 'app_banner_index', methods: ['GET'])]
    public function index(BannerRepository $bannerRepository): Response
    {
        return $this->render('banner/index.html.twig', [
            'banners' => $bannerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_banner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $banner = new Banner();
        $form = $this->createForm(BannerType::class, $banner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($banner->getBannerContents() as $bannerContent) {
                $bannerContent->setBanner($banner);
                $entityManager->persist($bannerContent);
            }
            $entityManager->persist($banner);
            $entityManager->flush();

            return $this->redirectToRoute('app_banner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('banner/new.html.twig', [
            'banner' => $banner,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_banner_show', methods: ['GET'])]
    public function show(Banner $banner): Response
    {
        return $this->render('banner/show.html.twig', [
            'banner' => $banner,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_banner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Banner $banner, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BannerType::class, $banner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($banner->getBannerContents() as $bannerContent) {
                $bannerContent->setBanner($banner);
                $entityManager->persist($bannerContent);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_banner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('banner/edit.html.twig', [
            'banner' => $banner,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_banner_delete', methods: ['POST'])]
    public function delete(Request $request, Banner $banner, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$banner->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($banner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_banner_index', [], Response::HTTP_SEE_OTHER);
    }
}
