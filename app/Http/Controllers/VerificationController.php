<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Usuario;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('signed')->only('verify')->except('resend');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        $currentUser = Usuario::findOrFail($request->route('username'));

        if (! hash_equals((string) $request->route('hash'), sha1($currentUser->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($currentUser->hasVerifiedEmail()) {
            return new Response('', 204);
        }

        if ($currentUser->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return new Response('', 204);
    }


    /**
     * Resend the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        $currentUser = Usuario::findOrFail($request->route('username'));

        if ($currentUser->hasVerifiedEmail()) {
            return new Response('', 204);
        }

        $currentUser->sendEmailVerificationNotification();

        return new Response('', 202);
    }
}
