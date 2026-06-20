<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class EmailVerificationCodeService
{
    public const TTL_MINUTES = 10;

    public function generateFor(User $user): string
    {
        $code = (string) random_int(100000, 999999);

        Cache::put(
            $this->cacheKey($user),
            Hash::make($code),
            now()->addMinutes(self::TTL_MINUTES),
        );

        return $code;
    }

    public function verify(User $user, string $code): bool
    {
        $hashedCode = Cache::get($this->cacheKey($user));

        if (! is_string($hashedCode)) {
            return false;
        }

        return Hash::check($code, $hashedCode);
    }

    public function clear(User $user): void
    {
        Cache::forget($this->cacheKey($user));
    }

    private function cacheKey(User $user): string
    {
        return 'email_verification_code:'.$user->getKey();
    }
}
