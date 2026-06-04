<?php
// FILE: app/Http/Requests/PresensiRequest.php
// Jalankan: php artisan make:request PresensiRequest
// Lalu ganti isinya dengan ini:

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PresensiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jadwal_id' => 'required|exists:jadwals,id',
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }

    public function messages(): array
    {
        return [
            'jadwal_id.required' => 'Jadwal wajib dipilih.',
            'jadwal_id.exists'   => 'Jadwal tidak ditemukan.',
            'latitude.required'  => 'Data GPS latitude wajib ada.',
            'latitude.numeric'   => 'Latitude harus berupa angka.',
            'longitude.required' => 'Data GPS longitude wajib ada.',
            'longitude.numeric'  => 'Longitude harus berupa angka.',
        ];
    }

    // Override agar selalu return JSON untuk API
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi gagal.',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
