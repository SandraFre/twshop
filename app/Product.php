<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;



/**
 * App\Product
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $code
 * @property float $price
 * @property float|null $sale_price
 * @property string|null $size
 * @property string|null $description
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product whereCode($value)
 */
class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'code',
        'price',
        'sale_price',
        'size',
        'description',
        'quantity',
    ];

    public function categories(): BelongsToMany
    {
       return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

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
