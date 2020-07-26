<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize():bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:1',
        ];
    }

    public function getData(): array
    {
        return [
            'product_id' => $this->input('product_id'),
            'title' => $this->input('title'),
            'price' => $this->input('price'),
            'quantity' => $this->input('quantity'),
        ];
    }
}
