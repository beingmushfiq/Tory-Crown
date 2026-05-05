<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use App\Models\GoldRate;
use App\Models\CmsPage;
use App\Models\CmsSection;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Admin
        User::create([
            'name'      => 'Admin User',
            'email'     => 'admin@toricrown.com',
            'phone'     => '01700000000',
            'password'  => Hash::make('12345678'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // 2. Gold Rates
        GoldRate::create(['karat' => '18K', 'price_per_gram' => 8500, 'effective_date' => now()]);
        GoldRate::create(['karat' => '21K', 'price_per_gram' => 9500, 'effective_date' => now()]);
        GoldRate::create(['karat' => '22K', 'price_per_gram' => 10500, 'effective_date' => now()]);
        GoldRate::create(['karat' => '24K', 'price_per_gram' => 11500, 'effective_date' => now()]);

        // 3. Categories & Collections
        $bridalCat = Category::create(['name' => 'Bridal', 'slug' => 'bridal']);
        $ringCat   = Category::create(['name' => 'Rings', 'slug' => 'rings']);
        
        $heritageCol = Collection::create([
            'name' => 'Heritage Collection', 
            'slug' => 'heritage', 
            'description' => 'Classic timeless designs.'
        ]);

        // 4. Products
        $product1 = Product::create([
            'sku'           => 'TC-BR-001',
            'name'          => 'Royal Kundan Necklace',
            'slug'          => 'royal-kundan-necklace',
            'description'   => 'Exquisite 22K gold bridal necklace.',
            'category_id'   => $bridalCat->id,
            'collection_id' => $heritageCol->id,
            'is_active'     => true,
            'is_featured'   => true,
        ]);

        $variant1 = ProductVariant::create([
            'product_id'    => $product1->id,
            'sku'           => 'TC-BR-001-22K',
            'name'          => '22K Standard',
            'karat'         => '22K',
            'weight_grams'  => 45.5,
            'making_charge' => 15000,
            'stock_qty'     => 5,
        ]);

        ProductImage::create([
            'product_id' => $product1->id,
            'url'        => 'https://images.unsplash.com/photo-1599643478524-fb66f7caab6b?q=80&w=600&auto=format&fit=crop',
            'is_primary' => true,
        ]);

        $product2 = Product::create([
            'sku'           => 'TC-RN-001',
            'name'          => 'Diamond Solitaire Ring',
            'slug'          => 'diamond-solitaire-ring',
            'description'   => '18K white gold with 1ct diamond.',
            'category_id'   => $ringCat->id,
            'is_active'     => true,
        ]);

        ProductVariant::create([
            'product_id'    => $product2->id,
            'sku'           => 'TC-RN-001-18K-S7',
            'name'          => 'Size 7',
            'karat'         => '18K',
            'size'          => '7',
            'weight_grams'  => 4.2,
            'stone_type'    => 'Diamond',
            'stone_weight'  => 1.0,
            'making_charge' => 5000,
            'stock_qty'     => 10,
        ]);

        ProductImage::create([
            'product_id' => $product2->id,
            'url'        => 'https://images.unsplash.com/photo-1605100804763-247f67b2548e?q=80&w=600&auto=format&fit=crop',
            'is_primary' => true,
        ]);

        // 5. CMS Pages
        $homePage = CmsPage::create([
            'title'   => 'Home',
            'slug'    => 'home',
            'status'  => 'published',
            'is_home' => true,
        ]);

        CmsSection::create([
            'page_id'    => $homePage->id,
            'type'       => 'hero_split',
            'sort_order' => 1,
            'props_json' => [
                'title'    => 'Luxury Redefined',
                'subtitle' => 'High Jewelry · Crafted in Dhaka',
                'image'    => 'https://images.unsplash.com/photo-1515562141207-7a8efd3f84f3?q=80&w=1200&auto=format&fit=crop',
                'cta_text' => 'Shop Now',
                'cta_url'  => '/collections'
            ]
        ]);

        CmsSection::create([
            'page_id'    => $homePage->id,
            'type'       => 'product_grid',
            'sort_order' => 2,
            'props_json' => [
                'title'           => 'Best Sellers',
                'collection_slug' => 'heritage',
                'limit'           => 4
            ]
        ]);
    }
}
