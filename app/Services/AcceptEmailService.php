<?php
/**
 * Created by PhpStorm.
 * User: Usuario
 * Date: 04/07/2017
 * Time: 1:23
 */

namespace App\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AcceptEmailService extends Mailable
{

    use Queueable, SerializesModels;
    public $password;
    public function __construct($password){
        $this->password = $password;
    }

    public function build(){
        return $this->subject(trans('validation.accept'))->view('emails.accept')->with(['password' => $this->password]);
    }
}