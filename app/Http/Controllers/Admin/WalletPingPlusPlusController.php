<?php



namespace Genv\Otc\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Genv\Otc\Http\Controllers\Controller;
use Genv\Otc\Repository\WalletPingPlusPlus;
use Illuminate\Contracts\Routing\ResponseFactory as ContractResponse;

class WalletPingPlusPlusController extends Controller
{
    /**
     * Get the Ping++ config.
     *
     * @param \Genv\Otc\Repository\WalletPingPlusPlus $repository
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @return mixed
     */
    public function show(WalletPingPlusPlus $repository, ContractResponse $response)
    {
        return $response
            ->json($repository->get())
            ->setStatusCode(200);
    }

    /**
     * Update Ping++ config.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Genv\Otc\Repository\WalletPingPlusPlus $repository
     * @param \Illuminate\Contracts\Routing\ResponseFactory $response
     * @return mixed
     */
    public function update(Request $request, WalletPingPlusPlus $repository, ContractResponse $response)
    {
        $this->validate($request, $this->rules(), $this->validateErrorMessages());

        $repository->store(
            $request->only(['app_id', 'secret_key', 'public_key', 'private_key'])
        );

        return $response
            ->json(['message' => ['更新成功!']])
            ->setStatusCode(201);
    }

    /**
     * Get valodate rule.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'app_id' => 'required',
            'secret_key' => 'required',
            'public_key' => 'required',
            'private_key' => 'required',
        ];
    }

    /**
     * Get validate error messages.
     *
     * @return array
     */
    protected function validateErrorMessages(): array
    {
        return [
            'app_id.required' => '请输入应用 ID',
            'secret_key.required' => '请输入 Secret Key',
            'public_key.required' => '请输入 Ping++ 公钥',
            'private_key.required' => '请输入商户私钥',
        ];
    }
}
