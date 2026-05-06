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
use App\Models\Order;
use App\Models\OrderItem;
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
        $categories = [
            'Rings'     => Category::create(['name' => 'Rings', 'slug' => 'rings']),
            'Necklaces' => Category::create(['name' => 'Necklaces', 'slug' => 'necklaces']),
            'Earrings'  => Category::create(['name' => 'Earrings', 'slug' => 'earrings']),
            'Bracelets' => Category::create(['name' => 'Bracelets', 'slug' => 'bracelets']),
            'Pendants'  => Category::create(['name' => 'Pendants', 'slug' => 'pendants']),
        ];

        $collections = [
            'Celestial Rings'    => Collection::create(['name' => 'Celestial Rings', 'slug' => 'celestial-rings', 'description' => 'Symbols of everlasting devotion.']),
            'Majestic Necklaces' => Collection::create(['name' => 'Majestic Necklaces', 'slug' => 'majestic-necklaces', 'description' => 'Elegance that transcends generations.']),
            'Radiant Earrings'   => Collection::create(['name' => 'Radiant Earrings', 'slug' => 'radiant-earrings', 'description' => 'Grace in every movement.']),
            'Infinite Bracelets' => Collection::create(['name' => 'Infinite Bracelets', 'slug' => 'infinite-bracelets', 'description' => 'Brilliance on your wrist.']),
            'Timeless Pendants'  => Collection::create(['name' => 'Timeless Pendants', 'slug' => 'timeless-pendants', 'description' => 'Heritage and history in every piece.']),
        ];

        // 4. Products Data
        $productsData = [
            'Celestial Rings' => [
                ['Celestial Solitaire Ring', 'celestial-solitaire-ring', '18K white gold with 1.2ct diamond.', 'https://images.unsplash.com/photo-1605100804763-247f67b3557e'],
                ['Lunar Eclipse Band', 'lunar-eclipse-band', 'Mystical black diamond eternity band.', 'https://images.unsplash.com/photo-1603561591411-07134e71a2a9'],
                ['Starlight Pavé Ring', 'starlight-pave-ring', 'Micro-pavé diamonds on a thin gold band.', 'https://images.unsplash.com/photo-1544451240-8451121d5964'],
                ['Nova Diamond Ring', 'nova-diamond-ring', 'Explosion of brilliance with center emerald cut.', 'https://images.unsplash.com/photo-1598560912015-6213717278d2'],
                ['Galaxy Twist Ring', 'galaxy-twist-ring', 'Intertwined bands of rose and white gold.', 'https://images.unsplash.com/photo-1617038220319-276d3cfab638'],
                ['Nebula Opal Ring', 'nebula-opal-ring', 'Iridescent opal surrounded by cosmic diamonds.', 'https://images.unsplash.com/photo-1588444837495-c6cfaf504670'],
            ],
            'Majestic Necklaces' => [
                ['Royal Majesty Choker', 'royal-majesty-choker', 'Fit for royalty, featuring rubies and pearls.', 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f'],
                ['Imperial Pearl Necklace', 'imperial-pearl-necklace', 'Hand-selected South Sea pearls.', 'https://images.unsplash.com/photo-1515562141589-67f0d569b610'],
                ['Empress Emerald Pendant', 'empress-emerald-pendant', 'Vibrant Colombian emerald in 22K gold.', 'https://images.unsplash.com/photo-1601121141461-9d6647bca1ed'],
                ['Sovereign Gold Chain', 'sovereign-gold-chain', 'Heavy 24K solid gold braided chain.', 'https://images.unsplash.com/photo-1611085583191-a3b1a308c021'],
                ['Regency Diamond Collier', 'regency-diamond-collier', 'Sophisticated cascade of brilliant diamonds.', 'https://images.unsplash.com/photo-1624479355528-25000ca04f04'],
                ['Monarch Sapphire Necklace', 'monarch-sapphire-necklace', 'Deep blue sapphire surrounded by diamonds.', 'https://images.unsplash.com/photo-1599643477877-537ef527848f'],
            ],
            'Radiant Earrings' => [
                ['Solar Flare Studs', 'solar-flare-studs', 'Brilliant yellow diamond studs.', 'https://images.unsplash.com/photo-1630019852942-f89202989a59'],
                ['Aurora Drop Earrings', 'aurora-drop-earrings', 'Pavé set diamonds inspired by Northern Lights.', 'https://images.unsplash.com/photo-1598560912015-6213717278d2'],
                ['Prism Halo Earrings', 'prism-halo-earrings', 'Geometric design with a central diamond halo.', 'https://images.unsplash.com/photo-1617038220319-276d3cfab638'],
                ['Crystal Cascade Drops', 'crystal-cascade-drops', 'Long flowing drops of clear crystals.', 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908'],
                ['Luminous Hoop Earrings', 'luminous-hoop-earrings', 'Classic 18K gold hoops with internal diamonds.', 'https://images.unsplash.com/photo-1589128777073-263566ae5e4d'],
                ['Vivid Ruby Studs', 'vivid-ruby-studs', 'Intense red rubies in a crown setting.', 'https://images.unsplash.com/photo-1626784215021-2e39ccf971cd'],
            ],
            'Infinite Bracelets' => [
                ['Eternal Link Bracelet', 'eternal-link-bracelet', 'Solid gold links that never go out of style.', 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a'],
                ['Infinity Knot Bangle', 'infinity-knot-bangle', 'Elegant gold bangle with a central infinity knot.', 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0'],
                ['Serenity Cuff', 'serenity-cuff', 'Minimalist brushed gold cuff for daily wear.', 'https://images.unsplash.com/photo-1515562141589-67f0d569b610'],
                ['Harmonious Tennis Bracelet', 'harmonious-tennis-bracelet', 'Continuous line of diamonds in 18K white gold.', 'https://images.unsplash.com/photo-1611591437248-2651475c7423'],
                ['Endless Charm Bracelet', 'endless-charm-bracelet', 'Add your own story with unique gold charms.', 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a'],
                ['Boundless Gold Bangle', 'boundless-gold-bangle', 'Hammered gold finish for a textured look.', 'https://images.unsplash.com/photo-1515562141207-7a8efd3f84f3'],
            ],
            'Timeless Pendants' => [
                ['Legacy Heart Pendant', 'legacy-heart-pendant', 'Engravable gold heart with a tiny diamond.', 'https://images.unsplash.com/photo-1515562141207-7a8efd3f84f3'],
                ['Ancestral Locket', 'ancestral-locket', 'Vintage style locket in antique gold finish.', 'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf'],
                ['Everlasting Cross Pendant', 'everlasting-cross-pendant', 'Diamond encrusted cross on a delicate chain.', 'https://images.unsplash.com/photo-1611085583191-a3b1a308c021'],
                ['Historic Medallion', 'historic-medallion', 'Embossed gold medallion with historical motifs.', 'https://images.unsplash.com/photo-1599643477877-537ef527848f'],
                ['Classic Teardrop Pendant', 'classic-teardrop-pendant', 'A single pear-shaped sapphire on white gold.', 'https://images.unsplash.com/photo-1601121141461-9d6647bca1ed'],
                ['Vintage Key Charm', 'vintage-key-charm', 'Ornate key design in 18K yellow gold.', 'https://images.unsplash.com/photo-1515562141207-7a8efd3f84f3'],
            ],
        ];

        foreach ($productsData as $colName => $items) {
            $collection = $collections[$colName];
            $categoryKey = explode(' ', $colName)[1]; // e.g. Rings
            $category = $categories[$categoryKey];

            foreach ($items as $index => $item) {
                $product = Product::create([
                    'sku'           => 'TC-' . strtoupper(substr($categoryKey, 0, 2)) . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'name'          => $item[0],
                    'slug'          => $item[1],
                    'description'   => $item[2],
                    'category_id'   => $category->id,
                    'collection_id' => $collection->id,
                    'is_active'     => true,
                    'is_featured'   => ($index === 0),
                ]);

                ProductVariant::create([
                    'product_id'    => $product->id,
                    'sku'           => $product->sku . '-STD',
                    'name'          => 'Standard',
                    'karat'         => '22K',
                    'weight_grams'  => rand(5, 50),
                    'making_charge' => rand(5000, 20000),
                    'stock_qty'     => rand(1, 15),
                ]);

                ProductImage::create([
                    'product_id' => $product->id,
                    'url'        => $item[3] . '?q=80&w=800&auto=format&fit=crop',
                    'is_primary' => true,
                ]);
            }
        }

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
                'subtitle' => 'High Jewelry · Crafted with Passion',
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
                'title'           => 'Featured Celestial Rings',
                'collection_slug' => 'celestial-rings',
                'limit'           => 4
            ]
        ]);

        // 6. Create 10 Sample Orders
        $customer = User::create([
            'name'      => 'Test Customer',
            'email'     => 'customer@example.com',
            'phone'     => '01800000000',
            'password'  => Hash::make('password'),
            'role'      => 'customer',
            'is_active' => true,
        ]);

        $allProducts = Product::with('variants')->get();

        for ($i = 1; $i <= 10; $i++) {
            $order = Order::create([
                'user_id'           => $customer->id,
                'status'            => ['pending', 'confirmed', 'processing', 'shipped', 'delivered'][rand(0, 4)],
                'recipient_name'    => $customer->name,
                'recipient_phone'   => $customer->phone,
                'shipping_address'  => 'Sample Address ' . $i,
                'shipping_city'     => 'Dhaka',
                'shipping_district' => 'Dhaka',
                'subtotal'          => 0,
                'shipping_fee'      => 100,
                'vat'               => 0,
                'total'             => 0,
                'payment_method'    => 'cod',
                'payment_status'    => 'unpaid',
                'source'            => 'web',
            ]);

            $subtotal = 0;
            $itemsCount = rand(1, 3);
            for ($j = 0; $j < $itemsCount; $j++) {
                $product = $allProducts->random();
                $variant = $product->variants->first();
                $qty = rand(1, 2);
                $unitPrice = rand(1000, 5000);
                $totalPrice = $unitPrice * $qty;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $product->id,
                    'variant_id'   => $variant->id,
                    'product_name' => $product->name,
                    'variant_name' => $variant->name,
                    'sku'          => $variant->sku,
                    'qty'          => $qty,
                    'unit_price'   => $unitPrice,
                    'total_price'  => $totalPrice,
                ]);

                $subtotal += $totalPrice;
            }

            $order->update([
                'subtotal' => $subtotal,
                'total'    => $subtotal + $order->shipping_fee,
            ]);
        }
    }
}
