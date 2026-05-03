<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\PricingService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $pricingService;

    public function __construct(PricingService $pricingService)
    {
        $this->pricingService = $pricingService;
    }

    public function index()
    {
        $products = Product::with('variants')
            ->where('is_active', true)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::with('variants')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json($this->formatProduct($product));
    }

    protected function formatProduct($product)
    {
        $formattedVariants = $product->variants->map(function ($variant) {
            $pricing = $this->pricingService->calculateVariantPrice($variant);
            return array_merge($variant->toArray(), [
                'calculated_price' => $pricing['total_price'],
                'base_price' => $pricing['base_price'],
                'vat_amount' => $pricing['vat_amount'],
                'gold_rate' => $pricing['gold_rate'],
            ]);
        });

        $minPrice = $formattedVariants->min('calculated_price');

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'category' => $product->category,
            'collection' => $product->collection,
            'images' => $product->images,
            'is_featured' => $product->is_featured,
            'min_price' => $minPrice,
            'variants' => $formattedVariants,
        ];
    }
}
