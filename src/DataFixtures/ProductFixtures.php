<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        // fixture données test 
        // https://fakerphp.github.io/
        // terminal composer require fakerphp/faker

        $faker = \Faker\Factory::create('fr_FR');
        // B1: Génération des catégories
        for($i=1; $i<=5; $i++){
            $category = new Category();
            $category->setName($faker->word());
            $manager->persist($category);

            // B2: Génération des produits de cette catégory
            for($j=1;$j<=mt_rand(3,5); $j++){
                $product = new Product();
                $product->setName($faker->word())   
                    ->setCategory($category)
                    ->setQuantite($faker->randomNumber(3))
                    ->setUnitPrice($faker->randomNumber(2));
                $manager->persist($product);

            }  // B2
        } // B3
        $manager->flush();
    }
}
