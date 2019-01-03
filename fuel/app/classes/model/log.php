<?php
/**
 * ログのモデルクラス
 *　ログイン・ログアウトされたときにインサートされる
 *　
 * @access public
 * @author 弓削直樹<n_yuge@sakurasaku-corp.jp>
 * @copyright 株式会社SSC All Rights Reserved
 * @category Log
 * @package model 
 */
class Model_Log extends \Orm\Model{
	protected static $_table_name = 'logs';
	protected static $_primary_key = array('number');
	protected static $_properties = array(
		'number',
		'user_id',
		'logged_in',
		);
	protected static $_belongs_to = array(
		'users' => array(
			'key_from' => 'user_id',
			'model_to' => 'Model_User',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => true,)
		);
	protected static $_observers = array(
    	'Orm\\Observer_CreatedAt' => array(
        	'events' => array('before_insert'),
        	'mysql_timestamp' => true,
        	'property' => 'logged_in',),);
}