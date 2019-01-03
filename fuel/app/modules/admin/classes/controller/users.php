<?php

/**
 * [CMS]ユーザーCRUD＆ログインコントローラクラス
 *
 * 会員情報のCRUDとログインCMSをまとめたコントローラクラス。
 * @access public
 * @author k_takahashi <ssc.kureha@gmail.com>
 * @copyright 株式会社SSC
 * @package Controller
 */
namespace Admin;
class Controller_Users extends \Controller_Template {

    /**
     * ユーザー登録画面のメソッド
     * 
     * @access public
     */
    public function action_index() 
    {
        $this->template->title   = 'ユーザー登録';
        $this->template->content = \View::forge('user/index');
    }

    /**
     * ユーザー登録のバリデーションメソッド
     *  
     * フォームから受け取った値を検証する。
     * OKなら確認画面へ飛ばす。
     * NGならフォームの上にバリデーション結果のメッセージを表示させる。
     *
     * @access public 
     * @todo idがDBで重複していたらエラー画面を表示させたい。(とりあえず後回し)
     */
    public function action_confirm() 
    {
        $user = \Model_User::forge();
        $val  = $user->validate('create');
        //バリデーションＯＫ
        if ($val->run()) 
        {
            $data['input'] = $val->validated();
            $this->template->title   = 'ユーザー登録：確認';
            $this->template->content = \View::forge('user/confirm', $data);
        //バリデーションＮＧ
        }
        else
        {
            $this->template->title   = 'ユーザー登録：エラー';
            $this->template->content = \View::forge('user/index');
            $this->template->content->set_safe('html_error', $val->show_errors());
        }
    }

    /**
     * ユーザー登録のメソッド
     *  
     * 確認画面で送信が押下されたら値がDBに格納される。
     * 登録できた場合メイン画面に飛ばす。
     * 登録できなかった場合はエラーメッセージを表示し、登録画面を再表示。
     *
     * @access public 
     */
    public function action_send()
    {
        $user = \Model_User::forge();
        $val  = $user->validate('create');
        if (!$val->run())
        {
            $this->template->title   = 'ユーザー登録：エラー';
            $this->template->content = \View::forge('user/index');
            $this->template->content->set_safe('html_error', $val->show_errors());
        }
        $post = $val->validated();
        $post['pass'] = md5($post['pass']);
        //データを保存
        $new  = new \Model_User($post);
        $new->save();
        if (isset($post)) {
            $this->template->title   = '登録完了';
            $this->template->content = \View::forge('user/send');
        }
        else
        {
            $this->template->title   = 'ユーザー登録：エラー';
            $this->template->content = \View::forge('user/index');
            $this->template->content->set_safe('html_error', '登録できませんでした。');
        }
    }

    /**
     * ログイン画面のメソッド
     *
     * @access public 
     */
    public function action_login()
    {
        $this->template->title   = 'ログイン画面';
        $this->template->content = \View::forge('user/loginform');
    }

    /**
     * ログインバリデーションのメソッド
     *  
     * フォームから受け取った値を検証する。
     * idとpassのキーで検証を行う。
     * データを取り出せればログイン成功。セッションスタート。
     * NGの場合、エラーメッセージ表示＆ログイン画面を再表示させる。
     * 
     * @access public 
     */
    public function action_loginform()
    {
        $login_user = \Model_User::forge();
        $val = $login_user->validate('login');

        // バリデーションエラー
        if (!$val->run())
        {
            $this->template->title   = 'ログインチェック：エラー';
            $this->template->content = \View::forge('user/loginform');
            $this->template->content->set_safe('html_error', $val->show_errors());
            return;
        }

        // ユーザー検索
        $id   = $val->validated('id');
        $pass = md5($val->validated('pass'));
        $found = \Model_User::find('all', array(
                    'where' => array(
                        array('id', $id),
                        array('pass', $pass)
                        ))
                    );

        // ユーザーが見つからなかった場合
        if (empty($found))
        {
            $this->template->title   = 'ログイン：エラー';
            $this->template->content = \View::forge('user/loginform');
            $this->template->content->set_safe('html_error', 'IDかパスワードが違います。');
            return;
        }

        // ログイン成功
        $user = $found[$id];

        // セッション開始
        \Session::set('session', $user);
        $this->template->title = 'メイン画面';
        $this->template->content = \View::forge('main', ['user' => $user]);
        return;
    }

    /**
     * ユーザー情報更新画面のメソッド
     *  
     * ログインされていなければログイン画面へ飛ばす。
     * ユーザー情報を更新する為のフォームを表示させる。
     *
     * @access public 
     * @return null returnを付けないとif文内のビューに飛ばせないため。 
     */
    public function action_update()
    {
        $user = \Session::get('session');
        
        if (empty($user))
        {
            $this->template->title   = 'ログイン画面';
            $this->template->content = \View::forge('user/loginform');
            $this->template->content->set_safe('html_error', 'ログインしていません。');
            return;
        }

        $this->template->title   = 'ユーザー編集：フォーム';
        $this->template->content = \View::forge('user/updateform');
    }

    /**
     * ユーザー情報更新のバリデーションメソッド
     *  
     * ログインされていなければログイン画面へ飛ばす。
     * フォームから受け取った値を検証する。
     * OKなら確認画面を表示。
     * NGならエラーメッセージを表示＆ユーザー情報更新画面を再表示させる。
     *
     * @access public 
     * @return null returnを付けないとif文内のビューに飛ばせないため。 
     */
    public function action_updateconfirm()
    {
        $user = \Session::get('session');
        
        if (empty($user))
        {
            $this->template->title   = 'ログイン画面';
            $this->template->content = \View::forge('user/loginform');
            $this->template->content->set_safe('html_error', 'ログインしていません。');
            return;
        }

        $user = \Model_User::forge();
        $val  = $user->validate('update');
        
        if (!$val->run())
        {
            $this->template->title = 'ユーザー編集：エラー';
            $this->template->content = \View::forge('user/updateform');
            $this->template->content->set_safe('html_error', $val->show_errors());
            
        }

        $data['input'] = $val->validated();
        $this->template->title   = 'ユーザー編集：確認';
        $this->template->content = \View::forge('user/updateconfirm', $data);
    }

    /**
     * ユーザー情報更新の実行メソッド
     *  
     * ログインされていなければログイン画面へ飛ばす。
     * 確認画面で送信が押下されたらユーザー情報の更新を実行する。
     * 成功したら登録完了画面へ飛ばす。
     * 失敗したらエラーメッセージを表示＆ユーザー情報更新画面を再表示させる。
     *
     * @access public 
     * @return null returnを付けないとif文内のビューに飛ばせないため。 
     */
    public function action_updatesend()
    {
        $user = \Session::get('session');
        
        if (empty($user))
        {
            $this->template->title   = 'ログイン画面';
            $this->template->content = \View::forge('user/loginform');
            $this->template->content->set_safe('html_error', 'ログインしていません。');
            return;
        }
        
        $new_user = \Model_User::forge();
        $val  = $new_user->validate('update');
        
        //バリデーション失敗
        if (!$val->run())
        {
            $this->template->title   = 'ユーザー編集：エラー';
            $this->template->content = \View::forge('user/form');
            $this->template->content->set_safe('html_error', $val->show_errors());
        }
        
        //バリデーション成功
        $id   = $user['id'];
        $post = $val->validated();
        $name = $val->validated('name');
        $mail = $val->validated('mail');
        $pass = md5($val->validated('pass'));
        $found = \Model_User::find('all', array(
            'where' => array(
                array('id', $id),
                array('pass', $pass)
                ))
            );

        if (!isset($found))
        {
            $this->template->title   = 'ユーザー編集：エラー';
            $this->template->content = \View::forge('user/updateform');
            $this->template->content->set_safe('html_error', 'パスワードが違います。');
        }
        
        $user = $found[$id];
        //更新実行
        $user->name = $name;
        $user->mail = $mail;
        $user->save();
        $this->template->title   = 'ユーザー編集：完了';
        $this->template->content = \View::forge('user/send');
        
    }

    /**
     * ユーザー情報削除画面のメソッド
     *
     * @access public 
     * @return null returnを付けないとif文内のビューに飛ばせないため。 
     */
    public function action_delete()
    {
        $user = \Session::get('session');
        
        if (empty($user))
        {
            $this->template->title   = 'ログイン画面';
            $this->template->content = \View::forge('user/loginform');
            $this->template->content->set_safe('html_error', 'ログインしていません。');
            return;
        }
        
        $this->template->title   = 'ユーザー削除：フォーム';
        $this->template->content = \View::forge('user/deleteform');
    }

    /**
     * ユーザー情報削除の実行メソッド
     *  
     * ログインされていなければログイン画面へ飛ばす。
     * フォームから受け取ったパスワードを検証する。
     * OKなら削除実行し、セッションを破棄して完了画面を表示させる。
     * NGならエラーメッセージを表示＆ユーザー情報削除画面を再表示。
     * 
     * @access public
     * @return null returnを付けないとif文内のビューに飛ばせないため。 
     */
    public function action_deleteconfirm()
    {
        $user = \Session::get('session');
        if (empty($user))
        {
            $this->template->title   = 'ログイン画面';
            $this->template->content = \View::forge('user/loginform');
            $this->template->content->set_safe('html_error', 'ログインしていません。');
            return;
        }
        
        $model = \Model_User::forge();
        $val  = $model->validate('delete');
        
        if (!$val->run())
        {
            $this->template->title   = 'ユーザー削除：エラー';
            $this->template->content = \View::forge('user/deleteform');
            $this->template->content->set_safe('html_error', $val->show_errors());
        }
            
        $id   = $user['id'];
        $pass = md5($val->validated('pass'));
        $found = $model::find('all', array(
            'where' => array(
                array('id', $id),
                array('pass', $pass)
                ))
            );
        
        if (!isset($found))
        {
            $this->template->title   = 'ユーザー削除：フォーム';
            $this->template->content = \View::forge('user/deleteform');
            $this->template->content->set_safe('html_error', 'パスワードが違います。');
        }

        
        $delete_user = $found[$id];
        //削除実行
        $delete_user->delete();
        \Session::destroy();
        $this->template->title   = '削除完了';
        $this->template->content = \View::forge('user/deletesend');
    }

    /**
     * ログアウトのメソッド
     *  
     * セッションを破棄してログインページへ飛ばす。
     * 
     * @access public 
     */
    public function action_logout()
    {
        //セッション破棄
        \Session::destroy();
        $this->template->title   = 'ログアウト画面';
        $this->template->content = \View::forge('user/loginform');
        $this->template->content->set_safe('html_error', 'ログアウトしました。');
    }
}
