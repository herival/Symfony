<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, "user_admin", function($num){
            
                $utilisateur = new User;

                $email = "admin".$num."@kritik.fr";
                $password = password_hash(("admin".$num), PASSWORD_DEFAULT);
                
                $utilisateur->setEmail($email)
                            ->setPassword($password)
                            ->setRoles(["ROLE_ADMIN"]);
                          
                return $utilisateur;
            
        });

        // $product = new Product();
        // $manager->persist($product);

        //function($num) recupere les variable loop 
        $this->createMany(200, "user_user", function($num){
            
            $utilisateur = new User;

            $email = "user".$num."@mail.fr";
            $password = password_hash(("user".$num), PASSWORD_DEFAULT);
            
            $utilisateur->setEmail($email)
                        ->setPassword($password);
                      
            return $utilisateur;
        
    });





        $manager->flush();



    }
}
