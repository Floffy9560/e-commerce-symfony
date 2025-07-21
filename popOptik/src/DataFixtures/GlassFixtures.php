<?php

namespace App\DataFixtures;

use App\Entity\Glass;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Gender;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class GlassFixtures extends Fixture
{
      public function load(ObjectManager $manager): void
      {
            $faker = Factory::create('fr_FR');

            // Catégories fixes
            $categorySun = new Category();
            $categorySun->setName('Lunettes de soleil');
            $manager->persist($categorySun);

            $categoryOptical = new Category();
            $categoryOptical->setName('Lunettes optiques');
            $manager->persist($categoryOptical);

            $categories = [$categorySun, $categoryOptical];

            // Genres
            $genderMale = new Gender();
            $genderMale->setGender('Homme');
            $manager->persist($genderMale);

            $genderFemale = new Gender();
            $genderFemale->setGender('Femme');
            $manager->persist($genderFemale);

            $genderUnisex = new Gender();
            $genderUnisex->setGender('Mixte');
            $manager->persist($genderUnisex);

            $genders = [$genderMale, $genderFemale, $genderUnisex];

            // Marques
            $brands = [];
            for ($b = 0; $b < 5; $b++) {
                  $brand = new Brand();
                  $brand->setName($faker->company());
                  $brand->setContactLens($faker->boolean() ? 'Compatible' : 'Non compatible');
                  $manager->persist($brand);
                  $brands[] = $brand;
            }

            // Valeurs possibles
            $colors = ['Noir', 'Marron', 'Bleu', 'Rouge', 'Transparent', 'Gris'];
            $shapes = ['Ronde', 'Carrée', 'Rectangulaire', 'Aviateur', 'Papillon'];
            $matters = ['Plastique', 'Métal', 'Titane', 'Acétate'];

            $adjectives = ['Élégante', 'Moderne', 'Classique', 'Chic', 'Vintage', 'Sportive', 'Lumineuse'];
            $models = ['Vision', 'Aura', 'Nova', 'Luxe', 'Prisme', 'Focus', 'Clair'];

            for ($i = 0; $i < 30; $i++) {
                  $glass = new Glass();
                  $glass->setColor($faker->randomElement($colors));
                  $glass->setShape($faker->randomElement($shapes));
                  $glass->setMatter($faker->randomElement($matters));

                  // Fake image path
                  $glass->setImageName('glass_' . $i . '.jpg');
                  $glass->setImagePath('assets/img/glasse.jpg');

                  $glass->setCategory($faker->randomElement($categories));
                  $glass->setGender($faker->randomElement($genders));
                  $glass->setBrand($faker->randomElement($brands));

                  // Création de l’item associé (obligatoire pour éviter les null)
                  $item = new Item();
                  $item->setName(
                        ucfirst($glass->getShape()) . ' ' .
                              $faker->randomElement($adjectives) . ' ' .
                              $faker->randomElement($models)
                  );
                  $item->setPrice($faker->randomFloat(2, 50, 500)); // prix entre 50 et 500€
                  $item->setStock($faker->numberBetween(0, 100));
                  $item->setGlass($glass); // bidirectionnel (optionnel, si tu gères l’inverse)

                  $glass->setItem($item);

                  // Persister les deux objets
                  $manager->persist($item);
                  $manager->persist($glass);
            }

            $manager->flush();
      }
}
