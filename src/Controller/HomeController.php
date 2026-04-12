<?php

namespace App\Controller;

use App\Repository\LanguageRepository;
use App\Service\GetBannersForLocal;
use App\Service\BannerStyleResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(
        Request $request,
        GetBannersForLocal $getBannersForLocal,
        LanguageRepository $languageRepository,
        BannerStyleResolver $bannerStyleResolver
    ): Response
    {
        $languages = $languageRepository->findAll();
        $locale = $request->query->get('locale', $request->getLocale());
        $today = new \DateTimeImmutable('today');

        $banners = $getBannersForLocal->execute($locale, $today);
        $bannerStyles = $bannerStyleResolver->resolveForBanners($banners);

        return $this->render('home/index.html.twig', [
            'banners' => $banners,
            'locale' => $locale,
            'languages' => $languages,
            'bannerStyles' => $bannerStyles,
        ]);
    }
}
