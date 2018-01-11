<?php



namespace Genv\Otc\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Genv\Otc\Http\Controllers\Controller;
use Genv\Otc\Repository\UserWalletCashType;
use Genv\Otc\Repository\WalletCashMinAmount;

class WalletCashSettingController extends Controller
{
    /**
     * 获取提现设置.
     *
     * @return mixed
     */
    public function show(UserWalletCashType $typeRepository, WalletCashMinAmount $minAmountRepository)
    {
        return response()->json([
            'types' => $typeRepository->get(),
            'min_amount' => $minAmountRepository->get(),
        ])->setStatusCode(200);
    }

    /**
     * 更新提现设置.
     *
     * @param Request $request
     * @return mexed
     */
    public function update(Request $request, UserWalletCashType $typeRepository, WalletCashMinAmount $minAmountRepository)
    {
        $rules = [
            'types' => 'array|in:alipay,wechat',
            'min_amount' => 'required|numeric|min:1',
        ];
        $messages = [
            'types.array' => '提交的数据有误，请刷新重试',
            'types.in_array' => '提交的数据不合法，请刷新重试',
            'min_amount.required' => '请输入最低提现金额',
            'min_amount.numeric' => '最低金额必须为数字',
            'min_amount.min' => '最低提现金额出错',
        ];

        $this->validate($request, $rules, $messages);
        $typeRepository->store(
            $request->input('types', [])
        );
        $minAmountRepository->store(
            intval($request->input('min_amount', 1))
        );

        return response()
            ->json(['messages' => ['更新成功']])
            ->setStatusCode(201);
    }
}
