<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Format;
use App\Models\Answer;
use App\Models\Item;
use App\Models\Detail;
use Carbon\Carbon;

//use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SurveyController extends Controller
{
    // public function show(Request $hash)
    // {
    //      // ログインユーザーのIDを取得
    //     $userId = Auth::id();
    //         //dd($hash);
    //     $path = $hash->getPathInfo();//$hashの中からパス情報を抜き出す。
    //     $path = str_replace('/fs/answer/', '', $path);
        
    //     $id = Crypt::decryptString(urldecode($path));//URLでコードしてから復号化処理を実施する。
    //     $format = Format::where('id', $id)->get();
    //     $items = Item::where('format_id', $id)->get();
        
    //     $details = collect(); // $detailsを空のコレクションとして初期化
    //     $answers = collect();
        
    //     foreach ($items as $item) {
    //         $detail = Detail::where('item_id', $item->id)->get();
    //         $details = $details->merge($detail);
        
    //         // ログインユーザーのIDと対応するAnswerレコードを取得
    //         $answer = Answer::where('format_id', $id)
    //             ->where('item_id', $item->id)
    //             ->where('user_id', $userId)
    //             ->first();
    
    //         if ($answer) {
    //             $answers->push($answer);
    //         }
            
    //     }
    //     //dd($answers);
    //     //dd($details);
        
    //     return view('fs.answer', compact('format','items','details', 'userId', 'answers'));
    // }
    
    
    public function show(Request $hash)
    {
        // ログインユーザーのIDを取得
        $userId = Auth::id();
        
        $path = $hash->getPathInfo(); // $hashの中からパス情報を抜き出す。
        $path = str_replace('/fs/answer/', '', $path);
        
        $id = Crypt::decryptString(urldecode($path)); // URLでコードしてから復号化処理を実施する。
        
        // アンケートが存在するか確認
        $format = Format::find($id); // IDを使用してFormatテーブルを取得
        
        if (!$format) {
            // アンケートが存在しない場合、404エラーを返す
            return view('error.survey_not_found');
        }
    
        $startDate = Carbon::parse($format->start);
        $endDate = Carbon::parse($format->end);
        $currentDate = now();
        
        if ($currentDate->lt($startDate) || $currentDate->gt($endDate)) {
            // アンケートが現在の日付の範囲外にある場合、別のViewにリダイレクト
            return view('error.out_of_date');
        }
        
        $items = Item::where('format_id', $id)->get();
        
        if ($items->isEmpty()) {
            // アンケートに関連するアイテムが存在しない場合、別のViewにリダイレクト
            return view('error.deleted_survey');
        }
        
        $details = collect(); // $detailsを空のコレクションとして初期化
        $answers = collect();
        
        foreach ($items as $item) {
            $detail = Detail::where('item_id', $item->id)->get();
            $details = $details->merge($detail);
        
            // ログインユーザーのIDと対応するAnswerレコードを取得
            $answer = Answer::where('format_id', $id)
                ->where('item_id', $item->id)
                ->where('user_id', $userId)
                ->first();
                
            if ($answer) {
                $answers->push($answer);
            }
        }
        
        //dd($answers);
        //dd($details);
        
        return view('fs.answer', compact('format', 'items', 'details', 'userId', 'answers'));
    }

    
    public function getSurveyDetails($formatId)
    {
        $userId = Auth::user()->id;
        //dd($userId);
        // format_idに基づいてItemテーブルとDetailテーブルからデータを取得する例
        $items = Item::where('format_id', $formatId)->get();
        
        // $itemsに対応するDetailデータを取得する
        $detailsByItem = [];
        $answers = [];
        
        foreach ($items as $item) {
            $details = Detail::where('item_id', $item->id)->get();
            $detailsByItem[$item->id] = $details;
        
            // ログインユーザーのIDと対応するAnswerレコードを取得
            $answer = Answer::where('format_id', $formatId)
                ->where('item_id', $item->id)
                ->where('user_id', $userId)
                ->first();
                
            if ($answer) {
            $answers[] = $answer; // []演算子を使用して要素を追加
            }
    
        
        }
        
        return response()->json([
            'answers' => $answers,
            'userId' => $userId,
            'items' => $items,
            'detailsByItem' => $detailsByItem,
        ]);
}

}
