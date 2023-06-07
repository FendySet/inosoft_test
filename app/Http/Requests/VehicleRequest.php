<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'release_year' => 'required|integer',
            'color' => 'required',
            'price' => 'required|numeric',
            'machine' => 'required',
            'vehicle' => [
                'required',
                Rule::in(['mobil', 'motor']),
            ]
        ];

        if($this->vehicle == 'mobil'){
            $rules['passenger_capacity'] = ['required','integer'];
            $rules['type'] = ['required'];
        }

        if($this->vehicle == 'motor'){
            $rules['suspension_type'] = ['required'];
            $rules['transmission_type'] = ['required'];
        }

        return $rules;
    }
}
