<?php

namespace Genv\Otc\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Genv\Otc\Models\CoinType;
use Genv\Otc\Http\Controllers\Controller;

class CoinTypeController extends Controller
{
    public function types(Request $request)
    {
        $status = $request->get('status', null);

        $items = CoinType::when(!is_null($status), function ($query) use ($status) {
            $query->where('status', $status);
        })
        ->orderBy('status', 'desc')
        ->get();

        return response()->json($items, 200);
    }

    public function storeType(Request $request)
    {
        $rule = ['name' => 'required', 'label' => 'required'];
        $msg = ['name.required' => '名称必须填写', 'label.required' => '中文名必须填写'];

        $this->validate($request, $rule, $msg);

        $status = (int) $request->input('status');

        if ($status) {
            CoinType::where('id', '>', 0)->update(['status' => 0]);
        }

        if (CoinType::create($request->all())) {
            return response()->json(['message' => ['添加类别成功']], 201);
        } else {
            return response()->json(['message' => ['添加类别失败']], 500);
        }
    }

    public function openType(CoinType $type)
    {


            $type->status = !$type->status;
            $type->save();

            return response()->json(['message' => [sprintf('启动"%s"分类成功', $type->name)]], 201);

    }

    public function deleteType(CoinType $type)
    {
        if ($type->status !== 1) {
            $type->delete();

            return response()->json('', 204);
        }
    }
}
