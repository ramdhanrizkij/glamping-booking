<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResendEmailVerificationCodeRequest;
use App\Http\Requests\Auth\VerifyEmailCodeRequest;
use App\Models\User;
use App\Support\EmailVerificationCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EmailVerificationCodeController extends Controller
{
    public function __construct(
        private readonly EmailVerificationCodeService $verificationCodes,
    ) {
    }

    public function create(Request $request): Response|RedirectResponse
    {
        if ($request->user()?->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        return Inertia::render('auth/verify-email', [
            'status' => $request->session()->get('status'),
            'email' => $request->string('email')->toString() ?: $request->user()?->email,
        ]);
    }

    public function store(VerifyEmailCodeRequest $request): RedirectResponse
    {
        $user = User::query()
            ->where('email', $request->string('email')->toString())
            ->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->route('login')
                ->with('status', 'email-already-verified');
        }

        if (! $this->verificationCodes->verify($user, $request->string('code')->toString())) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'code' => __('Kode verifikasi tidak valid atau sudah kedaluwarsa.'),
                ]);
        }

        $user->markEmailAsVerified();
        $this->verificationCodes->clear($user);

        if ($request->user()?->is($user)) {
            return redirect()
                ->route('customer.profile.edit')
                ->with('status', 'email-verified');
        }

        return redirect()
            ->route('login', ['email' => $user->email])
            ->with('status', 'email-verified');
    }

    public function resend(ResendEmailVerificationCodeRequest $request): RedirectResponse
    {
        $user = User::query()
            ->where('email', $request->string('email')->toString())
            ->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            return redirect()
                ->route('login', ['email' => $user->email])
                ->with('status', 'email-already-verified');
        }

        $user->sendEmailVerificationNotification();

        return back()
            ->withInput($request->only('email'))
            ->with('status', 'verification-code-sent');
    }
}
