<?php

namespace Accontrol\Http\Requests;

use Accontrol\Persistables\ActionManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class StoreActionRequest extends FormRequestCustomizer
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
        $actions_table = config('accontrol.action.table.name');

        return [
            'name'                          => 'required|string|max:255',
            'slug'                          => [
                'required', 'string', 'max:255',
                'unique:'.$actions_table.',slug'
            ],
            'description'                   => 'string',
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
     * Fulfill the Action type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->createAction($this ->validated());
    }
}