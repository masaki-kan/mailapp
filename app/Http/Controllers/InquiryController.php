<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\InquiryRequest;
use App\Mail\inquiryMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Content;

class InquiryController extends Controller
{
    //
    public function index(){
      return view('mailform');
    }
    
    public function postInquiry(InquiryRequest $request){

        $validated = $request->validated();
        //InquiryRequestのバリデーション後のデータをvalidated()で取得
        $request->session()->put('inquiry', $validated);
        //リクエストされた値をセッションへ保存する(put)
        //inquiry(キー) => $validated（値）
        return redirect(route('confirm'));
        //ルート　name('confirm')にリダイレクトする
      
    }
    
    public function showConfirm(Request $request){
      
      $sessionData = $request->session()->get('inquiry');
      //sessionでinquiryとして保存されているデータを取得
      
       if (is_null($sessionData)) {
            return redirect(route('index'));
        }
      //直接アクセスがある場合、セッションにデータが未保存の状態です。データが未保存の場合、 route('index')にリダイレクト
      //$sessionData = $request->session()->get('inquiry'); はnullを返却
      $message = view('emails.inquiry', $sessionData);
     //inquiry.bladeを変数に代入したのをcofirm.bladeにレンダリングする
    
      return view('confirm', ['message' => $message]);
    }
    
    public function postConfirm( Request $request ){
      $sessionData = $request->session()->get('inquiry');
      //sessionでinquiryとして保存されているデータを取得
      
      if( is_null($sessionData)){
        return redirect( route('index'));
      }
      //直接アクセスがある場合、セッションにデータが未保存の状態です。データが未保存の場合、 
      //$sessionData = $request->session()->get('inquiry'); はnullを返却
      $request->session()->forget('inquiry');
      //セッションデータを取得したあと、forgetメソッドでセッションデータを削除
      
      Content::create($sessionData);
      //送信内容をDB作成
       
      Mail::to($sessionData['email'])->send(new inquiryMail($sessionData));     
      //mailファサード使用、to先はsession内のアドレスを取得して、sendメソッドでsessionデータ引数にしてインスタンスを作成
      
      return redirect(route('sent'))->with('sent_inquiry', true);
      //sessionデータはforgetで削除されていますが、withで一度だけ同じ内容で「sent_inquiry」の名前でフラッシュデータを保村。
      //この処理によって、送信した際のみ「sent_inquiry」の名前のセッションが存在する事になりますので、この値で判定を追加します。
      
    }
    public function showSentMessage(Request $request ){
        $request->session()->keep('sent_inquiry');
        //送信完了画面でリロードを行った際、フラッシュデータである「sent_inquiry」のデータはなくなる
        //完了画面が表示されている場合、リロードした場合はそのまま完了画面を出しておきたいので、
        //この画面のみ「sent_inquiry」のデータを保持するためkeepメソッドを呼び出しています。
        $sessionData = $request->session()->get('sent_inquiry');
        
        if (is_null($sessionData)) {
            return redirect(route('index'));
        }
      //直接アクセスがある場合、セッションにデータが未保存の状態です。データが未保存の場合、 
      //$sessionData = $request->session()->get('inquiry'); はnullを返却
      return view('send');
    }
     
}
