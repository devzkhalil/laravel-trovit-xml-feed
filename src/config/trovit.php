<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trovit XML Feed Format Fields
    |--------------------------------------------------------------------------
    |
    | Here is the list of fields obtained from
    | https://help.thribee.com/hc/en-us/articles/7920567396124-UK-Jobs-feed
    |
    |--------------------------------------------------------------------------
    | Mandatory Fields
    |--------------------------------------------------------------------------
    | id
    | url
    | title
    | content
    |
    | Other fields are optional.
    | You can comment out fields if you don't need them.
    |
    */
    'fields' => [
        'id',
        'title',
        'url',
        'content',
        'city',
        'city_area',
        'region',
        'postcode',
        'salary',
        'working_hours',
        'company',
        'experience',
        'requirements',
        'contract',
        'category',
        'date',
        'studies'
    ],

    /*
    |--------------------------------------------------------------------------
    | Field Mapping
    |--------------------------------------------------------------------------
    |
    | The field_mapping configuration allows
    | you to define mappings between the fields in your model
    | and the corresponding fields expected by Trovit in the XML feed.
    | This mapping is particularly useful  when the field names
    | in your model differ from the field names expected by Trovit.

    | For example, if your model has a field named description
    | but Trovit expects this information under the content field,
    | you can use the field_mapping configuration to specify this mapping:
    */

    'field_mapping' => [
        // 'model_column_name' => 'trovit_field',
        // 'description' => 'content',

        // Add more mappings as needed
    ]
];
