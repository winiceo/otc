<?php



namespace Genv\Otc\Http\Controllers\Auth;

use Illuminate\Http\Request;
use function Genv\Otc\username;
use Illuminate\Contracts\Config\Repository;
use Genv\Otc\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        login as authenticatesUsersLogin;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function showLoginForm(Repository $config)
    {
        return view('admin.login', [
            'login' => $login = old('email', old('phone', old('name', old('id', '')))),
            'errorUsername' => username($login),
            'logo' => $config->get('site.background.logo', url('/plus.png')),
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     * @author Seven Du <shiweidu@outlook.com>
     */
    public function login(Request $request)
    {
        $request->merge([
            $this->username() => $request->input('login'),
        ]);

        return $this->authenticatesUsersLogin($request);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function username(): string
    {
        return username(
            request()->input('login')
        );
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     * @author Seven Du <shiweidu@outlook.com>
     */
    protected function redirectTo(): string
    {
        return request()->input('redirect') ?: '/';
    }
}
