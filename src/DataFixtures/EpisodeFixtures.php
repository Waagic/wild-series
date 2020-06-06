<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;


class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $episode = new Episode();
            $episode->setTitle($faker->text($maxNbChars = 20));
            $episode->setNumber($i);
            $episode->setSynopsis($faker->text($maxNbChars = 200));
            $episode->setSeason($this->getReference('season'.rand(0,49)));
            $manager->persist($episode);
        }
        $manager->flush();
    }
}
