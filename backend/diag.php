<?php
$p = App\Models\Product::first();
echo "Product loaded. Memory: " . memory_get_usage() . "\n";
$arr = $p->toArray();
echo "Converted to array. Memory: " . memory_get_usage() . "\n";
echo "Done.\n";
