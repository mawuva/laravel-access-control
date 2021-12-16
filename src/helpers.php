<?php

if (!function_exists('uuid_is_enabled_and_has_column_defined')) {
    /**
     * Check if uuid is enabled and has column defined in config.
     * 
     * @return bool
     */
    function uuid_is_enabled_and_has_column_defined(): bool {
        $uuidEnabled    = config('accontrol.uuids.enabled');
        $uuidColumn     = config('accontrol.uuids.column');

        return ($uuidEnabled && $uuidColumn !== null)
                ? true
                : false;
    }
}

if (!function_exists('has_level')) {
    /**
     * Check if user is authenticated and has given level
     * 
     * @return bool
     */
    function has_level($level): bool {
        if (auth() || auth('admin')) {
            $user = (auth('admin') ->user() !== null) ? auth('admin') ->user() : auth() ->user();

            if ($user->level() >= $level) {
                return true;
            }

            return false;
        }

        return false;
    }
}

if (!function_exists('has_permission')) {
    /**
     * Check if user is authenticated and has given permission
     * 
     * @return bool
     */
    function has_permission($permission): bool {
        if (auth() || auth('admin')) {
            $user = (auth('admin') ->user() !== null) ? auth('admin') ->user() : auth() ->user();

            if (str_contains($permission, '|')) {
                $permissions = explode('|', $permission);

                for ($i = 0; $i < count($permissions); $i++) {
                    if ($user->hasRole($permissions[$i])) {
                        return true;
                    }
                }
            }

            else {
                if ($user ->hasPermission($permission)) {
                    return true;
                }
            }

            return false;
        }

        return false;
    }
}

if (!function_exists('has_role')) {
    /**
     * Check if user is authenticated and has given role
     * 
     * @return bool
     */
    function has_role($role): bool {
        if (auth() || auth('admin')) {
            $user = (auth('admin') ->user() !== null) ? auth('admin') ->user() : auth() ->user();

            if (str_contains($role, '|')) {
                $roles = explode('|', $role);

                for ($i = 0; $i < count($roles); $i++) {
                    if ($user->hasRole($roles[$i])) {
                        return true;
                    }
                }
            }

            elseif (is_array($role)) {
                for ($i = 0; $i < count($role); $i++) {
                    if ($user->hasRole($role[$i])) {
                        return true;
                    }
                }
            }

            else {
                if ($user->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return false;
    }
}