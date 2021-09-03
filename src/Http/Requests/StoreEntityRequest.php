<?php

namespace Accontrol\Http\Requests;

use Accontrol\Persistables\EntityManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class StoreEntityRequest extends FormRequestCustomizer
{
    use EntityManager;

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
        $entities_table = config('accontrol.entity.table.name');

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                'unique:'.$entities_table.',slug'
            ],
            'model'         => 'string|nullable',
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
     * Fulfill the Entity type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->createEntity($this ->validated());
    }
}