<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * @codeCoverageIgnore
 */
class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $numberOfTasks = 20;

        for ($i = 0; $i < $numberOfTasks; $i++) {
            $task = new Task();
            $task->setTitle($faker->sentence(4));
            $task->setContent($faker->paragraph(1));
            $task->setCreatedAt($faker->dateTimeBetween('-1 month', 'now'));
            $task->toggle($faker->boolean);
            $task->setUsers($this->getReference('user_' . rand(0, 10)));
            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
