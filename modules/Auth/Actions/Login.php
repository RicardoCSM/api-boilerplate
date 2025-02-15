<?php

declare(strict_types=1);

namespace Modules\Auth\Actions;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\Auth\DTOs\LoginDTO;
use Modules\Auth\Models\User;
use Modules\Auth\Models\UserLogin;
use Modules\Auth\Settings\AuthSettings;
use Modules\Common\Core\Support\Modules;
use Modules\Common\Logs\Support\AccessActions;
use Modules\Common\Logs\Support\AccessLogHelper;

final readonly class Login
{
    private const TOKEN_TYPE = 'Bearer';

    public function __construct(private Request $request, private AuthSettings $settings) {}

    public function handle(LoginDTO $dto): array
    {
        $this->ensureIsNotRateLimited();

        $token = Auth::attempt($dto->toArray());
        if (! $token) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        /** @var \Modules\Auth\Models\User $user */
        $user = Auth::user();
        $this->recordLogin($user);

        if ($user->isFirstLogin()) {
            $user->markAsNotFirstLogin();

            $redirect = $this->settings->redirect_on_first_login_path;
            $forceChangePassword = $this->settings->force_change_password_on_first_login;
        }

        AccessLogHelper::log(action: AccessActions::LOGIN, module: Modules::AUTH);

        return [
            'type' => self::TOKEN_TYPE,
            'token' => $token,
            'redirect' => $redirect ?? null,
            'force_change_password' => $forceChangePassword ?? null,
        ];
    }

    private function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this->request));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->request->login) . '|' . $this->request->ip());
    }

    private function recordLogin(User $user): void
    {
        UserLogin::query()->create([
            'user_id' => $user->id,
            'ip' => $this->request->ip(),
            'user_agent' => $this->request->header('user-agent'),
        ]);
    }
}
