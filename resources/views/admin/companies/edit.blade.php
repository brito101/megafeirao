@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-building-o">Editar Anunciante</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="icon-angle-right separator icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                        <li class="icon-angle-right separator icon-notext"></li>
                        <li><a href="{{ route('admin.companies.index') }}">Anunciante</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        @if ($errors->all())
            @foreach ($errors->all() as $error)
                @message(['color' => 'orange'])
                    <p class="icon-asterisk">{{ $error }}</p>
                @endmessage
            @endforeach
        @endif

        @if (session()->exists('message'))
            @message(['color' => session()->get('color')])
                <p class="icon-asterisk">{{ session()->get('message') }}</p>
            @endmessage
        @endif

        <div class="dash_content_app_box">

            @hasanyrole('Anunciante')
                <div class="bg-orange px-1 my-1" style="color: #fff; line-height: 40px; font-weight: bold;">
                    <span class="legend">Você é</span>
                    <label class="label" style="cursor: pointer;">
                        <input type="radio" name="type_company" style="cursor: pointer;" value="particular"
                            {{ $company->type == 'particular' ? 'checked' : '' }}>
                        <span>particular</span>
                    </label>
                    <span>ou</span>
                    <label class="label" style="cursor: pointer;">
                        <input type="radio" name="type_company" style="cursor: pointer;" value="concessionaria"
                            {{ $company->type == 'concessionaria' ? 'checked' : '' }}>
                        <span>concessionária?</span>
                    </label>
                    </span>
                </div>
            @endhasanyrole

            <div class="dash_content_app_box_stage">
                <form class="app_form" action="{{ route('admin.companies.update', ['company' => $company]) }}"
                    method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="type" id="type" value="{{ old('type') ?? $company->type }}">
                    @hasanyrole('Administrador|Gerente')
                        <label class="label">
                            <span class="legend">Responsável Legal:</span>
                            <select name="user" class="select2">
                                <option value="" selected>Selecione um responsável legal</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $user->id == $company->user ? 'selected' : '' }}>
                                        {{ $user->name }}</option>
                                @endforeach
                            </select>
                            <p style="margin-top: 4px;">
                                <a href="{{ route('admin.users.edit', ['user' => $company->user]) }}"
                                    class="icon-link text-orange" style="font-size: .8em;" target="_blank">Acessar
                                    Cadastro</a>
                            </p>
                        </label>
                    @else
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                    @endhasanyrole

                    <div class="label_g2 concessionaria">
                        <label class="label">
                            <span class="legend">*Razão Social:</span>
                            <input type="text" name="social_name" placeholder="Razão Social"
                                value="{{ old('social_name') ?? $company->social_name }}" />
                        </label>
                        <label class="label">
                            <span class="legend">*CEP:</span>
                            <input type="tel" name="zipcode" class="mask-zipcode zip_code_search"
                                placeholder="Digite o CEP" value="{{ old('zipcode') ?? $company->zipcode }}" />
                        </label>
                    </div>


                    <div class="label_g2">

                        <label class="label">
                            <span class="legend">*Cidade:</span>
                            <input type="text" name="city" class="city" placeholder="Cidade"
                                value="{{ old('city') ?? $company->city }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*Estado:</span>
                            <input type="text" name="state" class="state" placeholder="Estado"
                                value="{{ old('state') ?? $company->state }}" required />
                        </label>

                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*E-mail:</span>
                            <input type="email" name="email" class="email" placeholder="E-mail da loja"
                                value="{{ old('email') ?? $company->email }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*Whatsapp:</span>
                            <input type="tel" name="cell" class="mask-cell" placeholder="Número do Whatsapp com DDD"
                                value="{{ old('cell') ?? $company->cell }}" required />
                        </label>
                    </div>

                    <div class="label_g2 concessionaria">
                        <label class="label">
                            <span class="legend">*Escolha o endereço para a loja grátis (sem espaços ou símbolos):</span>
                            <input type="text" name="slug" class="link" placeholder="Link"
                                value="{{ old('slug') ?? $company->slug }}" />
                        </label>

                    </div>

                    <div class="text-right">
                        <button class="icon-check-square-o btn btn-large btn-green" type="submit">Editar
                            Anunciante</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@hasanyrole('Anunciante')
    @section('js')
        <script>
            @if ($company->type == 'particular')
                $(".concessionaria").hide();
                $("#type").val('particular')
            @endif

            $('input[type=radio][name=type_company]').on('change', function() {
                switch ($(this).val()) {
                    case 'particular':
                        $(".concessionaria").hide();
                        $("#type").val('particular')
                        break;
                    case 'concessionaria':
                        $(".concessionaria").show();
                        $("#type").val('concessionaria')
                        break;
                }
            });
        </script>
    @endsection
@endhasanyrole
