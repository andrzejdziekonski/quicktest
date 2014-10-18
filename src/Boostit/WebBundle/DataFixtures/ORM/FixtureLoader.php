<?php

namespace Boostit\WebBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Boostit\WebBundle\Entity\Product;

class FixtureLoader implements FixtureInterface
{ 
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em) {
       $this->createNewProduct($em,array('Pluszowy miś','Piłka nożna','Gra planszowa'));
    }
    
    private function createNewProduct($em, $nameArray){
        foreach($nameArray as $name){
            $product = new Product();            
            $product->setName($name);
            $em->persist($product);
        }
        $em->flush();
    }
 
}