<?php



namespace Genv\Otc\Http\Requests\API2;

use Illuminate\Validation\Rule;
use Genv\Otc\Packages\Wallet\Wallet;
use Illuminate\Foundation\Http\FormRequest;
use Genv\Otc\Repository\UserWalletCashType;
use Genv\Otc\Repository\WalletCashMinAmount as CashMinAmountRepository;

class StoreUserWallerCashPost extends FormRequest
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
    public function rules(UserWalletCashType $typeRepository, CashMinAmountRepository $minAmountRepository)
    {
        $wallet = new Wallet($this->user());

        return [
            'value' => [
                'required',
                'numeric',
                'min:'.$minAmountRepository->get(),
                'max:'.$wallet->getWalletModel()->balance,
            ],
            'type' => [
                'required',
                Rule::in($typeRepository->get()),
            ],
            'account' => ['required'],
        ];
    }

    /**
     * Get rule messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'value.required' => '请输入提现金额',
            'value.numeric' => '发送的数据错误',
            'value.min' => '输入的提现金额不足最低提现金额要求',
            'value.max' => '提现金额超出账户余额',
            'type.required' => '请选择提现方式',
            'type.in' => '你选择的提现方式不支持',
            'account.required' => '请输入你的提现账户',
        ];
    }
}
