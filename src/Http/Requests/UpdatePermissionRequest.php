<?php

namespace Accontrol\Http\Requests;

use Accontrol\Persistables\PermissionManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class UpdatePermissionRequest extends FormRequestCustomizer
{
    use PermissionManager;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $permissionTable           = config('accontrol.permission.table.name');
        $permissionTablePrimaryKey = config('accontrol.permission.table.primary_key');

        $resource = config('accontrol.permission.resource_name');
        $permission = $this ->validateAndGetResourceById($this ->route('id'), $resource);

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                'unique:'.$permissionTable.',slug,'.$permission ->{$permissionTablePrimaryKey}
            ],
            'description'   => 'string|nullable',
            'entity_id'     => 'int|nullable',
        ];
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [
            'name' => [
                Capitalize::class,
            ],
        ];
    }

    /**
     * Fulfill the permission type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->updatePermission($this ->route('id'), $this ->validated());
    }
}