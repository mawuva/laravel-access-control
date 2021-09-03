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
    |--------------------------------------------------------------------------
    | Accontrol feature settings
    |--------------------------------------------------------------------------
    */

    'action' => [
        'enable'                    => env('ACCONTROL_ACTIONS_ENABLE', true),
        'name'                      => env('ACCONTROL_ACTIONS_LABEL', 'Action'),
        'resource_name'             => env('ACCONTROL_ACTIONS_RESOURCE_NAME', 'action'),
        'model'                     => env('ACCONTROL_ACTIONS_MODEL', Mawuekom\Accontrol\Models\Action::class),

        'table'                     => [
            'name'                  => env('ACCONTROL_ACTIONS_DATABASE_TABLE', 'actions'),
            'primary_key'           => env('ACCONTROL_ACTIONS_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    'entity' => [
        'enable'                    => env('ACCONTROL_ENTITIES_ENABLE', true),
        'name'                      => env('ACCONTROL_ENTITIES_LABEL', 'Entity'),
        'resource_name'             => env('ACCONTROL_ENTITIES_RESOURCE_NAME', 'entity'),
        'model'                     => env('ACCONTROL_ENTITIES_MODEL', Mawuekom\Accontrol\Models\Entity::class),

        'table'                     => [
            'name'                  => env('ACCONTROL_ENTITIES_DATABASE_TABLE', 'entities'),
            'primary_key'           => env('ACCONTROL_ENTITIES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    'role' => [
        'enable'                    => env('ACCONTROL_ROLES_ENABLE', true),
        'name'                      => env('ACCONTROL_ROLES_LABEL', 'Role'),
        'resource_name'             => env('ACCONTROL_ROLES_RESOURCE_NAME', 'role'),
        'model'                     => env('ACCONTROL_ROLES_MODEL', Mawuekom\Accontrol\Models\Role::class),

        'table'                     => [
            'name'                  => env('ACCONTROL_ROLES_DATABASE_TABLE', 'roles'),
            'primary_key'           => env('ACCONTROL_ROLES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    'role_user' => [
        'enable'                    => true,
        'name'                      => env('ACCONTROL_ROLE_USER_LABEL', 'Role User'),
        'resource_name'             => env('ACCONTROL_ROLE_USER_RESOURCE_NAME', 'role_user'),
        'model'                     => env('ACCONTROL_ROLE_USER_MODEL', null),

        'table'                     => [
            'name'                  => env('ACCONTROL_ROLE_USER_DATABASE_TABLE', 'role_user'),
            'primary_key'           => env('ACCONTROL_ROLE_USER_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'role_foreign_key'      => env('ACCONTROL_ROLE_USER_DATABASE_TABLE_ROLE_FOREIGN_KEY', 'role_id'),
            'user_foreign_key'      => env('ACCONTROL_ROLE_USER_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
        ],
    ],

    'permission' => [
        'enable'                    => true,
        'name'                      => env('ACCONTROL_PERMISSIONS_LABEL', 'Permission'),
        'resource_name'             => env('ACCONTROL_PERMISSIONS_RESOURCE_NAME', 'permission'),
        'model'                     => env('ACCONTROL_PERMISSIONS_MODEL', Mawuekom\Accontrol\Models\Permission::class),

        'table'                     => [
            'name'                  => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE', 'permissions'),
            'primary_key'           => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'action_foreign_key'    => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE_ACTION_FOREIGN_KEY', 'action_id'),
            'entity_foreign_key'    => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE_ENTITY_FOREIGN_KEY', 'entity_id'),
        ],
    ],

    'permission_role' => [
        'enable'                    => true,
        'name'                      => env('ACCONTROL_PERMISSION_ROLE_LABEL', 'Permission Role'),
        'resource_name'             => env('ACCONTROL_PERMISSION_ROLE_RESOURCE_NAME', 'permission_role'),
        'model'                     => env('ACCONTROL_PERMISSION_ROLE_MODEL', null),

        'table'                     => [
            'name'                      => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE', 'permission_role'),
            'primary_key'               => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'permission_foreign_key'    => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_PERMISSION_FOREIGN_KEY', 'permission_id'),
            'role_foreign_key'          => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_ROLE_FOREIGN_KEY', 'role_id'),
        ],
    ],

    'permission_user' => [
        'enable'                    => true,
        'name'                      => env('ACCONTROL_PERMISSION_USER_LABEL', 'Permission User'),
        'resource_name'             => env('ACCONTROL_PERMISSION_USER_RESOURCE_NAME', 'permission_user'),
        'model'                     => env('ACCONTROL_PERMISSION_USER_MODEL', null),

        'table'                     => [
            'name'                  => env('ACCONTROL_PERMISSION_USER_DATABASE_TABLE', 'permission_user'),
            'primary_key'           => env('ACCONTROL_PERMISSION_USER_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'permission_foreign_key'    => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_PERMISSION_FOREIGN_KEY', 'permission_id'),
            'user_foreign_key'          => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
        ],
    ],

    'user' => [
        'model'                     => env('ACCONTROL_USERS_MODEL', App\Models\User::class),
        'name'                      => env('ACCONTROL_USERS_LABEL', 'User'),
        'resource_name'             => env('ACCONTROL_USERS_RESOURCE_NAME', 'user'),

        'table'                     => [
            'name'                      => env('ACCONTROL_USERS_DATABASE_TABLE', 'users'),
            'primary_key'               => env('ACCONTROL_USERS_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bunch of features to enable or disable.
    |--------------------------------------------------------------------------
    */

    'enable' => [],

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
        'enable' => env('ACCONTROL_UUID_ENABLE', true),
        'column' => env('ACCONTROL_UUID_COLUMN', '_id'),
    ],
];

