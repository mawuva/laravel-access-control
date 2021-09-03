<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Mawuekom\Accontrol\Persistables\PermissionManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class StorePermissionRequest extends FormRequestCustomizer
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
        $permissions_table = config('accontrol.permission.table.name');

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                'unique:'.$permissions_table.',slug'
            ],
            'description'   => 'string',
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
        return $this ->createPermission($this ->validated());
    }
}