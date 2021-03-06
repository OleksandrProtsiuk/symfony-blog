<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Admin');
        $user->setLogin('admin');
        $user->setPassword('admin');
        $user->setRole('admin');

        $manager->persist($user);
        $manager->flush();
    }

    protected function getFixtures()
    {
        return  [
            DIR.'/user.yml',
            DIR.'/post.yml',
        ];
    }
}
