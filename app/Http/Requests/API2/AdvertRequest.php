<?php



namespace Genv\Otc\Http\Requests\API2;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AdvertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'coin_type' => 'required|digits_between:1,10' ,
            'trade_type' => 'required|numeric',
            'price' => 'required|numeric',

        ];
    }

    /**
     * Get the validation message that apply to the request.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => '标签名称必填',
            'name.max' => '标签名称过长',
            'name.unique' => '标签已经存在',
            'category.required' => '标签分类必填',
            'category.exists' => '标签分类不存在',
        ];
    }
}
