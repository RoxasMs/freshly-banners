<?php

namespace App\Service;

use App\Repository\BannerRepository;

class GetBannersForLocal
{
    public function __construct(private readonly BannerRepository $bannerRepository)
    {
    }

    public function execute(string $locale, \DateTimeImmutable $today): array
    {
        return $this->bannerRepository->findVisibleForLocale($locale, $today);
    }
}