<?php

namespace Accontrol\Http\Requests;

use Accontrol\Persistables\EntityManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\Capitalize;

class UpdateEntityRequest extends FormRequestCustomizer
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
        $entityTable           = config('accontrol.entity.table.name');
        $entityTablePrimaryKey = config('accontrol.entity.table.primary_key');

        $resource = config('accontrol.entity.resource_name');
        $entity = $this ->validateAndGetResourceById($this ->route('id'), $resource);

        return [
            'name'          => 'required|string|max:255',
            'slug'          => [
                'required', 'string', 'max:255',
                'unique:'.$entityTable.',slug,'.$entity ->{$entityTablePrimaryKey}
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
     * Fulfill the entity type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->updateEntity($this ->route('id'), $this ->validated());
    }
}