<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @codeCoverageIgnore
 */
class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $numberOfUsers = 10;

        for ($i = 0; $i < $numberOfUsers; $i++) {
            $user = new User();
            $user->setUsername($faker->unique()->userName);
            $user->setEmail($faker->unique()->email);
            $user->setRoles(['ROLE_USER']);

            $plainPassword = $faker->password(8, 16);
            $encodedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            $user->setPassword($encodedPassword);

            $manager->persist($user);

            $this->addReference('user_' . $i, $user);
        }

        $adminUser = new User();
        $adminUser->setUsername('admin');
        $adminUser->setEmail('admin@example.com');
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, 'admin_password'));
        $adminUser->setRoles(['ROLE_ADMIN']);

        $manager->persist($adminUser);

        $this->addReference('user_' . 10, $adminUser);

        $manager->flush();
    }
}
