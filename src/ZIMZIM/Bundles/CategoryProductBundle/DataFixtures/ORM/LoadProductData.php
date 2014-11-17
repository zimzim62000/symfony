<?php

namespace ZIMZIM\Bundles\CategoryProductBundle\DataFixtures\ORM;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ZIMZIM\Bundles\CategoryProductBundle\Entity\Product;


class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $om)
    {
        $filename = 'product_default.gif';

        for ($i = 0; $i < 50; $i++) {
            $zimzim = new Product();
            $zimzim->setName('Product ' . $i);
            $zimzim->setTitle('Product ' . $i);
            $zimzim->setDescription('Description ' . $i);
            $zimzim->setPath1($filename);
            $zimzim->setPath2($filename);
            $zimzim->setPath3($filename);
            $zimzim->setPath4($filename);

            $tabValue = array();
            for ($j = 1; $j < 4; $j++) {
                $num = rand(1, 5);
                if (!in_array($num, $tabValue)) {
                    $tabValue[] = $num;
                    $type = rand(1, 2);
                    if ($type === 1) {
                        $type = 'adore';
                    } else {
                        $type = 'deteste';
                    }
                    $category = $this->getReference($num . $type);
                    $zimzim->addCategory($category);
                }
            }

            $om->persist($zimzim);
            $this->addReference('Product-' . $i, $zimzim);
        }
        $om->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}