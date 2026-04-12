<?php

namespace App\DataFixtures;

use App\Entity\Color;
use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $languages = [
            ['locale' => 'es', 'name' => 'Español'],
            ['locale' => 'en', 'name' => 'English'],
            ['locale' => 'fr', 'name' => 'Français'],
            ['locale' => 'pt', 'name' => 'Português'],
        ];

        foreach ($languages as $item) {
            $existingLanguage = $manager->getRepository(Language::class)->findOneBy([
                'locale' => $item['locale'],
            ]);

            if ($existingLanguage === null) {
                $language = new Language();
                $language->setLocale($item['locale']);
                $language->setName($item['name']);
                $manager->persist($language);
            }
        }

        $colors = [
            ['name' => 'Blanco', 'code' => '#FFFFFF'],
            ['name' => 'Negro', 'code' => '#000000'],
            ['name' => 'Rojo', 'code' => '#FF0000'],
            ['name' => 'Azul', 'code' => '#0000FF'],
            ['name' => 'Verde', 'code' => '#00AA00'],
        ];

        foreach ($colors as $item) {
            $existingColor = $manager->getRepository(Color::class)->findOneBy([
                'code' => $item['code'],
            ]);

            if ($existingColor === null) {
                $color = new Color();
                $color->setName($item['name']);
                $color->setCode($item['code']);
                $manager->persist($color);
            }
        }

        $manager->flush();
    }
}