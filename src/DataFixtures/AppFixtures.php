<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        // Create Admin User
        $admin = new User();
        $admin->setEmail('admin@shop.com');
        $admin->setFirstName('Admin');
        $admin->setLastName('User');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $manager->persist($admin);

        // Create Client User
        $client = new User();
        $client->setEmail('client@shop.com');
        $client->setFirstName('John');
        $client->setLastName('Doe');
        $client->setRoles(['ROLE_USER']);
        $client->setPassword($this->passwordHasher->hashPassword($client, 'client123'));
        $manager->persist($client);

        // Create Categories
        $categories = [];
        $categoryData = [
            ['Electronics', 'Latest electronic devices and gadgets'],
            ['Clothing', 'Fashion and apparel for everyone'],
            ['Books', 'Wide selection of books and literature'],
            ['Home & Garden', 'Everything for your home and garden'],
            ['Sports', 'Sports equipment and fitness gear'],
        ];
        
        foreach ($categoryData as [$name, $description]) {
            $category = new Category();
            $category->setName($name);
            $category->setDescription($description);
            $manager->persist($category);
            $categories[] = $category;
        }

        // Create Products
        $products = [
            ['MacBook Pro 16"', 'High-performance laptop for professionals', '2499.99', 15, $categories[0], 'https://picsum.photos/400/300?random=1'],
            ['iPhone 15 Pro', 'Latest smartphone with advanced features', '1199.99', 50, $categories[0], 'https://picsum.photos/400/300?random=2'],
            ['Wireless Headphones', 'Premium noise-canceling headphones', '299.99', 100, $categories[0], 'https://picsum.photos/400/300?random=3'],
            ['Designer T-Shirt', 'Premium cotton t-shirt', '49.99', 200, $categories[1], 'https://picsum.photos/400/300?random=4'],
            ['Jeans Classic Fit', 'Comfortable blue denim jeans', '79.99', 150, $categories[1], 'https://picsum.photos/400/300?random=5'],
            ['Winter Jacket', 'Warm and stylish winter jacket', '199.99', 75, $categories[1], 'https://picsum.photos/400/300?random=6'],
            ['The Great Novel', 'Bestselling fiction book', '19.99', 80, $categories[2], 'https://picsum.photos/400/300?random=7'],
            ['Programming Guide', 'Complete guide to modern programming', '59.99', 45, $categories[2], 'https://picsum.photos/400/300?random=8'],
            ['Cookery Masterclass', 'Professional cooking techniques', '39.99', 60, $categories[2], 'https://picsum.photos/400/300?random=9'],
            ['Garden Tools Set', 'Complete set of garden tools', '149.99', 30, $categories[3], 'https://picsum.photos/400/300?random=10'],
            ['Indoor Plant Collection', 'Set of 5 beautiful indoor plants', '89.99', 25, $categories[3], 'https://picsum.photos/400/300?random=11'],
            ['Yoga Mat Premium', 'Non-slip professional yoga mat', '49.99', 120, $categories[4], 'https://picsum.photos/400/300?random=12'],
            ['Running Shoes', 'High-performance running shoes', '129.99', 90, $categories[4], 'https://picsum.photos/400/300?random=13'],
            ['Dumbbell Set', '20kg adjustable dumbbell set', '199.99', 40, $categories[4], 'https://picsum.photos/400/300?random=14'],
        ];

        foreach ($products as $productData) {
            $product = new Product();
            $product->setName($productData[0]);
            $product->setDescription($productData[1]);
            $product->setPrice($productData[2]);
            $product->setStock($productData[3]);
            $product->setCategory($productData[4]);
            $product->setImageUrl($productData[5]);
            $product->setIsActive(true);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
