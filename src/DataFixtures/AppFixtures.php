<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $user = new User;
        $password = $this->encoder->encodePassword($user, 'bibi');
        $user->setEmail('bibi@admin.fr')
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($password)
            ->setFirstName('Bibi')
            ->setLastName('Lademine');

        $manager->persist($user);

        $user1 = new User;
        $password = $this->encoder->encodePassword($user1, 'toto');
        $user1->setEmail('toto@user.fr')
            ->setRoles(["ROLE_USER"])
            ->setPassword($password)
            ->setFirstName('Toto')
            ->setLastName('Luzeure');

        $manager->persist($user);

        $user2 = new User;
        $password = $this->encoder->encodePassword($user2, 'anonymous');
        $user2->setEmail('anonymous@symfony.com')
            ->setRoles(["ROLE_ANONYMOUS"])
            ->setPassword($password)
            ->setFirstName('Utilisateur')
            ->setLastName('Anonyme');

        $manager->persist($user);

        for ($i = 0; $i < 20; $i++) {
            $task  = new Task();
            $users = [$user, $user1, $user2];
            $task->setCreatedAt($faker->dateTimeInInterval('-1 week', '+3 days'));
            $task->setUser($faker->randomElement($users));
            $task->setTitle($faker->word(5));
            $task->setContent($faker->text(56));

            $manager->persist($task);
        }

        $manager->flush();
    }
}
