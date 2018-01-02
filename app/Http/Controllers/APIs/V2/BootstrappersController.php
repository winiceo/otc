<?php



namespace Genv\Otc\Http\Controllers\APIs\V2;

use Genv\Otc\Models\GoldType;
use Genv\Otc\Models\CommonConfig;
use Genv\Otc\Models\AdvertisingSpace;
use Genv\Otc\Support\BootstrapAPIsEventer;
use Illuminate\Contracts\Routing\ResponseFactory;

class BootstrappersController extends Controller
{
    /**
     * Gets the list of initiator configurations.
     *
     * @param ResponseFactory $response
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function show(BootstrapAPIsEventer $events, ResponseFactory $response, AdvertisingSpace $space, GoldType $goldType)
    {
        $bootstrappers = [];
        foreach (CommonConfig::byNamespace('common')->get() as $bootstrapper) {
            $bootstrappers[$bootstrapper->name] = $this->formatValue($bootstrapper->value);
        }

        $bootstrappers['ad'] = $space->where('space', 'boot')->with(['advertising' => function ($query) {
            $query->orderBy('sort', 'asc');
        }])->first()->advertising ?? [];

        $bootstrappers['site'] = config('site', null);
        $bootstrappers['registerSettings'] = config('registerSettings', null);

        $bootstrappers['wallet:cash'] = ['open' => config('wallet.cash.status', true)];
        $bootstrappers['wallet:recharge'] = ['open' => config('wallet.recharge.status', true)];

        $goldSetting = $goldType->where('status', 1)->select('name', 'unit')->first() ?? collect(['name' => '金币', 'unit' => '个']);
        $bootstrappers['site']['gold_name'] = $goldSetting;

        return $response->json($events->dispatch('v2', [$bootstrappers]), 200);
    }

    /**
     * 格式化数据.
     *
     * @param string $value
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function formatValue(string $value)
    {
        if (($data = json_decode($value, true)) === null) {
            return $value;
        }

        return $data;
    }
}
