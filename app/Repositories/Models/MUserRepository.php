<?php

namespace App\Repositories\Models;

use App\Interfaces\Models\MUserRepositoryInterface;
use App\Models\MUser;
use Carbon\Carbon;
use App\Libs\DateUtil;
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
    public function createPre(
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
     * 仮登録判定
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $msg エラーメッセージ
     * @return 仮登録判定フラグ
     */
    public function isCreatedPre($m_user, &$msg)
    {
        // 既にデータ作成されているか判定
        if ($m_user->count()) {
            // 仮登録済か判定
            if (!$m_user->email_verified) {
                $msg = AppConstants::ERR_MSG_EMAIL_VERIFIED_OFF;
                return false;
            } else {
                $msg = AppConstants::ERR_MSG_EMAIL_VERIFIED_ON;
                return false;
            }
        }
        return true;
    }

    /**
     * 本登録判定
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $msg エラーメッセージ
     * @return 本登録判定フラグ
     */
    public function isCreated($m_user, &$msg)
    {
        // 登録されているトークンか判定
        if (!$m_user->count()) {
            $msg .= AppConstants::ERR_MSG_EMAIL_VERIFY_TOKEN_VALID;
            return false;
        }
        // 本登録されているか判定
        if ($m_user->email_verified) {
            $msg .= AppConstants::ERR_MSG_USER_REGIST_COMPLETED;
            return false;
        }
        // メール認証の発行から、1日以上経過しているか
        if (DateUtil::isAddDay($m_user->email_verified_at)) {
            $msg .= AppConstants::ERR_MSG_EMAIL_AUTH_24HOURS_PASSED;
            return false;
        }
        return true;
    }

    /**
     * パスワードリセット仮登録判定
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $msg エラーメッセージ
     * @return パスワードリセット仮登録判定フラグ
     */
    public function isPasswordResetPred($m_user, &$msg)
    {
        // メールアドレスが登録されているか判定
        if (!$m_user->count()) {
            $msg .= AppConstants::ERR_MSG_NOT_EXISTS;
            return false;
        }

        // 本登録されているか判定
        if (!$m_user->email_password_reset_verified) {
            $msg .= AppConstants::ERR_MSG_EMAIL_VERIFIED_OFF;
            return false;
        }
        return true;
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
