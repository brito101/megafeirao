<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use LaraCar\User;
use LaraCar\Automotive;
use LaraCar\Http\Requests\Admin\Automotive as AutomotiveRequest;
use LaraCar\AutomotiveImage;
use Illuminate\Support\Facades\Storage;
use LaraCar\Support\Cropper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Str;
use LaraCar\Company;

class AutomotiveController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Veículos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $filter = $request->query('filter');
        if (Auth::user()->hasAnyRole(['Administrador', 'Gerente'])) {
            if (!empty($filter)) {
                $automotives = Automotive::orderBy('id', 'DESC')->where('title', 'like', '%' . $filter . '%')->get();
            } else {
                $automotives = Automotive::orderBy('id', 'DESC')->get();
            }
        } else {
            if (!empty($filter)) {
                $automotives = Automotive::orderBy('id', 'DESC')->where('user', Auth::user()->id)
                    ->where('title', 'like', '%' . $filter . '%')->get();
            } else {
                $automotives = Automotive::orderBy('id', 'DESC')->where('user', Auth::user()->id)->get();
            }
        }
        return view('admin.automotives.index', [
            'automotives' => $automotives,
            'filter' => $filter,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Cadastrar Veículos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $users = User::orderBy('name')->get();
        return view('admin.automotives.create', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AutomotiveRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Cadastrar Veículos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        if (Auth::user()->hasRole('Anunciante')) {
            if (Auth::user()->ads_limit == 0) {
                return redirect()->route('admin.automotives.index')->with(['color' => 'orange', 'message' => 'Cadastro não '
                    . 'realizado! Seu limite de anúncios foi excedido. Precisando de mais anúncios? Entre em contato com a nossa equipe!']);
            }
        }

        $createAutomotive = Automotive::create($request->all());

        if (Auth::user()->hasRole('Anunciante')) {
            $createAutomotive->setUserAttribute(Auth::user()->id);
            $company = Company::where('user', Auth::user()->id)->first();
        } else {
            $company = Company::where('user', $request->user)->first();
        }

        if (!empty($company->id)) {
            $createAutomotive->zipcode = $company->zipcode;
            $createAutomotive->street = $company->street;
            $createAutomotive->number = $company->number;
            $createAutomotive->complement = $company->complement;
            $createAutomotive->neighborhood = $company->neighborhood;
            $createAutomotive->state = $company->state;
            $createAutomotive->city = $company->city;
        }

        if ($request->spotlight) {
            if (Auth::user()->hasRole('Anunciante')) {
                if (Auth::user()->ads_limit == 0) {
                    return redirect()->route('admin.automotives.index')->with(['color' => 'orange', 'message' => 'Cadastro não '
                        . 'realizado! Seu limite de anúncios foi excedido. Precisando de mais anúncios? Entre em contato com a nossa equipe!']);
                } else {
                    Auth::user()->reduceAdsLimit();
                    $createAutomotive->setSpotlightAttribute($request->spotlight);
                }
            } else {
                $createAutomotive->setSpotlightAttribute($request->spotlight);
            }
        } else {
            $createAutomotive->setSpotlightAttribute($request->spotlight);
        }


        $createAutomotive->setStatusAttribute(1);
        $createAutomotive->setSaleAttribute(1);
        $createAutomotive->active_date = date('Y-m-d');
        $createAutomotive->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with(['color' => 'orange', 'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.']);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $automotiveImage = new AutomotiveImage();
                $automotiveImage->automotive = $createAutomotive->id;
                $automotiveImage->path = $image->storeAs('automotives/' . $createAutomotive->id, Str::slug($request->title) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $automotiveImage->save();
                unset($automotiveImage);
            }
        }

        if (Auth::user()->hasRole('Anunciante')) {
            Auth::user()->reduceAdsLimit();
        }

        return redirect()->route('admin.automotives.edit', [
            'automotive' => $createAutomotive->id
        ])->with(['color' => 'green', 'message' => 'Veículo cadastrado com sucesso!']);
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
        if (!Auth::user()->hasPermissionTo('Editar Veículos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $automotive = Automotive::where('id', $id)->first();
        if (empty($automotive->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        if (Auth::user()->hasRole('Anunciante') && $automotive->user != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $users = User::orderBy('name')->get();
        return view('admin.automotives.edit', [
            'automotive' => $automotive,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AutomotiveRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Veículos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $automotiveOld = Automotive::where('id', $id)->first();
        $automotive = Automotive::where('id', $id)->first();

        if (Auth::user()->hasRole('Anunciante') && $automotive->user != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $automotive->fill($request->all());

        if (Auth::user()->hasRole('Anunciante')) {
            $automotive->setUserAttribute(Auth::user()->id);
            $company = Company::where('user', Auth::user()->id)->first();
        } else {
            $company = Company::where('user', $request->user)->first();
        }

        if (!empty($company->id)) {
            $automotive->zipcode = $company->zipcode;
            $automotive->street = $company->street;
            $automotive->number = $company->number;
            $automotive->complement = $company->complement;
            $automotive->neighborhood = $company->neighborhood;
            $automotive->state = $company->state;
            $automotive->city = $company->city;
        }

        $automotive->setSaleAttribute(1);
        $automotive->setAirConditioningAttribute($request->air_conditioning);
        $automotive->setElectricGlassAttribute($request->electric_glass);
        $automotive->setEletricLockAttribute($request->eletric_lock);
        $automotive->setSoundAttribute($request->sound);

        if ($request->spotlight) {
            if (Auth::user()->hasRole('Anunciante')) {
                if (Auth::user()->ads_limit == 0) {
                    return redirect()->route('admin.automotives.edit', [
                        'automotive' => $automotive->id
                    ])->with(['color' => 'orange', 'message' => 'Cadastro não '
                        . 'realizado! Seu limite de anúncios foi excedido. Precisando de mais anúncios? Entre em contato com a nossa equipe!']);
                } else {
                    if ($automotiveOld->spotlight == 0) {
                        Auth::user()->reduceAdsLimit();
                    }
                    $automotive->setSpotlightAttribute($request->spotlight);
                }
            } else {
                $automotive->setSpotlightAttribute($request->spotlight);
            }
        } else {
            $automotive->setSpotlightAttribute($request->spotlight);
        }

        $automotive->setSlug();

        $automotive->save();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return redirect()->back()->withInput()->with(['color' => 'orange', 'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.']);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $automotiveImage = new AutomotiveImage();
                $automotiveImage->automotive = $automotive->id;
                $automotiveImage->path = $image->storeAs('automotives/' . $automotive->id, Str::slug($request->title) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $automotiveImage->save();
                unset($automotiveImage);
            }
        }

        return redirect()->route('admin.automotives.edit', [
            'automotive' => $automotive->id
        ])->with(['color' => 'green', 'message' => 'Veículo alterado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('Remover Veículos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $automotive = Automotive::where('id', $id)->first();
        if (Auth::user()->hasRole('Anunciante') && $automotive->user != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $automotive->delete();

        return redirect()->route('admin.automotives.index')->with(['color' => 'green', 'message' => 'Veículo removido com sucesso!']);
    }

    public function reactive($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Veículos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $automotive = Automotive::where('id', $id)->first();
        if (Auth::user()->hasRole('Anunciante') && $automotive->user != Auth::user()->id) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $automotive->active_date = date('Y-m-d');
        $automotive->save();

        if (Auth::user()->hasRole('Anunciante')) {
            Auth::user()->reduceAdsLimit();
        }

        return redirect()->route('admin.automotives.index')
            ->with(['color' => 'orange', 'message' => 'Veículo reativado com sucesso!']);
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = AutomotiveImage::where('id', $request->image)->first();
        $allImage = AutomotiveImage::where('automotive', $imageSetCover->automotive)->get();

        foreach ($allImage as $image) {
            $image->cover = null;
            $image->save();
        }

        $imageSetCover->cover = true;
        $imageSetCover->save();

        $json = [
            'success' => true
        ];

        return response()->json($json);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = AutomotiveImage::where('id', $request->image)->first();

        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();

        $json = [
            'success' => true
        ];
        return response()->json($json);
    }
}
