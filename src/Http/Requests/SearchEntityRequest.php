<?php

namespace Mawuekom\Accontrol\Http\Requests;

use Mawuekom\Accontrol\Persistables\EntityManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class SearchEntityRequest extends FormRequestCustomizer
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
     * Fulfill the Entity request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->searchEntities($this ->searchTerm);
    }
}