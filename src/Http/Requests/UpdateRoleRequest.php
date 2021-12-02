<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\Accontrol\DataTransferObjects\RoleDTO;
use Mawuekom\Accontrol\Services\RoleService;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class UpdateRoleRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Accontrol\Services\RoleService
     */
    protected $roleService;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Usercare\Services\roleService $useroleServicerService
     */
    public function __construct(RoleService $roleService)
    {
        parent::__construct();
        $this ->roleService = $roleService;
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
        $rolesTable = config('accontrol.role.table.name');
        $roleIDRouteParam = $this ->route(config('accontrol.role.id_route_param'));
        $key = resolve_key(config('accontrol.role.model'), $roleIDRouteParam);

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'nullable', 'string', 'max:255',
                Rule::unique($rolesTable, 'slug') ->ignore($roleIDRouteParam, $key)
            ],
            'description'   => 'string|nullable',
            'level'         => 'integer|nullable',
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
     * @return \Mawuekom\Accontrol\DataTransferObjects\RoleDTO
     */
    public function toDTO(): RoleDTO
    {
        return new RoleDTO([
            'name'          => $this ->name,
            'slug'          => $this ->slug,
            'description'   => $this ->description,
            'level'         => $this ->level,
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        $roleIDRouteParam = $this ->route(config('accontrol.role.id_route_param'));

        return $this ->roleService ->update($roleIDRouteParam, $this ->toDTO());
    }
}