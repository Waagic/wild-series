<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Actor;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Norman Reedus',
        'Andrew Lincoln',
        'Lauren Cohan',
        'Jeffrey Dean Morgan',
        'Chandler Riggs',
    ];

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName){
            $actor = new Actor();
            $actor->setName($actorName);
            $actor->addProgram($this->getReference('program0'));

            $manager->persist($actor);

            $this->addReference('actor' . $key, $actor);
        }

        $faker = Faker\Factory::create('fr_FR');

        for($i = 0; $i < 50 ; $i++){
            $actor = new Actor();
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program'.rand(0,5)));
            $manager->persist($actor);
        }
        $manager->flush();
    }
}
