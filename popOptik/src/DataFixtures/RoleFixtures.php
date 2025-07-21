<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Role();
        $admin->setName('admin');
        $manager->persist($admin);

        $user = new Role();
        $user->setName('user');
        $manager->persist($user);

        $manager->flush();
    }
}
