<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\Accontrol\DataTransferObjects\PermissionDTO;
use Mawuekom\Accontrol\Services\PermissionService;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class StorePermissionRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Accontrol\Services\PermissionService
     */
    protected $permissionService;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Accontrol\Services\PermissionService $permissionService
     */
    public function __construct(PermissionService $permissionService)
    {
        parent::__construct();
        $this ->permissionService = $permissionService;
    }

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
        $permissionsTable = config('accontrol.permission.table.name');

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                Rule::unique($permissionsTable, 'slug')
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
            ]
        ];
    }

    /**
     * Build and return a DTO
     *
     * @return \Mawuekom\Accontrol\DataTransferObjects\PermissionDTO
     */
    public function toDTO(): PermissionDTO
    {
        return new PermissionDTO([
            'name'          => $this ->name,
            'slug'          => $this ->slug,
            'description'   => $this ->description,
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->permissionService ->create($this ->toDTO());
    }
}