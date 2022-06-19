<?php

namespace App\Repositories\Models;

use App\Interfaces\Models\MUserRepositoryInterface;
use App\Models\MUser;
use Carbon\Carbon;
use App\Libs\AppConstants;

class MUserRepository implements MUserRepositoryInterface
{
    /**
     * ユーザー情報仮登録
     *
     * @param  mixed $user_id ユーザーID
     * @param  mixed $name 氏名
     * @param  mixed $email メールアドレス
     * @param  mixed $password パスワード
     * @param  mixed $email_verified メール認証フラグ
     * @param  mixed $email_verify_token メールアドレスURLトークン
     * @param  mixed $email_verified_at メール認証発行日
     * @return void
     */
    public function store(
        string $user_id,
        $name,
        $email,
        $password,
        $email_verified,
        $email_verify_token,
        $email_verified_at
    ) {
        return MUser::create([
            MUser::COL_USER_ID => $user_id,
            MUser::COL_NAME => $name,
            MUser::COL_EMAIL => $email,
            MUser::COL_PASSWORD => $password,
            MUser::COL_EMAIL_VERIFIED => $email_verified,
            MUser::COL_EMAIL_VERIFY_TOKEN => $email_verify_token,
            MUser::COL_EMAIL_VERIFIED_AT => $email_verified_at,
        ]);
    }

    /**
     * ユーザー情報仮更新
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $name 氏名
     * @param  mixed $email_verified メール認証フラグ
     * @param  mixed $email_verify_token メールアドレスURLトークン
     * @param  mixed $email_verified_at メール認証発行日
     * @return ユーザー情報
     */
    public function update(&$m_user, $name, $email_verified, $email_verify_token, $email_verified_at)
    {
        $m_user->name = $name;
        $m_user->email_verified = $email_verified;
        $m_user->email_verify_token = $email_verify_token;
        $m_user->email_verified_at = $email_verified_at;
        return $m_user->save();
    }

    /**
     * メールアドレスに紐づくユーザー情報取得
     *
     * @param  mixed $email メールアドレス
     * @return ユーザー情報
     */
    public function emailFindUser($email)
    {
        return MUser::emailFindUser($email);
    }

    /**
     * メールアドレスURLトークンに紐づくユーザー情報取得
     *
     * @param  mixed $email_verify_token メールアドレスURLトークン
     * @return ユーザー情報
     */
    public function emailVerifyTokenFindUser($email_verify_token)
    {
        return MUser::emailVerifyTokenFindUser($email_verify_token);
    }

    /**
     * パスワードリセットメールアドレスURLトークンに紐づくユーザー情報取得
     *
     * @param  mixed $email_password_reset_token パスワードリセットメールアドレスURLトークン
     * @return ユーザー情報
     */
    public function emailPasswordResetTokenFindUser($email_password_reset_token)
    {
        return MUser::emailPasswordResetTokenFindUser($email_password_reset_token);
    }

    /**
     * 本登録（パスワードの更新）
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $request リクエストパラメータ
     * @return void
     */
    public function updateEmailVerifiedPassword($m_user, $request)
    {
        $m_user->password = bcrypt($request->password);
        $m_user->email_verified = MUser::EMAIL_VERIFIED_ON;
        return $m_user->save();
    }

    /**
     * パスワードリセットトークン情報更新
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $email_password_reset_token パスワードリセットメールアドレスURLトークン
     * @return void
     */
    public function updatePasswordResetToken($m_user, $email_password_reset_token)
    {
        $m_user->email_password_reset_verified = MUser::EMAIL_PASSWORD_RESET_VERIFIED_OFF;
        $m_user->email_password_reset_token = $email_password_reset_token;
        $m_user->email_password_reset_at = new Carbon();
        return $m_user->save();
    }

    /**
     * パスワードリセット実行
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $password パスワード
     * @return void
     */
    public function updatePasswordReset($m_user, $password)
    {
        $m_user->password = bcrypt($password);
        $m_user->email_password_reset_verified = MUser::EMAIL_PASSWORD_RESET_VERIFIED_ON;
        return $m_user->save();
    }
}
