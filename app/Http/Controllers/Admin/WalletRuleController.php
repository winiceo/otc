<?php



namespace Genv\Otc\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Genv\Otc\Models\CommonConfig;
use Genv\Otc\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;

class WalletRuleController extends Controller
{
    /**
     * Get the recharge and withdraw the rules.
     *
     * @param ResponseFactory $response
     * @return mixed
     */
    public function show(ResponseFactory $response)
    {
        $rule = CommonConfig::byNamespace('wallet')
            ->byName('rule')
            ->value('value');

        return $response
            ->json(['rule' => $rule])
            ->setStatusCode(200);
    }

    /**
     * 更新规则.
     *
     * @param Request $request
     * @param ResponseFactory $response
     * @return mixed
     */
    public function update(Request $request, ResponseFactory $response)
    {
        $rule = $request->input('rule', '');

        CommonConfig::updateOrCreate(
            ['name' => 'rule', 'namespace' => 'wallet'],
            ['value' => $rule]
        );

        return $response
            ->json(['message' => ['更新成功']])
            ->setStatusCode(201);
    }
}
