<?php

declare(strict_types=1);

namespace App\DTO;

use App\Category;
use App\DTO\Base\DTO;

class CategoryDTO extends DTO
{
    public function __construct(Category $category) {
        $this->category = $category;
    }

    protected function jsonData(): array
    {
        return [
            'name' => $this->category->title,
            'slug' => $this->category->slug,
            'image' => $this->category->getImageUrl(),

        ];
    }
}
