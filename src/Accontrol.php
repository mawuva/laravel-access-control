<?php

namespace Mawuekom\Accontrol;

use Illuminate\Database\Eloquent\Model;

class Accontrol
{
    /**
     * Get entity resource by field and value
     * 
     * @param string $entity_slug
     * @param string $attribute
     * @param string $value
     * @param bool   $inTrashed
     * @param array  $columns
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntityByField(string $entity_slug, $field, $value = null, $inTrashed = false, $columns = ['*']): Model
    {
        $data = app(config('accontrol.'.$entity_slug.'.model')) ->where($field, '=', $value);

        return ($inTrashed)
                    ? $data ->withTrashed() ->first($columns)
                    : $data ->first($columns);
    }

    /**
     * Get entity resource by id
     * 
     * @param string        $entity_slug
     * @param int|string    $id
     * @param bool          $inTrashed
     * @param array         $columns
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntityById(string $entity_slug, $id, $inTrashed = false, $columns = ['*'])
    {
        $key = resolve_key('accontrol', config('accontrol.'.$entity_slug.'.slug'), $id, $inTrashed);

        return $this ->getEntityByField($entity_slug, $key, $id, $inTrashed, $columns);
    }
}
