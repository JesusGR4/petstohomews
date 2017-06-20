<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El :attribute debe ser aceptado.',
    'active_url'           => 'El :attribute no es una URL válida',
    'after'                => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal'       => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha'                => 'El :attribute debe contener letras.',
    'alpha_dash'           => 'El :attribute debe contener letras, números y letras.',
    'alpha_num'            => 'El :attribute debe contener letras y números.',
    'array'                => 'El :attribute debe ser un array.',
    'before'               => 'El :attribute debe ser una fecha previa a :date.',
    'before_or_equal'      => 'El :attribute debe ser una fecha previa o igual a :date.',
    'between'              => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file'    => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string'  => 'El :attribute debe estar entre :min y :max characters.',
        'array'   => 'El :attribute debe estar entre :min y :max items.',
    ],
    'boolean'              => 'El :attribute field must be true or false.',
    'confirmed'            => 'El :attribute confirmation does not match.',
    'date'                 => 'El :attribute is not a valid date.',
    'date_format'          => 'El :attribute does not match the format :format.',
    'different'            => 'El :attribute and :other must be different.',
    'digits'               => 'El :attribute must be :digits digits.',
    'digits_between'       => 'El :attribute must be between :min and :max digits.',
    'dimensions'           => 'El :attribute has invalid image dimensions.',
    'distinct'             => 'El :attribute field has a duplicate value.',
    'email'                => 'El :attribute must be a valid email address.',
    'exists'               => 'El selected :attribute is invalid.',
    'file'                 => 'El :attribute must be a file.',
    'filled'               => 'El :attribute field is required.',
    'image'                => 'El :attribute must be an image.',
    'in'                   => 'El selected :attribute is invalid.',
    'in_array'             => 'El :attribute field does not exist in :other.',
    'integer'              => 'El :attribute must be an integer.',
    'ip'                   => 'El :attribute must be a valid IP address.',
    'json'                 => 'El :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'El :attribute may not be greater than :max.',
        'file'    => 'El :attribute may not be greater than :max kilobytes.',
        'string'  => 'El :attribute may not be greater than :max characters.',
        'array'   => 'El :attribute may not have more than :max items.',
    ],
    'mimes'                => 'El :attribute must be a file of type: :values.',
    'mimetypes'            => 'El :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'El :attribute debe ser al menos :min.',
        'file'    => 'El :attribute debe ser al menos :min kilobytes.',
        'string'  => 'El :attribute debe ser al menos :min characters.',
        'array'   => 'El :attribute debe ser al menos :min items.',
    ],
    'not_in'               => 'El :attribute es inválido.',
    'numeric'              => 'El :attribute debe ser un número.',
    'present'              => 'El :attribute debe estar presente.',
    'regex'                => 'El :attribute formato es inválido.',
    'required'             => 'El :attribute es requerido.',
    'required_if'          => 'El :attribute es requerido cuando :other es :value.',
    'required_unless'      => 'El :attribute es requerido al menos :other esté en :values.',
    'required_with'        => 'El :attribute es requerido cuando :values es present.',
    'required_with_all'    => 'El :attribute es requerido cuando :values is present.',
    'required_without'     => 'El :attribute es requerido cuando :values no esté presente.',
    'required_without_all' => 'El :attribute es requerido cuando ninguno de :values estén presentes.',
    'same'                 => 'El :attribute y :other deben coincidir.',
    'size'                 => [
        'numeric' => 'El :attribute debe ser :size.',
        'file'    => 'El :attribute debe ser :size kilobytes.',
        'string'  => 'El :attribute debe ser :size letras.',
        'array'   => 'El :attribute debe contener :size elementos.',
    ],
    'string'               => 'El :attribute debe ser un string.',
    'timezone'             => 'El :attribute debe ser una zona válida.',
    'unique'               => 'El :attribute ya ha sido cogido.',
    'uploaded'             => 'El :attribute fallo al subir.',
    'url'                  => 'El :attribute formato es inválido.',
    'extension'            => 'El formato de la imagen debe ser.jpg o .png',
    'ordersuccess'         => 'Su solicitud está siendo gestionada por el administrador',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
