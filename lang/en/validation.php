<?php

return [
    'accepted'             => 'The :attribute field must be accepted.',
    'email'                => 'The :attribute field must be a valid email address.',
    'max'                  => ['string' => 'The :attribute field must not be greater than :max characters.'],
    'min'                  => ['string' => 'The :attribute field must be at least :min characters.'],
    'required'             => 'The :attribute field is required.',
    'unique'               => 'The :attribute has already been taken.',
    'confirmed'            => 'The :attribute field confirmation does not match.',
    'in'                   => 'The selected :attribute is invalid.',
    'string'               => 'The :attribute field must be a string.',
    'numeric'              => 'The :attribute field must be a number.',
    'password'             => [
        'min'     => 'The :attribute field must be at least :min characters.',
        'mixed'   => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
    ],
    'attributes' => [
        'email'         => 'email address',
        'password'      => 'password',
        'name'          => 'name',
        'title'         => 'title',
        'body'          => 'tip content',
        'description'   => 'description',
        'disaster_type' => 'disaster type',
        'what_to_do'    => 'what to do',
        'what_not_to_do'=> 'what not to do',
    ],
];
