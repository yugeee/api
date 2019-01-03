<?php
/**
 * ユーザーのモデルクラス
 * 1ユーザーに対して多数のログが紐づく
 *
 * @access public
 * @author 弓削直樹<n_yuge@sakurasaku-corp.jp>
 * @copyright 株式会社SSC All Rights Reserved
 * @category User
 * @package model 
 */
class Model_User extends Orm\Model {
	protected static $_table_name = 'users';
	protected static $_primary_key = array('id');
	protected static $_properties = array(
		'number',
		'id',
		'name',
		'pass',
		'mail',
		'token',
		);

	protected static $_has_many = array(
		'logs' => array(
			'key_from' => 'id',
			'model_to' => 'Model_Log',
			'key_to' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,)
		);

	/**
	*　トークンをキーにユーザーを検索するメソッド
	* 
 	* @access public
 	* @param String token ログイントークン
 	* @return User login_user 検索結果
 	*/	
    public static function findByToken($token)
    {
    	$login_user = self::find('last', array(
    								'where' => array(
        								array('token', $token))));
    	return $login_user;
    }

	/**
 	* 入力チェックのメソッド
 	* loginはIDとPASSのみ
 	* fullはすべてのフィールドを
 	* deleteはpasswordのみをチェックする
 	* @access public
 	* @param String factory validationのパターン分岐
 	* @return Validation val バリデーションのルールに入力した情報をセットしたもの
 	*/
	public static function validate($factory)
	{
		$val = \Validation::forge();
		switch($factory)
		{
			case 'login':
			$val->add('id', 'ID')
				->add_rule('required')
				->add_rule('min_length', 4)
				->add_rule('max_length', 10)	
				->add_rule('valid_string',array('alpha','numeric','utf8'),'半角英数字');	
			$val->add('pass', 'パスワード')	
				->add_rule('required')
				->add_rule('min_length', 6)	
				->add_rule('max_length', 10)	
				->add_rule('valid_string', array('alpha','numeric','utf8'),'半角英数字');	
			return $val;	

			case 'create':
			$val->add('id', 'ID')
				->add_rule('required')
				->add_rule('min_length', 4)
				->add_rule('max_length', 10)	
				->add_rule('valid_string',array('alpha','numeric','utf8'),'半角英数字');
			$val->add('name', 'name')
				->add_rule('required')
				->add_rule('min_length', 2)
				->add_rule('max_length', 20);
			$val->add('pass', 'pass')
				->add_rule('required')	
				->add_rule('min_length', 6)	
				->add_rule('max_length', 10)	
				->add_rule('valid_string', array('alpha','numeric','utf8'));
			$val->add('mail', 'mail')	
				->add_rule('required');
			return $val;
			
			case 'update':
			$val->add('name', 'name')
				->add_rule('required')
				->add_rule('min_length', 2)
				->add_rule('max_length', 20);
			$val->add('pass', 'pass')
				->add_rule('required')	
				->add_rule('min_length', 6)	
				->add_rule('max_length', 10)	
				->add_rule('valid_string', array('alpha','numeric','utf8'));
			$val->add('mail', 'mail')	
				->add_rule('required');
			return $val;

			case 'delete':
			$val->add('pass', 'pass')
				->add_rule('required')	
				->add_rule('min_length', 6)	
				->add_rule('max_length', 10)	
				->add_rule('valid_string', array('alpha','numeric','utf8'));
			return $val;
		}
	}
}