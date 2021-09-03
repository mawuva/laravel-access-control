<?php

namespace Accontrol\Http\Requests;

use Accontrol\Persistables\ActionManager;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class SearchActionRequest extends FormRequestCustomizer
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
     * Fulfill the Action request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return $this ->searchActions($this ->searchTerm);
    }
}