<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // 1. アクセスされたドメインを取得
        $host = $request->getHost();

        // ※ローカル環境（テスト用）の場合は強制的にSöyaのドメインとして扱う
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            $host = 'soya.bistronippon.tn';
        }

        // 2. ドメインから対象の店舗（Tenant）を特定
        $tenant = Tenant::where('domain', $host)->firstOrFail();

        // 3. その店舗（tenant_id）に紐づくカテゴリと商品だけを取得する
        $categories = Category::where('tenant_id', $tenant->id)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)
                    ->with('productVariants')
                    ->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // テナント情報（テーマカラーや店舗名など）も一緒に画面に渡す
        return view('menu', compact('categories', 'tenant'));
    }
}
