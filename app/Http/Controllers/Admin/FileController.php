<?php



namespace Genv\Otc\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Genv\Otc\Support\Configuration;
use Illuminate\Contracts\Config\Repository;
use Genv\Otc\Http\Controllers\Controller;

class FileController extends Controller
{
    /**
     * 获取附件基本配置.
     *
     * @param Repository $config
     * @return mixed
     * @author BS <414606094@qq.com>
     */
    public function getConfig(Repository $config)
    {
        $max = $config->get('files.upload_max_size', 10240);

        return response()->json([
            'max_size' => $max,
        ])
        ->setStatusCode(200);
    }

    /**
     * 保存附件基本配置.
     *
     * @param Request $request
     * @param Configuration $config
     * @author BS <414606094@qq.com>
     */
    public function setConfig(Request $request, Configuration $config)
    {
        $config->set('files.upload_max_size', $request->input('max_size'));

        return response()->json(['message' => ['保存成功']], 201);
    }
}