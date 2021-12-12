<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\Accontrol\DataTransferObjects\EntityDTO;
use Mawuekom\Accontrol\Services\EntityService;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class StoreEntityRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Accontrol\Services\EntityService
     */
    protected $entityService;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Accontrol\Services\EntityService $entityService
     */
    public function __construct(EntityService $entityService)
    {
        parent::__construct();
        $this ->entityService = $entityService;
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
        $entitysTable = config('accontrol.entity.table.name');

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'nullable', 'string', 'max:255',
                Rule::unique($entitysTable, 'slug')
            ],
            'description'   => 'string|nullable',
            'model'         => 'string|nullable',
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
     * @return \Mawuekom\Accontrol\DataTransferObjects\EntityDTO
     */
    public function toDTO(): EntityDTO
    {
        return new EntityDTO([
            'name'          => $this ->name,
            'slug'          => $this ->slug,
            'description'   => $this ->description,
            'model'         => $this ->model,
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->entityService ->create($this ->toDTO());
    }
}