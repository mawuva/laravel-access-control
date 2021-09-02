<?php

namespace Accontrol\Traits;

use Exception;
use Illuminate\Http\Response;

trait DataRecordsChecker
{
    public function checkDataResource()
    {
        
    }

    /**
     * Check if the given records or collection contains data or not
     *
     * @param [type] $records
     * @param string $message
     * @param int $code
     * @param bool $exception
     * 
     * @throws Exception
     *
     * @return array
     */
    public function checkDataRecords($records, string $message, int $code = Response::HTTP_NO_CONTENT, $exception = false)
    {
        if ($records ->count() === 0) {
            if ($exception) {
                throw new Exception($message, $code);
            }

            return failure_response($message, null, $code);
        }
    }
}