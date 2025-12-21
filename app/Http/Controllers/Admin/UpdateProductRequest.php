<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends StoreProductRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        return $rules;
    }
}
