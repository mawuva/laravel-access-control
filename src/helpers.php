<?php

use Illuminate\Support\Facades\Schema;

if (!function_exists('resolve_key')) {
    /**
     * Get key to use to make queries
     * 
     * @param string $resource
     * @param int|string $id
     * 
     * @return string
     */
    function resolve_key(string $resource, int|string $id = null, $inTrashed = false): string {
        $uuidColumn = config('accontrol.uuids.column');
        $resourcePrimaryKey = config('accontrol.'.$resource.'.table.primary_key');

        return (uuid_is_enabled_and_has_been_detected($resource, $id, $inTrashed))
                ? $uuidColumn
                : $resourcePrimaryKey;
    }
}

if (!function_exists('uuid_is_enabled_and_has_been_detected')) {
    /**
     * Check if uuid is enabled and has been detected.
     * 
     * @param string $resource
     * @param int|string $id
     * 
     * @return bool
     */
    function uuid_is_enabled_and_has_been_detected(string $resource, int|string $id = null, $inTrashed = false): bool {
        $model = config('accontrol.'.$resource.'.model');
        $uuidColumn = config('accontrol.uuids.column');

        return (config('accontrol.uuids.enable') && is_the_given_id_a_uuid($uuidColumn, $id, $model, $inTrashed))
                ? true
                : false;
    }
}

if (!function_exists('uuid_is_enabled_and_has_column')) {
    /**
     * Check if uuid is enabled and has column defined in config.
     * 
     * @return bool
     */
    function uuid_is_enabled_and_has_column(): bool {
        $uuid_enable    = config('accontrol.uuids.enable');
        $uuid_column    = config('accontrol.uuids.column');

        return ($uuid_enable && $uuid_column !== null)
                ? true
                : false;
    }
}

if (!function_exists('resource_does_not_exists_in_schema')) {
    /**
     * Check if account types is enabled and exists in schema.
     * 
     * @return bool
     */
    function resource_does_not_exists_in_schema(string $resource): bool {
        $resource_table  = config('accontrol.'.$resource.'.table.name');

        return (!Schema::hasTable($resource_table))
                ? true
                : false;
    }
}

if (!function_exists('resource_is_enabled_and_does_not_exists_in_schema')) {
    /**
     * Check if account types is enabled and exists in schema.
     * 
     * @return bool
     */
    function resource_is_enabled_and_does_not_exists_in_schema(string $resource): bool {
        $resource_enable = config('accontrol.'.$resource.'.enable');
        $resource_table  = config('accontrol.'.$resource.'.table.name');

        return ($resource_enable && !Schema::hasTable($resource_table))
                ? true
                : false;
    }
}

if (!function_exists('resource_is_enabled_and_exists_in_schema')) {
    /**
     * Check if account types is enabled and exists in schema.
     * 
     * @return bool
     */
    function resource_is_enabled_and_exists_in_schema(string $resource): bool {
        $resource_enable = config('accontrol.'.$resource.'.enable');
        $resource_table  = config('accontrol.'.$resource.'.table.name');

        return ($resource_enable && Schema::hasTable($resource_table))
                ? true
                : false;
    }
}

if ( ! function_exists('check_key_in_array')) {
    /**
     * Chef if a key exists in array
     *
     * @param array $array
     * @param string $key
     * 
     * @return string
     */
    function check_key_in_array(array $array = [], string $key = '') {
        if (is_array($array) && !empty($key)) {
            if (key_exists($key, $array)) {
                if ($array[$key] != null) {
                    return $array[$key];
                }
            }
        }
    }
}

if ( ! function_exists('success_response')) {
    /**
     * Generate username from random string
     *
     * @param string $message
     * @param array|null|Object $data
     * @param int $code
     * 
     * @return array
     */
    function success_response(string $message = 'Action performed successfully', $data = null, int $code = 200): array {
        return [
            'code'      => $code,
            'status'    => 'success',
            'message'   => $message,
            'data'      => $data,
        ];
    }
}

if ( ! function_exists('failure_response')) {
    /**
     * Generate username from random string
     *
     * @param string $message
     * @param array|null|Object $data
     * @param int $code
     * 
     * @return array
     */
    function failure_response(string $message = 'Action attempted failed', $data = null, int $code = 0): array {
        return [
            'code'      => $code,
            'status'    => 'failed',
            'message'   => $message,
            'data'      => $data,
        ];
    }
}
