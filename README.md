# ユーザAPI

* Version: 1.7
* [API（ログイン）] POST /api/v1/user/
* [API（トークンによる取得）] GET /api/v1/user/?token=XXXXXXXXXXXXXXXXXXXX
* [管理画面] /api/admin/users/login

## Description

ユーザ取得を行うAPI
ログインとトークンによる取得が行える

管理画面でユーザ登録と編集（名前とアドレスのみ）が行える

エラー処理とかCSRF対策とかは対策とかは気が向いたら。
