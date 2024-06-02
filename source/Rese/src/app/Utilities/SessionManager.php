<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Session;

class SessionManager
{
    /**
     * セッションデータの管理を行う（登録、参照、削除）
     *
     * @param string $action アクションタイプ ('get', 'put', 'forget')
     * @param string $key セッションキー
     * @param mixed $value 登録する値（'put'アクションのみ必要）
     * @return mixed
     */
    public static function handleSession($action, $key, $value = null)
    {
        switch ($action) {
            case 'get':
                // セッションから値を取得
                return Session::get($key);

            case 'put':
                // セッションに値を登録
                Session::put($key, $value);
                return null; // 'put'の場合は特に返す値はない

            case 'forget':
                // セッションから値を削除
                Session::forget($key);
                return null; // 'forget'の場合も特に返す値はない

            default:
                // 未知のアクションタイプの場合
                throw new \InvalidArgumentException("Unknown action type: {$action}");
        }
    }
}
