<?php

namespace App\Http\Requests;

use App\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;


class CategoryStoreRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'image' => 'nullable|image',
        ];
    }

    public function getData(): array
    {
        return [
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
        ];
    }

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->after(function (Validator $validator) {
            if ($this->slugExists()) {
                $validator->errors()->add('slug', 'This slug already exists.');
            }
        });

        return $validator;
    }

    public function getTitle(): string
    {
        return (string)$this->input('title');
    }

    public function getSlug(): string
    {
        $slug = $this->input('slug');

        if (empty($slug)) {
            $slug = $this->getTitle();
        }

        return Str::slug(trim($slug));
    }

    protected function slugExists(): bool
    {
        return Category::query()
            ->where('slug', '=', $this->getSlug())
            ->exists();
    }

    public function getImage(): ?UploadedFile
    {
        return $this->file('image');
    }
}
