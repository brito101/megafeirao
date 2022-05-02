<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use LaraCar\Term;

class TermController extends Controller
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

        $term = Term::first();

        return view('admin.term', ['term' => $term]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $term = Term::create($request->all());
        return redirect()->route('admin.term.index')
            ->with(['color' => 'orange', 'message' => 'Termos de uso criado com sucesso!']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $term = Term::first();
        $term->description = $request['description'];
        $term->save();
        return redirect()->route('admin.term.index')
            ->with(['color' => 'orange', 'message' => 'Termos de uso atualizados com sucesso!']);
    }
}
