<?php
namespace App\Libs;

class AppConstants {

    /********************************************
    /* 画面表示
    /********************************************
    /** 画面タイトル */
    const VIEW_TITLE = 'TF-CMS';

    /********************************************
    /* ロジックキー
    /********************************************
    /** メッセージ */
    const KEY_MSG = 'msg';
    /** 成功 */
    const KEY_SUCCESS = 'success';
    /** エラー */
    const KEY_ERR = 'error';
    /** エラーログ */
    const KEY_LOG = 'log';
    /** レスポンス */
    const KEY_RESPONSE = 'response';
    /** APIトークン名称 */
    const KEY_TOKEN_NAME = 'token-name';
    /** APIトークン */
    const KEY_API_TOKEN = 'api_token';
    /** ハッシュ sha256 */
    const HASH_KEY_SHA256 = 'sha256';

    /********************************************
    /* ルーティングディレクトリ
    /********************************************
    /** ユーザー */
    const ROOT_DIR_USERS = 'users';
    /** ログイン */
    const ROOT_DIR_LOGIN = 'login';
    /** 新規作成 */
    const ROOT_DIR_CREATE = 'create';
    /** パスワードリセット */
    const ROOT_DIR_PASSWORD_RESET = 'passwordReset';
    /** 新規作成（仮） */
    const ROOT_DIR_CREATE_PRE = self::ROOT_DIR_CREATE . 'Pre';
    /** パスワードリセット（仮） */
    const ROOT_DIR_PASSWORD_RESET_PRE = self::ROOT_DIR_PASSWORD_RESET . 'Pre';
    /** ログイン */
    const ROOT_DIR_USERS_LOGIN = self::ROOT_DIR_USERS . '/'. self::ROOT_DIR_LOGIN;
    /** パスワードリセット（仮登録） */
    const ROOT_DIR_USERS_PASSWORD_RESET_PRE = self::ROOT_DIR_USERS . '/'. self::ROOT_DIR_PASSWORD_RESET_PRE;
    /** パスワードリセット */
    const ROOT_DIR_USERS_PASSWORD_RESET = self::ROOT_DIR_USERS . '/'. self::ROOT_DIR_PASSWORD_RESET;
    /** ユーザー新規作成（仮登録） */
    const ROOT_DIR_USERS_CREATE_PRE = self::ROOT_DIR_USERS . '/'. self::ROOT_DIR_CREATE_PRE;
    /** ユーザー新規作成 */
    const ROOT_DIR_USERS_CREATE = self::ROOT_DIR_USERS . '/'. self::ROOT_DIR_CREATE;

    /** エラーメッセージ */
    const ERR_MSG = "エラーが発生しました。";
    /** 無効なトークン */
    const ERR_MSG_EMAIL_VERIFY_TOKEN_VALID = '無効なトークンです。URLが途切れていないかご確認下さい。';
    /** 本登録済み */
    const ERR_MSG_USER_REGIST_COMPLETED = '既に本登録されています。ログインを行いご利用下さい。';
    /** メール認証発効後24時間以上経過 */
    const ERR_MSG_EMAIL_AUTH_24HOURS_PASSED = 'メール認証の発行から24時間以上経過しています。再度アカウント設定を行って下さい。';
    /** 仮登録済みのメールアドレス */
    const ERR_MSG_EMAIL_VERIFIED_OFF = "仮登録済のメールアドレスです。メールにて本登録を完了させて下さい。";
    /** 本登録済みのメールアドレス */
    const ERR_MSG_EMAIL_VERIFIED_ON = "このメールアドレスは既に本登録されています。他のメールアドレスを入力して下さい。";
    /** 未登録のメールアドレス */
    const ERR_MSG_NOT_EXISTS = "未登録のメールアドレスです。";
    /** 未登録のメールアドレス */
    const ERR_MSG_EMAIL_VERIFIED_OFF = "仮登録済のメールアドレスです。メールにて本登録を完了させて下さい。";
}
