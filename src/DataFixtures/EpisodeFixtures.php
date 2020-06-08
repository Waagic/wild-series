<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
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

        for ($i = 1; $i < 50; $i++) {
            $episode = new Episode();
            $slugify = new Slugify();
            $episode->setTitle($faker->text($maxNbChars = 20));
            $episode->setNumber($i);
            $episode->setSynopsis($faker->text($maxNbChars = 200));
            $episode->setSeason($this->getReference('season'.rand(0,49)));
            $slug = $slugify->generate($episode->getTitle());
            $episode->setSlug($slug);
            $manager->persist($episode);
        }
        $manager->flush();
    }
}
