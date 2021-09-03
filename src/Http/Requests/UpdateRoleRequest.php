<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Mawuekom\Accontrol\Persistables\RoleManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class UpdateRoleRequest extends FormRequestCustomizer
{
    use RoleManager;

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
        $roleTable           = config('accontrol.role.table.name');
        $roleTablePrimaryKey = config('accontrol.role.table.primary_key');

        $resource = config('accontrol.role.resource_name');
        $role = $this ->validateAndGetResourceById($this ->route('id'), $resource);

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                'unique:'.$roleTable.',slug,'.$role ->{$roleTablePrimaryKey}
            ],
            'description'   => 'string|nullable',
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
     * Fulfill the role type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->updateRole($this ->route('id'), $this ->validated());
    }
}