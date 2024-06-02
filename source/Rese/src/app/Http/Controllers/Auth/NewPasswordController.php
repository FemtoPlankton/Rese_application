<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;


class NewPasswordController extends Controller
{
    /**
     * Display the password reset view or redirect if token is invalid.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $token
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, $token = null)
    {
        // セッションからメールアドレスを取得
        $email = $request->input('email');

        // メールアドレスからユーザーを検索
        $user = User::where('email', $email)->first();

        if (!$user) {
            // ユーザーが存在しない場合
            return redirect()->route('errors')->withErrors(['email' => __('passwords.user')]);
        }

        // トークンの有効性を確認
        $tokenStatus = Password::broker()->tokenExists($user, $token);

        if (!$tokenStatus) {
            // トークンが無効な場合
            return redirect()->route('errors')->withErrors(['token' => __('passwords.token')]);
        }

        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        // メールアドレスでユーザーを検索
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // ユーザーが存在しない場合
            return back()->withErrors(['email' => __('passwords.user')]);
        }

        // トークンが有効かどうかを確認
        $tokenExists = Password::broker()->tokenExists($user, $request->token);

        if (!$tokenExists) {
            // トークンが無効な場合
            return redirect()->route('expired')->withErrors(['token' => __('passwords.token')]);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            // パスワードリセット成功
            return redirect()->route('login')->with('status', __($status));
        } else {
            // その他のエラー
            return redirect()->route('errors')->withErrors(['token' => __($status)]);
        }
    }
}
