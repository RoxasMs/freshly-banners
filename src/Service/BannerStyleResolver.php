<?php

namespace App\Service;

class BannerStyleResolver
{
    /**
     * @param array<int, object> $banners
     * @return array<int, array{background: string, text: string}>
     */
    public function resolveForBanners(array $banners): array
    {
        $styles = [];

        foreach ($banners as $banner) {
            $background = '#f8f9fa';

            if ($banner->getBackgroundColor() !== null && $banner->getBackgroundColor()->getCode() !== null) {
                $background = strtolower($banner->getBackgroundColor()->getCode());
            }

            $bannerId = $banner->getId();

            if ($bannerId === null) {
                continue;
            }

            $styles[$bannerId] = [
                'background' => $background,
                'text' => in_array($background, ['#ffffff', '#fff'], true) ? '#111111' : '#ffffff',
            ];
        }

        return $styles;
    }
}
