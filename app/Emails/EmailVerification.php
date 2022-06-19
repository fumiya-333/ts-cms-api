<?php
namespace App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Libs\AppConstants;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;
    /** 件名 */
    private $_subject;
    /** 本文代入変数 */
    private $variables;
    /** 本文ファイルパス */
    private $text_file_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $variables, $text_file_path)
    {
        $this->_subject = $subject;
        $this->variables = $variables;
        $this->text_file_path = $text_file_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->_subject)
            ->text($this->text_file_path)
            ->with($this->variables);
    }

    /**
     * メール本文の取得
     *
     * @return メール本文
     */
    public function getMessage()
    {
        return $this->view($this->text_file_path)->render();
    }
}
