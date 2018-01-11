<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditArtworks extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
        //dd($this);
        return [
            'titulo_edit'        => 'required|string|max:100',
            'tecnica_edit'       => 'nullable|string|max:200',
            'dimension_edit'     => 'nullable|string|max:200',
            'ano_edit'           => 'nullable|string|max:20',
            'edicion_edit'       => 'nullable|string|max:200',
            'procedencia_edit'   => 'nullable|string|max:200',
            'catalogo_edit'      => 'nullable|string|max:200',
            'certificacion_edit' => 'nullable|string|max:100',
            'valoracion_edit'    => 'nullable|string|max:100',
            'foto1_edit'         => 'nullable|image|mimes:jpeg,bmp,png,jpg|max:5120',
        ];
    }
}
