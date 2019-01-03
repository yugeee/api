<?php
/**
 * 共通関数用のクラス
 * 
 * 下記、メソッド一覧
 * getToken：ログイン時にユーザーに渡すトークンを発行するメソッド
 *
 * @author 弓削直樹<n_yuge@sakurasaku-corp.jp>
 * @copyright 株式会社SSC All Rights Reserved
 * @category Util
 * @package util
 */
class Util_Common 
{

     /**
     * トークン発行のメソッド
     * ユニークである必要があるため、発行時にDB内を一度検索する
     * 重複していたらループする
     * 
     * @access public
     * @return String　token ユニークなトークン
     */
    public static function getToken()
    {
        while(true)
        {
            $token = Security::generate_token();
            $user = Model_User::findByToken($token);
            if(empty($user))
            {
                //作成したトークンが重複していなければトークンを返却する。
                return $token;
            }
        }
    }
}