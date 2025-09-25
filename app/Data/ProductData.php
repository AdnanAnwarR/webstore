<?php
declare(strict_types=1);
namespace App\Data;

use App\Models\Product;
use Spatie\LaravelData\Data;
use Illuminate\Support\Number;
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Attributes\Computed;

class ProductData extends Data
{
    #[Computed]
    public string $price_formatted;


    public function __construct(
        
        public string $name,
        public string $sku,
        public string $slug,
        public string|Optional|null $description,
        public int $stock,
        public float $price,
        public int $weight,
        public string $cover_url
        
        // public array|Optional $gallery

    ) {
        $this->price_formatted = Number::currency($price);
    }

    public static function fromModel(Product $product): self
    {
       return new self (
            $product->name,
            $product->sku,
            $product->slug,
            $product->description,
            $product->stock,
            (float)$product->price,
            $product->weight,
            $product->getFirstMediaUrl('cover')
            
            // $with_gallery ? $product->getMedia('gallery')->map(fn($row) => $row->getUrl())->toArray() : new Optional()
       );
    }
}
