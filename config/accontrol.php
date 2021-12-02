<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | Here you can change the slug separator. This is very important in matter
    | of magic method __call() and also a `Slugable` trait. The default value
    | is a dot.
    |
    */

    'separator' => env('ACCONTROL_DEFAULT_SEPARATOR', '.'),

    /*
    | Manage role config
    */
    'role'          => [
        'enabled'           => env('ACCONTROL_ROLES_ENABLE', true),
        'name'              => env('ACCONTROL_ROLES_LABEL', 'Role'),
        'slug'                => env('ACCONTROL_ROLES_SLUG', 'role'),
        'model'             => env('ACCONTROL_ROLES_MODEL', Mawuekom\Accontrol\Models\Role::class),

        /*
        | The name of the parameter you set in your web.php or api.php to get role's ID
        */
        'id_route_param'    => 'id',

        'table'             => [
            'name'          => env('ACCONTROL_ROLES_DATABASE_TABLE', 'roles'),
            'primary_key'   => env('ACCONTROL_ROLES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    'role_user'     => [
        'enable'                    => true,
        'name'                      => env('ACCONTROL_ROLE_USER_LABEL', 'Role User'),
        'slug'                      => env('ACCONTROL_ROLE_USER_SLUG', 'role_user'),
        'model'                     => env('ACCONTROL_ROLE_USER_MODEL', null),

        'table'                     => [
            'name'                  => env('ACCONTROL_ROLE_USER_DATABASE_TABLE', 'role_user'),
            'primary_key'           => env('ACCONTROL_ROLE_USER_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'role_foreign_key'      => env('ACCONTROL_ROLE_USER_DATABASE_TABLE_ROLE_FOREIGN_KEY', 'role_id'),
            'user_foreign_key'      => env('ACCONTROL_ROLE_USER_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Inheritance
    |--------------------------------------------------------------------------
    |
    | By default, the plugin is configured so that all roles inherit all
    | permissions applied to roles defined at a lower level than the role in
    | question. If this is not desired, setting the below to false will disable
    | this inheritance
    |
    */

    'role_inheritance' => env('ACCONTROL_ROLES_INHERITANCE', true),

    /*
    |--------------------------------------------------------------------------
    | Add uuid support
    |--------------------------------------------------------------------------
    */

    'uuids' => [
        'enabled'   => env('ACCONTROL_UUID_ENABLED', true),
        'column'    => env('ACCONTROL_UUID_COLUMN', '_id'),
    ],
];

