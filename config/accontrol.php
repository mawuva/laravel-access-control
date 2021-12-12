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
        'enabled'           => env('ACCONTROL_ROLES_ENABLED', true),
        'name'              => env('ACCONTROL_ROLES_LABEL', 'Role'),
        'slug'              => env('ACCONTROL_ROLES_SLUG', 'role'),
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
        'enabled'                   => true,
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
    | Manage permission config
    */
    'permission' => [
        'enabled'           => env('ACCONTROL_PERMISSIONS_ENABLED', true),
        'name'              => env('ACCONTROL_PERMISSIONS_LABEL', 'Permission'),
        'slug'              => env('ACCONTROL_PERMISSIONS_SLUG', 'permission'),
        'model'             => env('ACCONTROL_PERMISSIONS_MODEL', Mawuekom\Accontrol\Models\Permission::class),

        /*
        | The name of the parameter you set in your web.php or api.php to get permission's ID
        */
        'id_route_param'    => 'id',

        'table'             => [
            'name'                  => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE', 'permissions'),
            'primary_key'           => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'action_foreign_key'    => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE_ACTION_FOREIGN_KEY', 'action_id'),
            'entity_foreign_key'    => env('ACCONTROL_PERMISSIONS_DATABASE_TABLE_ENTITY_FOREIGN_KEY', 'entity_id'),
        ],
    ],

    'permission_role' => [
        'enabled'                       => true,
        'name'                          => env('ACCONTROL_PERMISSION_ROLE_LABEL', 'Permission Role'),
        'slug'                          => env('ACCONTROL_PERMISSION_ROLE_SLUG', 'permission_role'),
        'model'                         => env('ACCONTROL_PERMISSION_ROLE_MODEL', null),

        'table'                         => [
            'name'                      => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE', 'permission_role'),
            'primary_key'               => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'permission_foreign_key'    => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_PERMISSION_FOREIGN_KEY', 'permission_id'),
            'role_foreign_key'          => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_ROLE_FOREIGN_KEY', 'role_id'),
        ],
    ],

    'permission_user' => [
        'enabled'                       => true,
        'name'                          => env('ACCONTROL_PERMISSION_USER_LABEL', 'Permission User'),
        'slug'                          => env('ACCONTROL_PERMISSION_USER_SLUG', 'permission_user'),
        'model'                         => env('ACCONTROL_PERMISSION_USER_MODEL', null),

        'table'                         => [
            'name'                      => env('ACCONTROL_PERMISSION_USER_DATABASE_TABLE', 'permission_user'),
            'primary_key'               => env('ACCONTROL_PERMISSION_USER_DATABASE_TABLE_PRIMARY_KEY', 'id'),
            'permission_foreign_key'    => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_PERMISSION_FOREIGN_KEY', 'permission_id'),
            'user_foreign_key'          => env('ACCONTROL_PERMISSION_ROLE_DATABASE_TABLE_USER_FOREIGN_KEY', 'user_id'),
        ],
    ],

    /*
    | Manage action config
    |
    | Actions are the different operations that are done on an entity.
    | Operations like : Create, Read, Update, Delete
    */
    'action' => [
        'enabled'                   => env('ACCONTROL_ACTIONS_ENABLED', true),
        'name'                      => env('ACCONTROL_ACTIONS_LABEL', 'Action'),
        'slug'                      => env('ACCONTROL_ACTIONS_SLUG', 'action'),
        'model'                     => env('ACCONTROL_ACTIONS_MODEL', Mawuekom\Accontrol\Models\Action::class),

        /*
        | The name of the parameter you set in your web.php or api.php to get action's ID
        */
        'id_route_param'    => 'id',

        'table'                     => [
            'name'                  => env('ACCONTROL_ACTIONS_DATABASE_TABLE', 'actions'),
            'primary_key'           => env('ACCONTROL_ACTIONS_DATABASE_TABLE_PRIMARY_KEY', 'id'),
        ],
    ],

    /*
    | Manage entity config
    |
    | Entities are model on which actions are performed.
    */
    'entity' => [
        'enabled'                   => env('ACCONTROL_ENTITIES_ENABLED', true),
        'name'                      => env('ACCONTROL_ENTITIES_LABEL', 'Entity'),
        'slug'                      => env('ACCONTROL_ENTITIES_SLUG', 'entity'),
        'model'                     => env('ACCONTROL_ENTITIES_MODEL', Mawuekom\Accontrol\Models\Entity::class),

        'table'                     => [
            'name'                  => env('ACCONTROL_ENTITIES_DATABASE_TABLE', 'entities'),
            'primary_key'           => env('ACCONTROL_ENTITIES_DATABASE_TABLE_PRIMARY_KEY', 'id'),
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

