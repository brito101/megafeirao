<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LaraCar\User;
use LaraCar\Automotive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use LaraCar\Mail\Admin\ForgottenPassword;
use Illuminate\Support\Facades\Storage;
use LaraCar\Config;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        if (Auth::check() === true) {
            return redirect()->route('admin.home');
        }
        // return view('admin.index');
        return view('admin.login.index');
    }

    public function newAccount()
    {
        // return view('admin.account');
        return view('admin.login.index');
    }

    public function createAccount(Request $request)
    {
        /* Validações */
        if (!filter_var($request->email, FILTER_SANITIZE_EMAIL) || strlen($request->email) > 191) {
            $json['message'] = $this->message->error("Por favor, informe um e-mail válido.")->render();
            return response()->json($json);
        }

        if (!filter_var($request->name, FILTER_SANITIZE_STRIPPED)) {
            $json['message'] = $this->message->error("Por favor, informe um usuário válido")->render();
            return response()->json($json);
        }

        if (strlen($request->name) < 3 || strlen($request->name) > 191) {
            $json['message'] = $this->message->error("O usuário deve conter entre 2 e 191 caracteres.")->render();
            return response()->json($json);
        }

        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            $json['message'] = $this->message->error("Usuário já cadastrado.")->render();
            return response()->json($json);
        }

        /* Criação de usuário */
        $userCreate = new User();
        $userCreate->admin = true;
        $userCreate->email = filter_var($request->email, FILTER_SANITIZE_STRIPPED);
        $userCreate->password = $request->password;
        $userCreate->name = $request->name;
        $userCreate->ads_limit = (Config::first())->initial_ads;

        if ($userCreate->save()) {
            Storage::append('usuarios.txt', $userCreate->email);
            Storage::append('clientes.txt', $userCreate->name . " - " . $userCreate->email);
            $userCreate->syncRoles('Anunciante');
        }

        /* Login */
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        Auth::attempt($credentials);

        $this->authenticated($request->getClientIp());
        $json['redirect'] = route('admin.home');
        return response()->json($json);
    }

    public function home()
    {
        if (Auth::user()->hasAnyRole(['Administrador', 'Gerente'])) {
            $team = User::whereHas('roles', function ($q) {
                $q->where('name', 'Anunciante');
            })->count();
            $automotivesAvailable = Automotive::available()->count();
            $automotivesUnavailable = Automotive::unavailable()->count();
            $automotivesTotal = Automotive::all()->count();

            $automotives = Automotive::orderBy('id', 'DESC')->limit(3)->get();

            return view('admin.dashboard', [
                'team' => $team,
                'automotivesAvailable' => $automotivesAvailable,
                'automotivesUnavailable' => $automotivesUnavailable,
                'automotivesTotal' => $automotivesTotal,
                'automotives' => $automotives,
            ]);
        } else {
            $user = Auth::user()->id;
            $automotivesAvailable = Automotive::available()->where('user', $user)->count();
            $automotivesUnavailable = Automotive::unavailable()->where('user', $user)->count();
            $automotivesTotal = Automotive::all()->where('user', $user)->count();
            $automotives = Automotive::orderBy('id', 'DESC')->where('user', $user)->limit(3)->get();

            return view('admin.dashboard', [
                'automotivesAvailable' => $automotivesAvailable,
                'automotivesUnavailable' => $automotivesUnavailable,
                'automotivesTotal' => $automotivesTotal,
                'automotives' => $automotives,
            ]);
        }
    }

    public function login(Request $request)
    {

        if (in_array('', $request->only('email', 'password'))) {
            $json['message'] = $this->message->error("Por favor, informe todos os dados para realizar o login.")->render();
            return response()->json($json);
        }

        if (!filter_var($request->email, FILTER_SANITIZE_EMAIL)) {
            $json['message'] = $this->message->error("Por favor, informe um e-mail válido.")->render();
            return response()->json($json);
        }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            $json['message'] = $this->message->error("Usuário e senha não conferem.")->render();
            return response()->json($json);
        }

        if (!$this->isAdmin()) {
            Auth::logout();
            $json['message'] = $this->message->error('Ooops, usuário não tem permissão para acessar o painel de controle')->render();
            return response()->json($json);
        }

        $this->authenticated($request->getClientIp());
        $json['redirect'] = route('admin.home');
        return response()->json($json);
    }

    private function isAdmin()
    {
        $user = User::where('id', Auth::user()->id)->first();

        if ($user->admin == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    private function authenticated(string $ip)
    {
        $user = User::where('id', Auth::user()->id);
        $user->update([
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $ip
        ]);
    }

    public function forgotten()
    {
        return view('admin.login.forgotten');
    }

    public function forgottenAccount(Request $request)
    {
        if (!filter_var($request->email, FILTER_SANITIZE_EMAIL) || strlen($request->email) > 191) {
            $json['message'] = $this->message->error("Por favor, informe um e-mail válido.")->render();
            return response()->json($json);
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (empty($user)) {
            $json['message'] = $this->message->error('Ooops! E-mail não encontrado.')->render();
            return response()->json($json);
        }

        $tokenData = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $tokenData,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if ($this->sendResetEmail($email, $tokenData)) {
            $json['message'] = $this->message->success('Sucesso! Verifique sua caixa de e-mail')->render();
        } else {
            $json['message'] = $this->message->error('Ocorreu um erro!')->render();
        }
        return response()->json($json);
    }

    private function sendResetEmail($email, $token)
    {
        $user = DB::table('users')->where('email', $email)->select('name', 'email')->first();
        $link = env('APP_URL') . '/admin/reset-account/' . $token;

        try {
            $data = [
                'reply_name' => $user->name,
                'reply_email' => $user->email,
                'message' => $link
            ];

            Mail::send(new ForgottenPassword($data));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function resetAccount()
    {
        return view('admin.login.reset');
    }

    public function resetPassword(Request $request)
    {
        $token = filter_var(str_replace(
            env('APP_URL') . '/admin/reset-account/',
            '',
            $request->server('HTTP_REFERER')
        ), FILTER_SANITIZE_STRIPPED);

        $userToken = DB::table('password_resets')->where('token', $token)->first();

        if (empty($userToken)) {
            $json['message'] = $this->message->error('Token Inválido! Verifique o link enviado para o seu -email')->render();
            return response()->json($json);
        }

        $user = User::where('email', $userToken->email)->first();

        if (empty($user)) {
            $json['message'] = $this->message->error('Usuário não encontrado! Verifique o link enviado para o seu -email')->render();
            return response()->json($json);
        }

        $user->password = $request->password;
        $user->update();

        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        $credentials = [
            'email' => $user->email,
            'password' => $request->password
        ];

        Auth::attempt($credentials);

        $this->authenticated($request->getClientIp());
        $json['redirect'] = route('admin.home');
        return response()->json($json);
    }
}
