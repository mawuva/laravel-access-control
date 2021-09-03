<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Mawuekom\Accontrol\Persistables\PermissionManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class SearchPermissionRequest extends FormRequestCustomizer
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
        return [
            'searchTerm'          => 'required|string',
        ];
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [];
    }

    /**
     * Fulfill the permission request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->searchPermissions($this ->searchTerm);
    }
}