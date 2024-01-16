@extends('admin.master.master')

@section('content')
    <section class="dash_content_app">

        <header class="dash_content_app_header pb-1">
            <h2 class="icon-building-o">Nova Loja</h2>

            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                        <li class="icon-angle-right separator icon-notext"></li>
                        <li><a href="{{ route('admin.users.index') }}">Clientes</a></li>
                        <li class="icon-angle-right separator icon-notext"></li>
                        <li><a href="{{ route('admin.companies.index') }}">Lojas</a></li>
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
            <div class="dash_content_app_box_stage">
                <form class="app_form" action="{{ route('admin.companies.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @hasanyrole('Administrador|Gerente')
                        <label class="label">
                            <span class="legend">Responsável Legal:</span>
                            <select name="user" class="select2">
                                <option value="" selected>Selecione um responsável legal</option>
                                @foreach ($users as $user)
                                    @if (!empty($selected))
                                        <option value="{{ $user->id }}" {{ $user->id == $selected->id ? 'selected' : '' }}>
                                            {{ $user->name }}</option>
                                    @else
                                        <option value="{{ $user->id }}">{{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @if (!empty($selected->id))
                                <p style="margin-top: 4px;">
                                    <a href="" class="icon-link text-orange" style="font-size: .8em;"
                                        target="_blank">Acessar
                                        Cadastro</a>
                                </p>
                            @endif
                        </label>
                    @else
                        <input type="hidden" name="user" value="{{ Auth::user()->id }}">
                    @endhasanyrole

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Razão Social:</span>
                            <input type="text" name="social_name" placeholder="Razão Social"
                                value="{{ old('social_name') }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*CEP:</span>
                            <input type="tel" name="zipcode" class="mask-zipcode zip_code_search"
                                placeholder="Digite o CEP" value="{{ old('zipcode') }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Endereço:</span>
                            <input type="text" name="street" class="street" placeholder="Endereço Completo"
                                value="{{ old('street') }}" required />
                        </label>
                        <label class="label">
                            <span class="legend">*Número:</span>
                            <input type="text" name="number" placeholder="Número do Endereço"
                                value="{{ old('number') }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Bairro:</span>
                            <input type="text" name="neighborhood" class="neighborhood" placeholder="Bairro"
                                value="{{ old('neighborhood') }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*Cidade:</span>
                            <input type="text" name="city" class="city" placeholder="Cidade"
                                value="{{ old('city') }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">*Estado:</span>
                            <input type="text" name="state" class="state" placeholder="Estado"
                                value="{{ old('state') }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*E-mail:</span>
                            <input type="email" name="email" class="email" placeholder="E-mail da loja"
                                value="{{ old('email') }}" required />
                        </label>
                    </div>

                    <div class="label_g2">
                        <label class="label">
                            <span class="legend">Telefone Fixo:</span>
                            <input type="tel" name="telephone" class="mask-phone"
                                placeholder="Número do Telefonce com DDD" value="{{ old('telephone') }}" required />
                        </label>

                        <label class="label">
                            <span class="legend">*Celular:</span>
                            <input type="tel" name="cell" class="mask-cell"
                                placeholder="Número do Telefonce com DDD" value="{{ old('cell') }}" required />
                        </label>
                    </div>

                    <div class="label_g2">

                        <label class="label">
                            <span class="legend">*Link para a loja (sem espaços ou símbolos):</span>
                            <input type="text" name="slug" class="link" placeholder="Link"
                                value="{{ old('slug') }}" required />
                        </label>

                        {{-- <label class="label">
                            <span class="legend">Template</span>
                            <select name="template" class="select2">
                                <option value="" selected>Selecione um template</option>
                                <option value="Padrão" {{ old('template') == 'Padrão' ? 'selected' : '' }}>
                                    Padrão
                                </option>
                                <option value="Alfa" {{ old('template') == 'Alfa' ? 'selected' : '' }}>
                                    Alfa
                                </option>
                            </select>
                        </label> --}}
                    </div>

                    <div class="label_g3">
                        <label class="label">
                            <span class="legend">Logo simples medindo 340 píxels.</span>
                            <input type="file" name="cover">
                        </label>

                    </div>

                    <div class="text-right">
                        <button class="icon-check-square-o btn btn-large btn-green" type="submit">Criar Loja</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
