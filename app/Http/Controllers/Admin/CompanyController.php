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
use LaraCar\Automotive;

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

        if ($request->type == 'concessionaria') {
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

        if (!empty($request->file('main_banner'))) {
            $createCompany->main_banner = $request->file('main_banner')
                ->storeAs('mainbanner', Str::slug($request->social_name) . '-main-banner-' . str_replace('.', '', microtime(true)) . '.' . $request->file('main_banner')
                    ->extension());
            $createCompany->save();
        }

        if (!empty($request->file('banner1'))) {
            $createCompany->banner1 = $request->file('banner1')
                ->storeAs('banner1', Str::slug($request->social_name) . '-banner1-' . str_replace('.', '', microtime(true)) . '.' . $request->file('banner1')
                    ->extension());
            $createCompany->save();
        }

        if (!empty($request->file('banner2'))) {
            $createCompany->banner2 = $request->file('banner2')
                ->storeAs('banner2', Str::slug($request->social_name) . '-banner2-' . str_replace('.', '', microtime(true)) . '.' . $request->file('banner2')
                    ->extension());
            $createCompany->save();
        }

        if (!empty($request->file('banner3'))) {
            $createCompany->banner3 = $request->file('banner3')
                ->storeAs('banner3', Str::slug($request->social_name) . '-banner3-' . str_replace('.', '', microtime(true)) . '.' . $request->file('banner3')
                    ->extension());
            $createCompany->save();
        }

        return redirect()->route('admin.companies.edit', [
            'company' => $createCompany->id,
        ])->with(['color' => 'green', 'message' => 'Cadastro realizado com sucesso!']);
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

        if ($request->type == 'concessionaria') {
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

        if (!empty($request->file('main_banner'))) {
            Storage::delete($company->main_banner);
            Cropper::flush($company->main_banner);
            $company->main_banner = '';
        }

        if (!empty($request->file('banner1'))) {
            Storage::delete($company->banner1);
            Cropper::flush($company->banner1);
            $company->banner1 = '';
        }

        if (!empty($request->file('banner2'))) {
            Storage::delete($company->banner2);
            Cropper::flush($company->banner2);
            $company->banner2 = '';
        }

        if (!empty($request->file('banner3'))) {
            Storage::delete($company->banner3);
            Cropper::flush($company->banner3);
            $company->banner3 = '';
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
        }

        if (!empty($request->file('cover1'))) {
            $company->cover1 = $request->file('cover1')
                ->storeAs('company', Str::slug($request->social_name) . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('cover1')
                    ->extension());            
        }

        if (!empty($request->file('main_banner'))) {
            $company->main_banner = $request->file('main_banner')
                ->storeAs('mainbanner', Str::slug($request->social_name) . '-main-banner-' . str_replace('.', '', microtime(true)) . '.' . $request->file('main_banner')
                    ->extension());
        }

        if (!empty($request->file('banner1'))) {
            $company->banner1 = $request->file('banner1')
                ->storeAs('banner1', Str::slug($request->social_name) . '-banner1-' . str_replace('.', '', microtime(true)) . '.' . $request->file('banner1')
                    ->extension());
        }

        if (!empty($request->file('banner2'))) {
            $company->banner2 = $request->file('banner2')
                ->storeAs('banner2', Str::slug($request->social_name) . '-banner2-' . str_replace('.', '', microtime(true)) . '.' . $request->file('banner2')
                    ->extension());
        }

        if (!empty($request->file('banner3'))) {
            $company->banner3 = $request->file('banner3')
                ->storeAs('banner3', Str::slug($request->social_name) . '-banner3-' . str_replace('.', '', microtime(true)) . '.' . $request->file('banner3')
                    ->extension());
        }

        $company->save();

        return redirect()->route('admin.companies.edit', [
            'company' => $company->id,
        ])->with(['color' => 'green', 'message' => 'Cadastro atualizado com sucesso!']);
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
        $owner = $company->ownerObject()->id;
        $automobiles = Automotive::where('user', $owner)->count();
        if ($automobiles > 0) {
            return redirect()->route('admin.companies.index')->with(['color' => 'red', 'message' => 'Cadastro NÃO REMOVIDO por ter anúncios vinculados!']);
        }
        $company->delete();
        return redirect()->route('admin.companies.index')->with(['color' => 'orange', 'message' => 'Cadastro removido com sucesso!']);
    }
}
