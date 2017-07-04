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

class RejectEmailService extends Mailable
{

    use Queueable, SerializesModels;
    public $reason;
    public function __construct($reason){
        $this->reason = $reason;
    }

    public function build(){
        return $this->subject(trans('validation.reject'))->view('emails.reject')->with(['reason' => $this->reason]);
    }
}