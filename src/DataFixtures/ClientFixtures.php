<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Client;
use App\Entity\Users;
use App\Entity\Dette;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ClientFixtures extends Fixture
{
    private $encoder ;
    public function __construct(UserPasswordHasherInterface $encoder){
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 5; $i++) {
            $client = new Client();
            $client->setNom('Nom ' . $i);
            $client->setTelephone('77000000' . $i);
            $client->setAddresse('Adresse ' . $i);  
            if ($i % 2 == 0) {

                $user= new Users();
                $user->setLogin('login' . $i);
                $plainTextPassword="password";
                $hashedPassword = $this->encoder->hashPassword(
                    $user, 
                    $plainTextPassword
                );
                $user->setPassword($hashedPassword);
                $client->setUsers($user);
                for ($j = 1; $j < 2; $j++) {
                    $dette = new Dette();
                    $dette->setMontant(1000 * $j);
                    $dette->setMontantVerser(1000 * $j);
                    $client->addDette($dette);
                }
            }else{
                for ($j = 1; $j < 2; $j++) {
                    $dette = new Dette();
                    $dette->setMontant(1000);
                    $dette->setMontantVerser(1000 * $j);
                    $client->addDette($dette);
                }
            }
            $manager->persist($client);
        }

        $manager->flush();
    }
}
