<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'code' => 'required|string|max:100',
            'price' => 'required|min:0.01',
            'sale_price'=> 'nullable',
            'size' => 'nullable|string',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image',

            'categories' => 'nullable|array',
        ];
    }

    public function getData(): array
    {
        return [
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'code'=> $this->getCode(),
            'price' => $this->getPrice(),
            'sale_price' => $this->getSalePrice(),
            'size' => $this->getSize(),
            'description' => $this->getDescription(),
            'quantity' => $this->getQuantity(),
        ];
    }

    public function getCatIds(): array
    {
        return $this->input('categories', []);
    }

    public function getTitle(): string
    {
        return $this->input('title');
    }

    public function getSlug(): string
    {
        $slug = $this->input('slug');

        if (!$slug) {
            $slug = $this->getTitle();
        }

        return Str::slug($slug);
    }

    public function getCode(): string
    {
        return $this->input('code');
    }

    public function getPrice(): float
    {
        return (float)$this->input('price');
    }

    public function getSalePrice(): ?float
    {
        return (float)$this->input('sale_price');
    }

    public function getSize(): ?string
    {
        return $this->input('size');
    }

    public function getDescription(): ?string
    {
        return $this->input('description');
    }

    public function getQuantity(): int
    {
        return $this->input('quantity');
    }

    public function getImage(): ?UploadedFile
    {
        return $this->file('image');
    }
}
