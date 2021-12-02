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

