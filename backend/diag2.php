<?php
$p = App\Models\Product::first();

$appends = ['price', 'rating', 'reviews', 'images', 'specs', 'sizes', 'variants', 'category_name', 'collection_name', 'primary_image', 'image_url', 'primary_image_url'];

foreach ($appends as $append) {
    echo "Testing $append...\n";
    try {
        $val = $p->$append;
        if (is_object($val) && method_exists($val, 'toArray')) {
            $val->toArray();
        } elseif (is_iterable($val)) {
            foreach ($val as $item) {
                if (is_object($item) && method_exists($item, 'toArray')) {
                    $item->toArray();
                }
            }
        }
        echo "Success: $append\n";
    } catch (\Exception $e) {
        echo "Failed $append: " . $e->getMessage() . "\n";
    }
}
echo "All done!\n";
