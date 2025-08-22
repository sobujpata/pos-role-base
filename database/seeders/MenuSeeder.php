<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('menus')->truncate();

        // Top-level Menus
        $homeId = DB::table('menus')->insertGetId(['title' => 'Home', 'url' => '#', 'parent_id' => null, 'order' => 1]);
        $pagesId = DB::table('menus')->insertGetId(['title' => 'Pages', 'url' => '#', 'parent_id' => null, 'order' => 2]);
        $productsId = DB::table('menus')->insertGetId(['title' => 'Products', 'url' => '#', 'parent_id' => null, 'order' => 3]);
        $blogId = DB::table('menus')->insertGetId(['title' => 'Blog', 'url' => '#', 'parent_id' => null, 'order' => 4]);
        $shopId = DB::table('menus')->insertGetId(['title' => 'Shop', 'url' => '#', 'parent_id' => null, 'order' => 5]);
        $contactId = DB::table('menus')->insertGetId(['title' => 'Contact Us', 'url' => 'contact.html', 'parent_id' => null, 'order' => 6]);

        // Home Submenus
        DB::table('menus')->insert([
            ['title' => 'Fashion 1', 'url' => 'index.html', 'parent_id' => $homeId, 'order' => 1],
            ['title' => 'Fashion 2', 'url' => 'index-2.html', 'parent_id' => $homeId, 'order' => 2],
            ['title' => 'Furniture 1', 'url' => 'index-3.html', 'parent_id' => $homeId, 'order' => 3],
            ['title' => 'Furniture 2', 'url' => 'index-4.html', 'parent_id' => $homeId, 'order' => 4],
            ['title' => 'Electronics 1', 'url' => 'index-5.html', 'parent_id' => $homeId, 'order' => 5],
            ['title' => 'Electronics 2', 'url' => 'index-6.html', 'parent_id' => $homeId, 'order' => 6],
        ]);

        // Pages Submenus
        DB::table('menus')->insert([
            ['title' => 'About Us', 'url' => 'about.html', 'parent_id' => $pagesId, 'order' => 1],
            ['title' => 'Contact Us', 'url' => 'contact.html', 'parent_id' => $pagesId, 'order' => 2],
            ['title' => 'FAQ', 'url' => 'faq.html', 'parent_id' => $pagesId, 'order' => 3],
            ['title' => '404 Page', 'url' => '404.html', 'parent_id' => $pagesId, 'order' => 4],
            ['title' => 'Login', 'url' => 'login.html', 'parent_id' => $pagesId, 'order' => 5],
            ['title' => 'Register', 'url' => 'signup.html', 'parent_id' => $pagesId, 'order' => 6],
            ['title' => 'Terms & Conditions', 'url' => 'term-condition.html', 'parent_id' => $pagesId, 'order' => 7],
        ]);

        // Products > Submenus
        $womensId = DB::table('menus')->insertGetId(['title' => "Women's", 'url' => '#', 'parent_id' => $productsId, 'order' => 1]);
        $mensId = DB::table('menus')->insertGetId(['title' => "Men's", 'url' => '#', 'parent_id' => $productsId, 'order' => 2]);

        DB::table('menus')->insert([
            ['title' => 'Vestibulum sed', 'url' => 'shop-list-left-sidebar.html', 'parent_id' => $womensId, 'order' => 1],
            ['title' => 'Donec porttitor', 'url' => 'shop-left-sidebar.html', 'parent_id' => $womensId, 'order' => 2],
        ]);

        // Blog > Grids > 3 Cols, 4 Cols
        $gridsId = DB::table('menus')->insertGetId(['title' => 'Grids', 'url' => '#', 'parent_id' => $blogId, 'order' => 1]);
        DB::table('menus')->insert([
            ['title' => '3 Columns', 'url' => 'blog-three-columns.html', 'parent_id' => $gridsId, 'order' => 1],
            ['title' => '4 Columns', 'url' => 'blog-four-columns.html', 'parent_id' => $gridsId, 'order' => 2],
        ]);

        // Shop Submenus
        DB::table('menus')->insert([
            ['title' => 'Shop List View', 'url' => 'shop-list.html', 'parent_id' => $shopId, 'order' => 1],
            ['title' => 'Left Sidebar', 'url' => 'shop-left-sidebar.html', 'parent_id' => $shopId, 'order' => 2],
            ['title' => 'Cart', 'url' => 'shop-cart.html', 'parent_id' => $shopId, 'order' => 3],
            ['title' => 'Checkout', 'url' => 'checkout.html', 'parent_id' => $shopId, 'order' => 4],
            ['title' => 'Wishlist', 'url' => 'wishlist.html', 'parent_id' => $shopId, 'order' => 5],
        ]);
    }
}
