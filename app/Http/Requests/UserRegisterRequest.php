<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // true untuk siapapun bisa registrasi, kalau false itu hanya untuk tamu untuk dibolehkan registrasi
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        //function untuk validasi
        return [
            'username' => [ 'required', 'max:100'],
            'password' => [ 'required', 'max:100'],
            'name' => [ 'required', 'max:100'],

        ];
    }
// untuk ketika failed dalam validation karna kondisinnya sudah ada user dalam database pada saat pengecekan
//atau response failed
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
           "errors" => $validator->getMessageBag()
        ], 400));
    }
}
