<?php
echo "Loading variant...\n";
$v = App\Models\ProductVariant::first();
echo "Variant loaded.\n";
try {
    $arr = $v->computed_price;
    echo "Computed price: $arr\n";
    echo "Success!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
