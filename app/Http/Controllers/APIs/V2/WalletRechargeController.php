<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Illuminate\Http\Request;
use Genv\Otc\Http\Requests\API2\StoreWalletRecharge;
use Genv\Otc\Models\WalletCharge as WalletChargeModel;
use Genv\Otc\Services\Wallet\Charge as WalletChargeService;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;

class WalletRechargeController extends Controller
{
    /**
     * Container.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Wallet charge service.
     *
     * @var \Genv\Otc\Services\Wallet\Charge
     */
    protected $chargeService;

    /**
     * Create controller instance.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(ApplicationContract $app, WalletChargeService $chargeService)
    {
        $this->app = $app;
        $this->chargeService = $chargeService;
    }

    /**
     * Create a recharge charge.
     *
     * @param \Genv\Otc\Http\Requests\API2\StoreWalletRecharge $request
     * @return mixed
     */
    public function store(StoreWalletRecharge $request)
    {
        // 设置共享实例，一面多个地方重复调用验证
        $this->app->singleton(StoreWalletRecharge::class, function () use ($request) {
            return $request;
        });

        $type = $request->input('type');
        $controllers = [
            WalletRechargeApplePayController::class => ['applepay_upacp'],
            WalletRechargeAlipayController::class => ['alipay', 'alipay_wap', 'alipay_pc_direct', 'alipay_qr'],
            WalletRechargeWeChatController::class => ['wx', 'wx_wap'],
        ];

        foreach ($controllers as $controller => $keys) {
            if (! in_array($type, $keys)) {
                continue;
            }

            return $this->app->call([$this->app->make($controller), 'create']);
        }

        $this->app->abort(406, '请求动作不存在或者非法');
    }

    /**
     * Resolve store method.
     *
     * @param string $type
     * @return mixed
     */
    protected function resolveStore(string $type)
    {
        return $this->app->call([$this, camel_case($type.'_store')]);
    }

    /**
     * Create a recharge charge.
     *
     * @param \Genv\Otc\Models\WalletCharge $charge
     * @param array $extra
     * @return array
     */
    protected function createCharge(WalletChargeModel $charge, array $extra = [])
    {
        return $this->chargeService->create($charge, $extra);
    }

    /**
     * Create a charge model.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $channel
     * @return \Genv\Otc\Models\WalletCharge
     */
    protected function createChargeModel(Request $request, string $channel): WalletChargeModel
    {
        $charge = new WalletChargeModel();
        $charge->user_id = $request->user()->id;
        $charge->channel = $channel;
        $charge->action = 1; // 充值都是为 增项
        $charge->amount = intval($request->input('amount'));
        $charge->subject = '余额充值';
        $charge->body = '账户余额充值';
        $charge->status = 0; // 待操作状态

        return $charge;
    }
}
