<?php
echo "Loading product...\n";
$p = App\Models\Product::first();
echo "Product loaded.\n";
try {
    $arr = $p->toArray();
    echo "Product toArray success!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
