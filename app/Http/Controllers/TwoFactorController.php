<?php

// namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;
// use App\Models\User;
// use App\Services\TwilioService;
// use Illuminate\Support\Carbon;
// use Illuminate\Support\Facades\Auth;

// class TwoFactorController extends Controller
// {
//     protected $twilio;
//     public function __construct(TwilioService $twilio)
//     {
//         $this->twilio = $twilio;
//     }
//     public function verifyPage()
//     {
//         return view('auth.two-factor');
//     }
//     public function sendCode()
//     {
//         /** @var User $user */
//         $user = Auth::user();
//         if (!$user) {
//             return redirect()->route('login')->withErrors(['error' => 'User not found.']);
//         }
//         if (!$user->phone) {
//             return redirect()->route('2fa.verify')->withErrors(['phone' => 'Your phone number is not set.']);
//         }
//         $user->two_factor_code = rand(100000, 999999);
//         $user->two_factor_expires_at = now()->addMinutes(10);
//         $user->save();


//         try {
//             $this->twilio->sendSms($user->phone, "Your 2FA code is: {$user->two_factor_code}");
//         } catch (\Exception $e) {
//             return redirect()->route('2fa.verify')->withErrors(['error' => 'Failed to send verification code.']);
//         }
//         return redirect()->route('2fa.verify')->with('message', 'A verification code has been sent to your phone.');
//     }
//     public function verifyCode(Request $request)
//     {
//         $request->validate(['two_factor_code' => 'required|numeric']);
//         /** @var User $user */
//         $user = Auth::user();
//         if ($user->two_factor_code === $request->two_factor_code && $user->two_factor_expires_at->isFuture()) {
//             $user->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);
//             return redirect()->route('login');
//         }
//         return redirect()->route('2fa.verify')->withErrors(['two_factor_code' => 'Invalid or expired code.']);
//     }
//     public function authenticated(Request $request, User $user)
//     {
//         if ($user->two_factor_code) {
//             return redirect()->route('2fa.verify');
//         }
//         return redirect()->route('login');
//     }
// }
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\TwilioService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    protected $twilio;
    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }
    public function verifyPage()
    {
        return view('auth.two-factor');
    }
    public function sendCode()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'User not found.']);
        }
        if (!$user->phone) {
            return redirect()->route('2fa.verify')->withErrors(['phone' => 'Your phone number is not set.']);
        }
        $code = rand(100000, 999999);
        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => Carbon::now()->addMinutes(10),
        ]);
        try {
            $this->twilio->sendSms($user->phone, "Your 2FA code is: $code");
        } catch (\Exception $e) {
            return redirect()->route('2fa.verify')->withErrors(['error' => 'Failed to send verification code.']);
        }
        return redirect()->route('2fa.verify')->with('message', 'A verification code has been sent to your phone.');
    }
    public function verifyCode(Request $request)
    {
        $request->validate(['two_factor_code' => 'required|numeric']);
        /** @var User $user */
        $user = Auth::user();
        if ($user->two_factor_code === $request->two_factor_code && $user->two_factor_expires_at->isFuture()) {
            $user->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);
            return redirect()->route('login');
        }
        return redirect()->route('2fa.verify')->withErrors(['two_factor_code' => 'Invalid or expired code.']);
    }
    public function authenticated(Request $request, User $user)
    {
        if ($user->two_factor_code) {
            return redirect()->route('2fa.verify');
        }
        return redirect()->route('login');
    }
}
