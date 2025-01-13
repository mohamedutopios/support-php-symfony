<?php
namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FormationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            // Créer une nouvelle instance de Formation
            $formation = new Formation();

            // Définir les propriétés
            $formation->setTitle($faker->sentence(3))
                ->setDescription($faker->paragraph(3))
                ->setDuration($faker->numberBetween(10, 50))
                ->setStartDate($faker->dateTimeBetween('-1 year', 'now'))
                ->setEndDate($faker->dateTimeBetween('now', '+1 year'));

            // Persister l'entité
            $manager->persist($formation);
        }

        // Sauvegarder les données en base
        $manager->flush();
    }
}
