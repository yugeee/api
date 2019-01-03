<?php

/**
 * [API]ユーザーAPIコントローラークラス
 *
 * @access public
 * @author 弓削直樹<n_yuge@sakurasaku-corp.jp>
 * @copyright 株式会社SSC All Rights Reserved
 * @category User
 * @package controller
 */
namespace v1;
Class Controller_Users extends \Controller_Rest
{
	/**
 	*  [POST]ユーザー検索のメソッド
 	*  IDとパスワードで検索する。
 	*  JSON形式でユーザー情報を返却する
 	*  ユーザー情報は下記のとおり
 	*  番号, id, 名前, メールアドレス, パスワード, トークン, 有効期限（24時間）
 	*   
 	*
 	* @access public
 	* @return Array(JSON) user　ユーザー情報, Array(JSON) error エラー
 	*/
	public function post_user()
	{
		$login_user = \Model_User::forge();
		$val = $login_user->validate('login');
		
		if(!$val->run())
        {
			//バリデーションエラー
			$error = array('varidation_error' => $val->error_message());
			return $this->response($error, 400);
		}
			
		//バリデーションが通ったらユーザー検索
		$id = $val->validated('id');
		$pass = md5($val->validated('pass'));
		$user = \Model_User::find('all', array(
									'where' => array(
										array('id',$id),
										array('pass',$pass))));
		if(empty($user))
		{
			//検索結果が空の場合
			$error = array('not_found' => 'ユーザーが見つかりませんでした。');
			return $this->response($error, 404);
		}
			
		$token = \Util_common::getToken();

		//allで検索するとidがキーになる配列が渡される。
		//なのでidで取り出して、レコードだけの配列を作成する。
		$user = $user[$id];

		$user->token = $token;
		$user->save();

		//作成した配列の要素にトークンと有効期限（24時間の秒換算）を追加
		$user = $user->to_array();
		$user += array(
					'expire' => 86400
					);
					
		//ログインフォームからのログイン時にはログを残す
		$fields = array(
					'user_id' => $val->validated('id'),
					);
		$logged_in = \Model_Log::forge($fields);
		$logged_in->save();
		
		return $this->response($user, 200);
	}

		/**
 	*  [GET]ユーザー検索のメソッド
 	*  トークンで検索する。
 	*  JSON形式でユーザー情報を返却する
 	*  ユーザー情報は下記のとおり
 	*  番号, id, 名前, メールアドレス, パスワード, トークン, 有効期限（24時間）
 	*   
 	*
 	* @access public
 	* @return Array(JSON) user　ユーザー情報, Array(JSON) error エラー
 	*/
	public function get_user()
	{
		$token = \Input::get('token');
		
		if(empty($token))
		{
			//tokenがなかった場合
			$error = array('no_token' => 'トークンがありません。');
			return $this->response($error, 400);
		}
			
		$user = \Model_User::findByToken($token);
		
		if(empty($user))
		{
			//検索結果が空の場合
			$error = array('not_found' => 'ユーザーが見つかりませんでした。');
			return $this->response($error, 404);
		}
			
		//logsのデータは不要なため削除する
		unset($user['logs']);

		//配列にする
		$user = $user->to_array();

		//上で作成した配列の要素にトークンと有効期限（24時間の秒換算）を追加
		$user += array(
			'token' => $token,
			'expire' => 86400
		);

		return $this->response($user, 200);
	}
}