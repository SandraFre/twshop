<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;



class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'price',
        'sale_price',
        'size',
        'description',
        'quantity',
    ];

    public function getFirstImageUrl(): string
    {
        if ($imageFirst = $this->getMedia('product_images')->first()) {
            return $imageFirst->getUrl();
        }

        return url('img/no-image.png');
    }

    /**
     * @return array
     */
    public function getAllImagesUrls(): array
    {
        $images = [];

        $imagesCollection = $this->getMedia('product_images');

        foreach ($imagesCollection as $media) {
            $images[] = $media->getUrl();
        }

        if (empty($images)) {
            $images[] = url('img/no-image.png');
        }

        return $images;
    }
}
