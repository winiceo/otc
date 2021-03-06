<?php



namespace Genv\Otc\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSensitive extends FormRequest
{
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
            'word' => 'required|string',
            'type' => 'required|string|in:replace,warning',
            'replace' => 'required_if:type,replace|nullable|string',
        ];
    }
}
