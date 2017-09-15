<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\User;
use Illuminate\Notifications\Notifiable;
use App\Mail\ForgotPassword;

class MailController extends Controller
{
    public function send(Request $request)
    {   

    	if (User::where('email', '=', request()->email)->count() > 0) {

    		$user = User::where('email','=',request()->email)->FirstOrFail();
	    	Mail::to($user->email)
	    			->send(new ForgotPassword($user));
					

            return response()->json(['status' => true, 'message' => 'Email Sent to '.request()->email , 'user' => $user], 200);
        }
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->greeting('Hello!')
                ->line('One of your invoices has been paid!')
                ->action('View Invoice')
                ->line('Thank you for using our application!');
    }
}
