<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\Accontrol\DataTransferObjects\ActionDTO;
use Mawuekom\Accontrol\Services\ActionService;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class StoreActionRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Accontrol\Services\ActionService
     */
    protected $actionService;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Accontrol\Services\ActionService $actionService
     */
    public function __construct(ActionService $actionService)
    {
        parent::__construct();
        $this ->actionService = $actionService;
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
        $actionsTable = config('accontrol.action.table.name');

        return [
            'name'                          => 'required|string|max:255',
            'slug'                          => [
                'required', 'string', 'max:255',
                Rule::unique($actionsTable, 'slug')
            ],
            'description'                   => 'string|nullable',
            'available_for_all_entities'    => 'integer|nullable',
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
     * @return \Mawuekom\Accontrol\DataTransferObjects\ActionDTO
     */
    public function toDTO(): ActionDTO
    {
        return new ActionDTO([
            'name'                          => $this ->name,
            'slug'                          => $this ->slug,
            'description'                   => $this ->description,
            'available_for_all_entities'    => $this ->available_for_all_entities,
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->actionService ->create($this ->toDTO());
    }
}