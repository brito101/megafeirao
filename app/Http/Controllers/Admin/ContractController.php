<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use LaraCar\Contract;
use LaraCar\User;
use LaraCar\Automotive;
use LaraCar\Http\Requests\Admin\Contract as ContractRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class ContractController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (!Auth::user()->hasPermissionTo('Listar Contratos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $contracts = Contract::with(['ownerObject', 'acquirerObject'])->orderBy('id', 'DESC')->get();
        return view('admin.contracts.index', [
            'contracts' => $contracts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (!Auth::user()->hasPermissionTo('Cadastrar Contratos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $buyers = User::buyers();
        $sellers = User::sellers();
        return view('admin.contracts.create', [
            'buyers' => $buyers,
            'sellers' => $sellers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request) {
        if (!Auth::user()->hasPermissionTo('Cadastrar Contratos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $contractCreate = Contract::create($request->all());

        return redirect()->route('admin.contracts.edit', [
                    'contract' => $contractCreate->id
                ])->with(['color' => 'green', 'message' => 'Contrato cadastrado com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        if (!Auth::user()->hasPermissionTo('Editar Contratos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $contract = Contract::where('id', $id)->first();
        if (empty($contract->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $buyers = User::buyers();
        $sellers = User::sellers();

        return view('admin.contracts.edit', [
            'contract' => $contract,
            'buyers' => $buyers,
            'sellers' => $sellers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, $id) {
        if (!Auth::user()->hasPermissionTo('Editar Contratos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        $contract = Contract::where('id', $id)->first();
        $contract->fill($request->all());
        $contract->save();

        if ($request->automotive) {
            $automotive = Automotive::where('id', $request->automotive)->first();

            if ($request->status === 'active') {
                $automotive->status = 0;
                $automotive->save();
            } else {
                $automotive->status = 1;
                $automotive->save();
            }
        }

        return redirect()->route('admin.contracts.edit', [
                    'contract' => $contract->id
                ])->with(['color' => 'green', 'message' => 'Contrato editado com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (!Auth::user()->hasPermissionTo('Remover Contratos')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $contract = Contract::where('id', $id)->first();
        $contract->delete();

        return redirect()->route('admin.contracts.index')->with(['color' => 'orange', 'message' => 'Contrato removido com sucesso!']);
    }

    public function getDataOwner(Request $request) {
        $seller = User::where('id', $request->user)->first([
            'id',
            'civil_status',
            'spouse_name',
            'spouse_document',
        ]);

        if (empty($seller)) {
            $spouse = null;
            $companies = null;
            $properties = null;
        } else {
            $civilStatusSpouseRequired = [
                'married',
                'separated',
            ];

            if (in_array($seller->civil_status, $civilStatusSpouseRequired)) {
                $spouse = [
                    'spouse_name' => $seller->spouse_name,
                    'spouse_document' => $seller->spouse_document,
                ];
            } else {
                $spouse = null;
            }

            $companies = $seller->companies()->get([
                'id',
                'alias_name',
                'document_company'
            ]);

            $getProperties = $seller->automotives()->get();

            $property = [];
            foreach ($getProperties as $property) {
                $properties[] = [
                    'id' => $property->id,
                    'description' => '#' . $property->id . ': ' . $property->category . ', ' .
                    $property->type . ' em ' . $property->city . ' '
                ];
            }
        }

        $json['spouse'] = $spouse;
        $json['companies'] = (!empty($companies) && $companies->count() ? $companies : null);
        $json['properties'] = (!empty($properties) ? $properties : null);

        return response()->json($json);
    }

    public function getDataAcquirer(Request $request) {
        $buyer = User::where('id', $request->user)->first([
            'id',
            'civil_status',
            'spouse_name',
            'spouse_document',
        ]);

        if (empty($buyer)) {
            $spouse = null;
            $companies = null;
        } else {
            $civilStatusSpouseRequired = [
                'married',
                'separated',
            ];

            if (in_array($buyer->civil_status, $civilStatusSpouseRequired)) {
                $spouse = [
                    'spouse_name' => $buyer->spouse_name,
                    'spouse_document' => $buyer->spouse_document,
                ];
            } else {
                $spouse = null;
            }

            $companies = $buyer->companies()->get([
                'id',
                'alias_name',
                'document_company'
            ]);
        }

        $json['spouse'] = $spouse;
        $json['companies'] = (!empty($companies) && $companies->count() ? $companies : null);

        return response()->json($json);
    }

    public function getDataProperty(Request $request) {
        $property = Automotive::where('id', $request->property)->first();

        if (empty($property)) {
            $property = null;
        } else {
            $property = [
                'id' => $property->id,
                'sale_price' => $property->sale_price,
                'rent_price' => $property->rent_price,
                'tribute' => $property->tribute
            ];
        }

        $json['property'] = $property;
        return response()->json($json);
    }

}
