<?php

namespace App\Http\Middleware;

use Closure;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
            $this->die();
        }
        //Basic認証の場合、$_SERVER['PHP_AUTH_USER'] と $_SERVER['PHP_AUTH_PW'] に認証用のユーザー名とパスワードが送信されてきます。
        if ($_SERVER['PHP_AUTH_USER'] !== env('BASIC_USER') || $_SERVER['PHP_AUTH_PW'] !== env('BASIC_PASS')) {
            $this->die();
        }
        //.envのユーザー名とパスワードと一致しない場合はdieメソッドを呼び出す
        
        return $next($request);
    }
    protected function die()
    {
        //認証が失敗した場合、アプリケーション側はステータスコード401と、WWW-Authenticateヘッダを出力する必要があり
        //dieメソッド内ではPHP標準関数であるheader関数を使って、WWW-Authenticateヘッダを追加。
        //headerは任意のHTTPヘッダを出力する関数
        header('WWW-Authenticate: Basic realm="Enter username and password."');
        //Laravelの関数であるabort関数を使って、ステータスコード401の画面を表示しています。
        //abortは例外処理関数になります。例えばページが見つからないエラーの場合
        //スタータスコードは404になりますので、 abort(404); のように書いたりする
        abort(401);
    }
}
