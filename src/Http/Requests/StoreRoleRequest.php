<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Mawuekom\Accontrol\Persistables\RoleManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class StoreRoleRequest extends FormRequestCustomizer
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
        $roles_table = config('accontrol.role.table.name');

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                'unique:'.$roles_table.',slug'
            ],
            'description'   => 'string',
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
        return $this ->createRole($this ->validated());
    }
}