<?php

namespace App\Http\Controllers\Auth;

use App\Services\UserService;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

/**
 * Class AuthController
 *
 * デフォルトの認証コントローラを利用してアプリケーションに合わせてオーバーライドします
 * アプリケーションの仕様によってはデフォルトで含まれている認証コントローラを利用しなくても構いません
 *
 * インストール時に含まれるコントローラなどの各クラスは利用必須のクラスではないということを理解しておきましょう
 */
class AuthController extends Controller
{
    // デフォルトで幾つかログインやユーザー登録といったメソッドが用意されています
    // 本サンプルではアプリケーションに合わせてオーバーライドして変更します
    use AuthenticatesAndRegistersUsers;

    /** @var Guard */
    protected $auth;

    /**
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        // getLogout メソッド以外は未ログインの場合にのみアクセスできます
        $this->middleware('guest', ['except' => 'getLogout']);
        // ログインユーザーのみgetLogoutを許可します
        $this->middleware('auth', ['only' => 'getLogout']);

        $this->auth = $auth;
    }

    /**
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(LoginRequest $request)
    {
        $result = $this->auth->attempt(
            $request->only(['email', 'password']),
            $request->get('remember', false)
        );
        if (!$result) {
            return redirect()->route('get.login')
                ->with('message', 'ユーザー認証に失敗しました'); // このメッセージはtransヘルパー関数を利用しても表示できます
        }
        return redirect()->route('admin.entry.index');
    }

    /**
     * @param UserRegisterRequest $request
     * @param UserService         $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister(UserRegisterRequest $request, UserService $user)
    {
        $result = $user->registerUser($request->only(['name', 'email', 'password']));
        $this->auth->login($result);
        return redirect()->route('admin.entry.index')
            // transヘルパー関数を利用する場合は、resources/lang 配下に実行環境ごとの言語ファイルを作成して利用します
            // テンプレートなどで利用してみましょう
            ->with('register_message', trans('message.register.success'));
    }
}
