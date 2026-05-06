<?php
echo "Loading variant...\n";
$v = App\Models\ProductVariant::first();
echo "Variant loaded.\n";
try {
    $arr = $v->price_modifier;
    echo "Price modifier: $arr\n";
    echo "Success!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
