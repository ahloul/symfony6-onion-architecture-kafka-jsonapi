<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Factory\VoucherFactory;
use App\User\Domain\Entities\User;
use App\Voucher\Domain\Entities\Voucher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        VoucherFactory::createMany(5); // create 5 Posts


        $user = new User();
        $user->setEmail('admin@admin.com');

        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);
        $user->setTier('gold');
        $user->setRoles(['ROLE_USER','ROLE_ADMIN']);
        $manager->persist($user);
        $manager->flush();


        $user = new User();
        $user->setEmail('client@client.com');
        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);
        $user->setTier('free');
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $manager->flush();
    }
}
