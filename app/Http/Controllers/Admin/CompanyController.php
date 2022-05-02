<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use LaraCar\Company;
use LaraCar\User;
use LaraCar\Http\Requests\Admin\Company as CompanyRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Storage;
use LaraCar\Support\Cropper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        if (Auth::user()->hasAnyRole(['Administrador', 'Gerente'])) {
            $companies = Company::all();
        } else {
            $companies = Company::where('user', Auth::user()->id)->get();
        }
        return view('admin.companies.index', [
            'companies' => $companies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Cadastrar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::orderBy('name')->get();
        if (!empty($request->user)) {
            $user = User::where('id', $request->user)->first();
        }
        return view('admin.companies.create', [
            'users' => $users,
            'selected' => (!empty($user) ? $user : null),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Cadastrar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $validatorSlug = Validator::make($request->all(), [
            'slug' => [
                'required',
                Rule::unique('companies')
            ],
        ]);

        if ($validatorSlug->fails()) {
            return redirect()->back()->withInput()
                ->with(['color' => 'orange', 'message' => 'O nome do link já se encontra em uso!']);
        }

        $validatorEmail = Validator::make($request->all(), [
            'email' => [
                'required',
                Rule::unique('companies')
            ],
        ]);

        if ($validatorEmail->fails()) {
            return redirect()->back()->withInput()
                ->with(['color' => 'orange', 'message' => 'O e-mail já se encontra em uso!']);
        }

        $createCompany = Company::create($request->all());
        $createCompany->setSlug();
        if (!empty($request->file('cover'))) {
            $createCompany->cover = $request->file('cover')
                ->storeAs('company', Str::slug($request->social_name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                    ->extension());
            $createCompany->save();
        }

        if (!empty($request->file('cover1'))) {
            $createCompany->cover1 = $request->file('cover1')
                ->storeAs('company', Str::slug($request->social_name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover1')
                    ->extension());
            $createCompany->save();
        }

        return redirect()->route('admin.companies.edit', [
            'company' => $createCompany->id,
        ])->with(['color' => 'green', 'message' => 'Empresa cadastrada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::where('id', $id)->first();
        $users = User::orderBy('name')->get();
        return view('admin.companies.edit', [
            'company' => $company,
            'users' => $users,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company = Company::where('id', $id)->first();
        if (empty($company->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        if (Auth::user()->hasRole('Anunciante') && $company->user != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $users = User::orderBy('name')->get();
        return view('admin.companies.edit', [
            'company' => $company,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $company = Company::where('id', $id)->first();
        if (Auth::user()->hasRole('Anunciante') && $company->user != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $validatorSlug = Validator::make($request->all(), [
            'slug' => [
                'required',
                Rule::unique('companies')->ignore($company->id),
            ],
        ]);

        if ($validatorSlug->fails()) {
            return redirect()->route('admin.companies.edit', [
                'company' => $company->id,
            ])->with(['color' => 'orange', 'message' => 'O nome do link já se encontra em uso!']);
        }

        $validatorEmail = Validator::make($request->all(), [
            'email' => [
                'required',
                Rule::unique('companies')->ignore($company->id),
            ],
        ]);

        if ($validatorEmail->fails()) {
            return redirect()->route('admin.companies.edit', [
                'company' => $company->id,
            ])->with(['color' => 'orange', 'message' => 'O campo e-mail já se encontra em uso!']);
        }

        if (!empty($request->file('cover'))) {
            Storage::delete($company->cover);
            Cropper::flush($company->cover);
            $company->cover = '';
        }

        if (!empty($request->file('cover1'))) {
            Storage::delete($company->cover1);
            Cropper::flush($company->cover1);
            $company->cover1 = '';
        }

        $company->fill($request->all());

        if (Auth::user()->hasRole('Anunciante')) {
            $company->setUserAttribute(Auth::user()->id);
        }

        $company->setSlug();

        if (!empty($request->file('cover'))) {
            $company->cover = $request->file('cover')
                ->storeAs('company', Str::slug($request->social_name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                    ->extension());
            $company->save();
        }

        if (!empty($request->file('cover1'))) {
            $company->cover1 = $request->file('cover1')
                ->storeAs('company', Str::slug($request->social_name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover1')
                    ->extension());
            $company->save();
        }

        return redirect()->route('admin.companies.edit', [
            'company' => $company->id,
        ])->with(['color' => 'green', 'message' => 'Empresa atualizada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('Remover Empresas')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company = Company::where('id', $id)->first();
        if (Auth::user()->hasRole('Anunciante') && $company->user != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $company->delete();
        return redirect()->route('admin.companies.index')->with(['color' => 'orange', 'message' => 'Empresa removida com sucesso!']);
    }
}
