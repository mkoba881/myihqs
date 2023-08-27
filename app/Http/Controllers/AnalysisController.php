<?php

namespace App\Http\Controllers;
use App\Models\Format;
use App\Models\Item;
use App\Models\Detail;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
    
namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Item;
use App\Models\Detail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{
    public function getData(Request $request)
    {
        $formatId = $request->input('format_id');
        $itemIds = Item::where('format_id', $formatId)->pluck('id');
        $itemNames = Item::where('format_id', $formatId)->pluck('name');
        //dd($itemNames);
        $detailIds = Detail::whereIn('item_id', $itemIds)->pluck('id');
        $countByPriority = Answer::whereIn('format_id', [$formatId])
            ->whereIn('item_id', $itemIds)
            ->whereIn('detail_id', $detailIds)
            ->select('item_id', 'priority', DB::raw('count(*) as count'))
            ->groupBy('item_id', 'priority')
            ->orderBy('item_id')
            ->orderBy('priority')
            ->get();
        
        //dd($countByPriority);
        $formattedData = [];
        
        foreach ($countByPriority as $item) {
            $itemId = $item->item_id;
            //dd($itemId);
            $priority = $item->priority;
            //dd($priority);
            $count = $item->count;
        
        
            $formattedData[$itemId]['data'][$priority] = $count;
            //dd($formattedData );
        }
        
        // $itemNames を使って label を設定
        $counter = 0;
        foreach ($formattedData as $itemId => $data) {
            $formattedData[$itemId]['label'] = isset($itemNames[$counter]) ? $itemNames[$counter] : '';
            $counter++;
        }
        
        //dd($formattedData);

        return response()->json(array_values($formattedData));
    }
}
