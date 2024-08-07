<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        
        for($u = 0; $u < 10; $u++){
            $user = new User();
            $chrono = 1;
            $user ->setFirstName($faker->firstName())
                  ->setLastName($faker->lastName)
                  ->setEmail($faker->email)
                  ->setPassword($faker->password);

            $manager->persist($user);
            
            for($c = 0; $c < 30; $c++){
                $customer = new Customer();
                $customer->setFirstname($faker->firstName())
                         ->setLastname($faker->lastName)
                         ->setCompany($faker->company)
                         ->setEmail($faker->email)
                         ->setUser($user);
    
                $manager->persist($customer);
    
                for($i = 0; $i < mt_rand(3, 10); $i++){
                    $invoice = new Invoice();
                    $invoice->setAmount($faker->randomFloat(2, 250, 5000))
                            ->setSentAt($faker->dateTimeBetween('-6 months'))
                            ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELED']))
                            ->setCustomer($customer)
                            ->setChrono($chrono);
    
                    $chrono++;
    
                    $manager->persist($invoice);
                }
    
            }
        }
        
        $manager->flush();
    }
}
