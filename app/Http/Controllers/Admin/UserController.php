<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use LaraCar\Support\Cropper;
use LaraCar\Http\Controllers\Controller;
use LaraCar\Http\Requests\Admin\User as UserRequest;
use LaraCar\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use LaraCar\Company;
use LaraCar\Config;
use LaraCar\Mail\Web\Contact;
use Spatie\Permission\Exceptions\UnauthorizedException;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::all();
        return view('admin.users.index', ['users' => $users]);
    }

    public function team()
    {
        if (!Auth::user()->hasPermissionTo('Listar Usuários - Equipe')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::where('admin', 1)->get();
        return view('admin.users.team', [
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Cadastrar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $roles = Role::all();

        foreach ($roles as $role) {
            $role->can = false;
        }

        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        if (!Auth::user()->hasPermissionTo('Cadastrar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $userCreate = User::create($request->all());
        if (!empty($request->file('cover'))) {
            $userCreate->cover = $request->file('cover')
                ->storeAs('user', Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                    ->extension());
            $userCreate->save();
        }
        $rolesRequest = $request->all();

        $userCreate->admin = true;
        $userCreate->ads_limit = (Config::first())->initial_ads;
        $userCreate->save();

        $roles = null;
        foreach ($rolesRequest as $key => $value) {
            if (Str::is('acl_*', $key) == true) {
                $roles[] = Role::where('id', ltrim($key, 'acl_'))->first();
            }
        }

        if (!empty($roles)) {
            $userCreate->syncRoles($roles);
        } else {
            $userCreate->syncRoles('Anunciante');
        }
        return redirect()->route('admin.users.edit', [
            'user' => $userCreate->id
        ])->with(['color' => 'green', 'message' => 'Cliente cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (!Auth::user()->hasPermissionTo('Editar Usuários')) {
        //     throw new UnauthorizedException('403', 'You do not have the required authorization.');
        // }

        if (Auth::user()->hasRole('Anunciante') && $id != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $user = User::where('id', $id)->first();
        if (empty($user->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        // if (Auth::user()->hasRole('Administrador')) {
            $roles = Role::all();
        // } else {
        //     $roles = Role::where('name', '!=', 'Administrador')->get();
        // }
        foreach ($roles as $role) {
            if ($user->hasRole($role->name)) {
                $role->can = true;
            } else {
                $role->can = false;
            }
        }
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $user = User::where('id', $id)->first();

        if (Auth::user()->hasRole('Anunciante') && $user->id != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        if (Auth::user()->hasAnyRole(['Administrador', 'Gerente'])) {
            $user->setSellerAttribute($request->seller);
            $user->setBuyerAttribute($request->buyer);
            $user->setAdminAttribute($request->admin);
            $user->setClientAttribute($request->client);
            $user->setAdsLimitAttribute($request->ads_limit);
        } else {
            if ($user->seller == '1') {
                $user->setSellerAttribute(true);
            } else {
                $user->setSellerAttribute(false);
            }
            if ($user->buyer == '1') {
                $user->setBuyerAttribute(true);
            } else {
                $user->setBuyerAttribute(false);
            }
            if ($user->admin == '1') {
                $user->setAdminAttribute(true);
            } else {
                $user->setAdminAttribute(false);
            }
            if ($user->client == '1') {
                $user->setClientAttribute(true);
            } else {
                $user->setClientAttribute(false);
            }
        }
        if (!empty($request->file('cover'))) {
            Storage::delete($user->cover);
            Cropper::flush($user->cover);
            $user->cover = '';
        }
        $user->fill($request->all());
        if (!empty($request->file('cover'))) {
            $user->cover = $request->file('cover')
                ->storeAs('user', Str::slug($request->name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                    ->extension());
        }
        if (!$user->save()) {
            return redirect()->back()->withInput()->withErrors();
        }

        $rolesRequest = $request->all();
        $roles = null;
        foreach ($rolesRequest as $key => $value) {
            if (Str::is('acl_*', $key) == true) {
                $roles[] = Role::where('id', ltrim($key, 'acl_'))->first();
            } elseif (Auth::user()->hasRole('Anunciante')) {
                $roles[] = 'Anunciante';
            }
        }

        if (!empty($roles)) {
            $user->syncRoles($roles);
        } else {
            $user->syncRoles('Anunciante');
        }

        return redirect()->route('admin.users.edit', [
            'user' => $user->id
        ])->with(['color' => 'green', 'message' => 'Cliente atualizado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('Remover Usuários')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        if (Auth::user()->id == $id) {
            return redirect()->route('admin.users.index')->with(['color' => 'orange', 'message' => 'Exclusão não realizada! Por segurança, você não pode excluir seu usuário.']);
        }
        $user = User::where('id', $id)->first();
        $user->delete();
        return redirect()->route('admin.users.index')->with(['color' => 'orange', 'message' => 'Usuário removido com sucesso!']);
    }

    public function message(Request $request)
    {
        $user = User::where('id', $request->user)->first();

        $data = [
            'reply_name' => "Administração " . env('APP_NAME'),
            'reply_email' => env('MAIL_FROM_ADDRESS'),
            'cell' => '',
            'message' => $request->message,
            'company' => $user->email
        ];

        Mail::send(new Contact($data));

        return \response()->json(true);
    }
}
