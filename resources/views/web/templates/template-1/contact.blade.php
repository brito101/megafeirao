@extends('web.templates.template-1.master')

@section('content')
    <div class="utility-bar noMobile">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-8">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('web.filterCompany', ['slug' => $company->slug]) }}">Home</a></li>
                        <li class="active">Contato</li>
                    </ol>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-4">
                </div>
            </div>
        </div>
    </div>

    <div class="main" role="main">
        <div id="content" class="content full">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="listing-header margin-40">
                            <span><strong>Contatos</strong></span>
                        </div>
                        <div class="boxEndereco">
                            <div class="titleEndereco">
                                <b><i class="fa fa-map-marker" style="margin-right: 5px"></i>Endereço</b><br>
                            </div>
                            {{ $company->street }}, {{ $company->number }}, {{ $company->neighborhood }},
                            {{ $company->city }}-{{ $company->state }}. CEP:
                            {{ $company->zipcode }}<br><br>
                            <div class="titleEndereco">
                                <i class="fa fa-phone" style="margin-right: 5px"></i><b>Telefone</b><br>
                            </div>
                            {{ $company->telephone }}<br>
                            {{ $company->cell }}<br>
                            <br>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="listing-header margin-40">
                            <span>Fale <strong>Conosco</strong></span>
                        </div>
                        <form action="{{ route('web.sendEmail') }}" method="post" style="max-width: 800px"
                            class="w-100">
                            @csrf
                            <input type="hidden" name="company" value="{{ $company->id }}">
                            <div class="form-group">
                                <input type="text" name="name" class="form-control" placeholder="Nome" required>
                            </div>

                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="E-mail" required>
                            </div>

                            <div class="form-group">
                                <textarea name="message" rows="5" class="form-control" placeholder="Mensagem" required></textarea>
                            </div>

                            <div class="form-group text-right">
                                <button class="btn btn-success">Enviar</button>
                            </div>
                        </form>
                        <div class="clearfix"></div>
                        <div id="message"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
