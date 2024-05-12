<?php

namespace App\Http\Controllers\Validators;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

class RegisterEmployeeValidator
{
    public static function validate(Request $request): Validator
    {
        return ValidatorFacade::make($request->all(), [
            'first_name' => 'required|regex:/^[A-Z\s]+$/|max:20',
            'paternal_name' => 'required|regex:/^[A-Z\s]+$/|max:20',
            'maternal_name' => 'required|regex:/^[A-Z\s]+$/|max:20',
            'other_names' => 'nullable|regex:/^[A-Z\s]+$/|max:50',
            'employment_country' => 'required|in:Colombia,United States',
            'id_type' => 'required|in:Cédula de Ciudadanía,Cédula de Extranjería,Pasaporte,Permiso Especial',
            'id_number' => 'required|regex:/^[a-zA-Z0-9\-]+$/|max:20|unique:employees',
            'area' => 'required|in:Administración, Financiera, Compras, Infraestructura, Operación, Talento Humano, Servicios Varios',
        ], [
            'first_name.required' => 'El campo de primer nombre es obligatorio.',
            'first_name.regex' => 'El primer nombre solo puede contener letras mayúsculas y espacios.',
            'first_name.max' => 'El primer nombre no puede tener más de 20 caracteres.',
            'paternal_name.required' => 'El campo de apellido paterno es obligatorio.',
            'paternal_name.regex' => 'El apellido paterno solo puede contener letras mayúsculas y espacios.',
            'paternal_name.max' => 'El apellido paterno no puede tener más de 20 caracteres.',
            'maternal_name.required' => 'El campo de apellido materno es obligatorio.',
            'maternal_name.regex' => 'El apellido materno solo puede contener letras mayúsculas y espacios.',
            'maternal_name.max' => 'El apellido materno no puede tener más de 20 caracteres.',
            'other_names.regex' => 'Los otros nombres solo pueden contener letras mayúsculas y espacios.',
            'other_names.max' => 'Los otros nombres no pueden tener más de 50 caracteres.',
            'employment_country.required' => 'El campo de país de empleo es obligatorio.',
            'employment_country.in' => 'El país de empleo seleccionado no es válido.',
            'id_type.required' => 'El campo de tipo de identificación es obligatorio.',
            'id_type.in' => 'El tipo de identificación seleccionado no es válido.',
            'id_number.required' => 'El campo de número de identificación es obligatorio.',
            'id_number.regex' => 'El número de identificación solo puede contener letras, números y guiones.',
            'id_number.max' => 'El número de identificación no puede tener más de 20 caracteres.',
            'id_number.unique' => 'El número de identificación ya ha sido tomado.',
            'area.required' => 'El campo de área es obligatorio.',
        ]);
    }
}
