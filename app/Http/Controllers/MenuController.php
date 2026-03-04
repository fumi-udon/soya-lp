<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $host = $request->getHost();
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            $host = 'soya.bistronippon.tn';
        }

        $tenant = \App\Models\Tenant::where('domain', $host)->firstOrFail();
        $categories = \App\Models\Category::with(['products' => function ($q) {
            $q->where('is_active', true)->with('productVariants');
        }])->where('tenant_id', $tenant->id)
            ->where('is_active', true)
            ->get();

        // ★ ここを追加: 店舗固有のギミックをフラグ化してBladeに渡す
        $features = [
            'has_mascot' => $tenant->name === 'Söya',      // Söyaなら醤油ちゃんを表示
            'has_rain_effect' => $tenant->name === 'Söya', // Söyaなら背景の雨エフェクトをON
        ];
        $homeUrl = match ($tenant->domain) {
            'menu.bistronippon.tn' => 'https://bistronippon.tn',
            'menu.currykitano.tn' => 'https://currykitano.tn',
            default => url('/'), // soyaの場合は自身のルート(/)
        };

        return view('menu', compact('categories', 'tenant', 'features', 'homeUrl'));
    }
}
