<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Season;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 50 ; $i++){
            $season = new Season();
            $season->setNumber($i);
            $season->setYear($faker->year($max = 'now'));
            $season->setProgram($this->getReference('program'.rand(0,5)));
            $season->setDescription($faker->text($maxNbChars = 200));
            $this->addReference('season' . $i, $season);
            $manager->persist($season);
        }
        $manager->flush();
    }
}
