<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        // 公開中のカテゴリと商品を、トッピング情報（productVariants）と一緒に取得
        $categories = Category::with(['products' => function ($query) {
            $query->where('is_active', true)
                ->with('productVariants')
                ->orderBy('sort_order');
        }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('menu', compact('categories'));
    }
}
