<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 07/04/2017
 * Time: 10:35
 */

namespace App\Services;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailService extends Mailable
{

    use Queueable, SerializesModels;
    public $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    public function build(){

        return $this->view('emails.forgotPassword')->with(['token' => $this->token]);
    }
}