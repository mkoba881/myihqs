<?php

namespace App\Http\Controllers;
use App\Models\Format;
use App\Models\Item;
use App\Models\Detail;
use App\Models\Answer;

use Illuminate\Http\Request;
    
class AnalysisController extends Controller
{
    public function getData(Request $request)
    {
        // データの取得処理（例：データベースクエリやAPIリクエストなど）
        // 取得したデータをJSON形式でレスポンスとして返す
    
    $formatId = $request->input('format_id');
    //dd($formatId);
    $itemIds = Item::where('format_id', $formatId)->pluck('id');
    $itemName = Item::where('format_id', $formatId)->pluck('name');
    $detailIds = Detail::whereIn('item_id', $itemIds)->pluck('id');
    $count = Answer::whereIn('format_id', [$formatId])
              ->whereIn('item_id', $itemIds)
              ->whereIn('detail_id', $detailIds)
              ->count();
    //dd($count);
    //dd($itemName);

    //$formats =  $request->all();//フォームの中身を全部とってきている
    

    return response()->json([
        'labels' => [$itemName],
        //  'labels' => ['Apples', 'Oranges', 'Bananas'],
        'values' => [$count],
        //  'values' => [10, 15, 5],
    ]);

    }
}
