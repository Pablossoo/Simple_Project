<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\ShowCartController;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductCart;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class ShowCartControllerFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            new Product('fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', 'Product 1', 1990,4),
            new Product('9670ea5b-d940-4593-a2ac-4589be784203', 'Product 2', 3990,4),
            new Product('15e4a636-ef98-445b-86df-46e1cc0e10b5', 'Product 3', 4990,4),
        ];

        $cart = new Cart('fab8f7c3-a641-43c1-92d3-ee871a55fa8a');

        foreach ($products as $product) {
            $productCart = new ProductCart(Uuid::uuid4()->toString());
            $product->addProductCart($productCart);
            $cart->addProductCart($productCart);
        }

        $manager->persist($productCart);
        $manager->persist($cart);

        $manager->flush();
    }
}
