<?php

namespace Mawuekom\Accontrol\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mawuekom\Accontrol\Assignables\RoleHasRelations;
use Mawuekom\CustomHelpers\Traits\Slugable;
use Mawuekom\ModelUuid\Utils\GeneratesUuid;

class Role extends Model
{
    use SoftDeletes, GeneratesUuid, Slugable, RoleHasRelations;

    /**
     * Create a new model instance.
     *
     * @param array $attributes
     * 
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        /**
         * The table associated with the model.
         *
         * @var string
         */
        $this ->table = config('accontrol.role.table.name');

        /**
         * The primary key associated with the table.
         *
         * @var string
         */
        $this ->primaryKey = config('accontrol.role.table.primary_key');
    }

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'level',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id'                        => 'integer',
        'name'                      => 'string',
        'slug'                      => 'string',
        'description'               => 'string',
        'level'                     => 'integer',
        'created_at'                => 'datetime',
        'updated_at'                => 'datetime',
        'deleted_at'                => 'datetime',
    ];

    /**
     * The names of the columns that should be used for the UUID.
     *
     * @return array
     */
    public function uuidColumns(): array
    {
        return [config('accontrol.uuids.column')];
    }
}