<?php

/** Página inicial */

use Illuminate\Support\Facades\Route;

Route::get('/', 'Web\\WebController@filter')->name('web.home');
// Route::get('/', 'Web\\WebController@home')->name('web.home');

/** Página Destaque */
Route::get('/destaque', 'Web\\WebController@spotlight')->name('web.spotlight');

/** Página de Registro */
Route::get('/cadastro', 'Web\\WebController@register')->name('web.register');

/** Página de lojas */
Route::get('/lojas', 'Web\\WebController@companies')->name('web.companies');

/** Página de compra */
Route::get('/quero-comprar', 'Web\\WebController@buy')->name('web.buy');

/** Página de compra específica de um veículo  */
Route::get('/quero-comprar/{slug}', 'Web\\WebController@buyAutomotive')->name('web.buyAutomotive');

/** Página de filtro */
Route::match(['post', 'get'], '/filtro', 'Web\\WebController@filter')->name('web.filter');
Route::get('/filtro-marca/{brand}', 'Web\\WebController@filterBrand')->name('web.filterBrand');
Route::get('/filtro-modelo/{model}', 'Web\\WebController@filterModel')->name('web.filterModel');

/** Página de contato */
Route::get('/contato', 'Web\\WebController@contact')->name('web.contact');
Route::post('/contato/sendEmail', 'Web\\WebController@sendEmail')->name('web.sendEmail');
Route::get('/contato/sucesso', 'Web\\WebController@sendEmailSuccess')->name('web.sendEmailSuccess');

/** Página de Política de Privacidade */
Route::get('/politica-de-privacidade', 'Web\\WebController@policy')->name('web.policy');

/** Filtro */
Route::post('main-filter/search', 'Web\\FilterController@search')->name('component.main-filter.search');
Route::post('main-filter/category', 'Web\\FilterController@category')->name('component.main-filter.category');
Route::post('main-filter/city', 'Web\\FilterController@city')->name('component.main-filter.city');
Route::post('main-filter/brand', 'Web\\FilterController@brand')->name('component.main-filter.brand');
Route::post('main-filter/model', 'Web\\FilterController@model')->name('component.main-filter.model');
Route::post('main-filter/year-base', 'Web\\FilterController@yearBase')->name('component.main-filter.yearBase');
Route::post('main-filter/year-limit', 'Web\\FilterController@yearLimit')->name('component.main-filter.yearLimit');
Route::post('main-filter/price-base', 'Web\\FilterController@priceBase')->name('component.main-filter.priceBase');
Route::post('main-filter/price-limit', 'Web\\FilterController@priceLimit')->name('component.main-filter.priceLimit');
Route::post('main-filter/mileage', 'Web\\FilterController@mileage')->name('component.main-filter.mileage');
Route::post('main-filter/gear', 'Web\\FilterController@gear')->name('component.main-filter.gear');
Route::post('main-filter/fuel', 'Web\\FilterController@fuel')->name('component.main-filter.fuel');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {

    /** Formulário de Login */
    Route::get('/', 'AuthController@showLoginForm')->name('login');
    Route::post('login', 'AuthController@login')->name('login.do');

    /** Formulário de Criação de Conta */
    Route::get('new-account', 'AuthController@newAccount')->name('account');
    Route::post('create-account', 'AuthController@createAccount')->name('account.do');

    /** Recuperação Conta */
    Route::get('forgotten-account', 'AuthController@forgotten')->name('forgotten');
    Route::post('forgotten-account', 'AuthController@forgottenAccount')->name('forgotten.do');
    Route::get('reset-account/{token?}', 'AuthController@resetAccount')->name('reset');
    Route::post('reset-account', 'AuthController@resetPassword')->name('reset.do');

    /** Rotas Protegidas */
    Route::group(['middleware' => ['auth']], function () {

        /** Dashboard Home */
        Route::get('home', 'AuthController@home')->name('home');

        /** Usuários */
        Route::get('users/team', 'UserController@team')->name('users.team');
        Route::post('users/message', 'UserController@message')->name('users.message');
        Route::resource('users', 'UserController');

        /** Permissões */
        Route::resource('permission', 'ACL\\PermissionController');

        /** Perfis */
        Route::get('role/{role}/permissions', 'ACL\\RoleController@permissions')->name('role.permissions');
        Route::put('role/{role}/permission/sync', 'ACL\\RoleController@permissionsSync')->name('role.permissionsSync');
        Route::resource('role', 'ACL\\RoleController');

        /** Empresas */
        Route::resource('companies', 'CompanyController');

        /** Automóveis */
        Route::post('automotives/image-set-cover', 'AutomotiveController@imageSetCover')->name('automotives.imageSetCover');
        Route::delete('automotives/image-remove', 'AutomotiveController@imageRemove')->name('automotives.imageRemove');
        Route::post('automotives/reactive/{automotive}', 'AutomotiveController@reactive')->name('automotives.reactive');
        Route::resource('automotives', 'AutomotiveController');
        Route::post('automotives/reannounce', 'AutomotiveController@reannounce')->name('automotive.reannounce');

        /** Contratos */
        Route::post('contracts/get-data-owner', 'ContractController@getDataOwner')->name('contracts.getDataOwner');
        Route::post('contracts/get-data-acquirer', 'ContractController@getDataAcquirer')->name('contracts.getDataAcquirer');
        Route::post('contracts/get-data-property', 'ContractController@getDataProperty')->name('contracts.getDataProperty');
        Route::resource('contracts', 'ContractController');

        /** Créditos */
        // Route::get('banner', 'PaymentController@banner')->name('banner');
        Route::get('payment', 'PaymentController@payment')->name('payment');
        Route::get('contact', 'PaymentController@contact')->name('contact');
        Route::post('sendContact', 'PaymentController@sendContact')->name('sendContact');

        /** Termos */
        Route::resource('term', 'TermController');

        /** Banner */
        Route::resource('banner', 'BannerController');

        /** Client Banner */
        Route::resource('client-banner', 'ClientBannerController');

        /**Configurações */
        Route::resource('config', 'ConfigController');
    });

    /** Rota de logout */
    Route::get('logout', 'AuthController@logout')->name('logout');
});


/** Página de uma loja específica  */
Route::get('/{slug}', 'Web\\WebController@filterCompany')->name('web.filterCompany');
Route::get('/veiculos/{slug}', 'Web\\WebController@filterCompanyAutomotive')->name('web.filterCompanyAutomotive');
Route::post('/veiculos/{slug}', 'Web\\WebController@filterCompanyAutomotiveSearch')->name('web.filterCompanyAutomotiveSearch');
Route::get('/localizacao/{slug}', 'Web\\WebController@filterCompanyLocation')->name('web.filterCompanyLocation');
Route::get('/contato/{slug}', 'Web\\WebController@filterCompanyContact')->name('web.filterCompanyContact');
