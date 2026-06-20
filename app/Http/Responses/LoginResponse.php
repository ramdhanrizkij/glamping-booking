<?php

namespace App\Http\Responses;

use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse
    {
        $user = $request->user();

        if ($user && ! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return redirect()
                ->route('verification.code.notice')
                ->with('status', 'verification-code-sent');
        }

        if ($user?->hasRole('customer') && ! $user->customer()->exists()) {
            return redirect()->route('customer.profile.edit');
        }

        return redirect()->intended(route('dashboard'));
    }
}
