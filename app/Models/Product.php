<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\ActiveRecord;

class Product extends ActiveRecord
{
    protected static string $table = 'products';
    protected array $attributes = ['name', 'price', 'count_stock'];
}