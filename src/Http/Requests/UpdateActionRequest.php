<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Mawuekom\Accontrol\Persistables\ActionManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class UpdateActionRequest extends FormRequestCustomizer
{
    use ActionManager;

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
        $actionTable           = config('accontrol.action.table.name');
        $actionTablePrimaryKey = config('accontrol.action.table.primary_key');

        $resource = config('accontrol.action.resource_name');
        $action = $this ->validateAndGetResourceById($this ->route('id'), $resource);

        return [
            'name'                          => 'required|string|max:255',
            'slug'                          => [
                'required', 'string', 'max:255',
                'unique:'.$actionTable.',slug,'.$action ->{$actionTablePrimaryKey}
            ],
            'description'                   => 'string|nullable',
            'available_for_all_entities'    => '',
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
     * Fulfill the action type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->updateAction($this ->route('id'), $this ->validated());
    }
}