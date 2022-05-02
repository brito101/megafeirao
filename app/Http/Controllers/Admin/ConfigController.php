<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LaraCar\Config;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasAnyRole(['Administrador', 'Gerente'])) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $config = Config::first();

        return view('admin.config.index', ['config' => $config]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $config = Config::create($request->all());
        return redirect()->route('admin.config.index')
            ->with(['color' => 'orange', 'message' => 'Configuração criada com sucesso!']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'initial_ads' => 'integer'
        ]);

        $config = Config::first();
        $config->initial_ads = $request['initial_ads'];
        $config->save();
        return redirect()->route('admin.config.index')
            ->with(['color' => 'orange', 'message' => 'Configurações atualizadas com sucesso!']);
    }
}
