<?php
echo "Loading variant...\n";
$v = App\Models\ProductVariant::first();
echo "Variant loaded.\n";
try {
    $arr = $v->toArray();
    echo "Success!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
