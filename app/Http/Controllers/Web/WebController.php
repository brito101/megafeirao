<?php

namespace LaraCar\Http\Controllers\Web;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use LaraCar\Automotive;
use LaraCar\Mail\Web\Contact;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use LaraCar\Company;
use Illuminate\Support\Facades\Storage;
use LaraCar\Banner;
use LaraCar\ClientBanner;
use LaraCar\Term;
use LaraCar\User;

class WebController extends Controller
{

    public function home(Request $request)
    {
        $head = $this->seo->render(
            env('APP_NAME'),
            'Encontre o veículo dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.filter'),
            asset('frontend/assets/images/share.png')
        );

        $filter = new FilterController();

        $itemAutomotives = $filter->createQuery('id');
        foreach ($itemAutomotives as $automotive) {
            $automotives[] = $automotive->id;
        }

        if (!empty($automotives)) {
            $automotives = Automotive::whereIn('id', $automotives)->sale()->available()->inRandomOrder()->get();
            $automotivesPaginate = Automotive::whereIn('id', $automotives->pluck('id'))->sale()->available()->inRandomOrder()->paginate(12);
        } else {
            $automotives = null;
            $automotivesPaginate = null;
        }

        $filter->clearAllData();

        $collect = Automotive::sale()->available()->get();
        $cities = [];
        if ($collect->count()) {
            foreach ($collect as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        $state = [];
        $cityCar = [];
        $mileageCar = [];

        if (count($collect) > 0) {
            foreach ($collect as $automotive) {
                $state[] = $automotive->state;
                $cityCar[] = $automotive->city;
                $mileageCar[] = floatVal($automotive->mileage);
            }

            $state = collect(array_filter($state))->unique()->sort();
            $cityCar = collect(array_filter($cityCar))->unique()->sort();
            $mileageCar = collect(array_filter($mileageCar))->unique()->sort()->max();
        }

        $cityState = [];

        foreach ($collect as $automotive) {
            if ($automotive->city && $automotive->state) {
                $cityState[] = $automotive->city . '-' . $automotive->state;
            }
        }
        $cityState = collect(array_filter($cityState))->unique()->sort();

        return view('web.home', [
            'head' => $head,
            'automotives' => $automotivesPaginate,
            'cities' => $cities,
            'banner' => $banner,
            'state' => $state,
            'cityState' => $cityState,
            'collect' => $collect,
            'mileageMax' => $mileageCar,
        ]);
    }

    public function companies()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Lojas',
            'Confira as lojas na melhor plataforma web do Rio de Janeiro',
            route('web.companies'),
            asset('frontend/assets/images/share.png')
        );
        $companies = Company::orderBy('alias_name')->get();
        return view('web.companies', [
            'head' => $head,
            'companies' => $companies
        ]);
    }

    public function filterCompany(Request $request)
    {
        $company = Company::where('slug', $request->slug)->first();

        if ($company) {
            $head = $this->seo->render(
                env('APP_NAME') . ' - Loja: ' . $company->social_name ?? 'Particular',
                $company->social_name ?? 'Particular',
                route('web.filterCompany', ['slug' => $company->slug]),
                $company->cover()
            );

            $automotivesForSale = Automotive::sale()->available()->where('user', $company->user)->orderBy('created_at', 'desc')->get();

            $fullList = Automotive::sale()->available()->where('user', $company->user)->get();

            return view('web.templates.template-1.company', [
                'head' => $head,
                'company' => $company,
                'automotivesForSale' => $automotivesForSale,
            ]);
        } else {
            return redirect()->route('web.companies');
        }
    }

    public function filterCompanyAutomotive(Request $request)
    {
        $company = Company::where('slug', $request->slug)->first();
        if ($company) {
            $head = $this->seo->render(
                env('APP_NAME') . ' - Loja: ' . ($company->social_name ?? 'Particular') . ' - Veículos',
                $company->social_name ?? 'Particular',
                route('web.filterCompanyAutomotive', ['slug' => $company->slug]),
                $company->cover()
            );

            $automotivesForSale = Automotive::sale()->available()->where('user', $company->user)->orderBy('created_at', 'desc')->get();

            if ($company->template == 'Alfa') {
                return view('web.templates.template-1.list', [
                    'head' => $head,
                    'company' => $company,
                    'automotivesForSale' => $automotivesForSale
                ]);
            } else {
                return redirect()->route('web.filterCompany', ['slug' => $company->slug]);
            }
        } else {
            return redirect()->route('web.companies');
        }
    }

    public function filterCompanyAutomotiveSearch(Request $request)
    {
        $company = Company::where('slug', $request->slug)->first();
        if ($company) {
            $head = $this->seo->render(
                env('APP_NAME') . ' - Loja: ' . ($company->social_name ?? 'Particular') . ' - Veículos',
                $company->social_name ?? 'Particular',
                route('web.filterCompanyAutomotive', ['slug' => $company->slug]),
                $company->cover()
            );

            $automotivesForSale = Automotive::sale()->available()
                ->where('user', $company->user)
                ->when($request->brand, function ($query, $brand) {
                    return $query->where('brand', $brand);
                })
                ->when($request->model, function ($query, $model) {
                    return $query->where('model', $model);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            if ($company->template == 'Alfa') {
                return view('web.templates.template-1.list', [
                    'head' => $head,
                    'company' => $company,
                    'automotivesForSale' => $automotivesForSale
                ]);
            } else {
                return redirect()->route('web.filterCompany', ['slug' => $company->slug]);
            }
        } else {
            return redirect()->route('web.companies');
        }
    }

    public function filterCompanyLocation(Request $request)
    {
        $company = Company::where('slug', $request->slug)->first();
        if ($company) {
            $head = $this->seo->render(
                env('APP_NAME') . ' - Loja: ' . ($company->social_name ?? 'Particular') . ' - Localização',
                $company->social_name ?? 'Particular',
                route('web.filterCompanyLocation', ['slug' => $company->slug]),
                $company->cover()
            );

            if ($company->template == 'Alfa') {
                return view('web.templates.template-1.location', [
                    'head' => $head,
                    'company' => $company
                ]);
            } else {
                return redirect()->route('web.filterCompany', ['slug' => $company->slug]);
            }
        } else {
            return redirect()->route('web.companies');
        }
    }

    public function filterCompanyContact(Request $request)
    {
        $company = Company::where('slug', $request->slug)->first();
        if ($company) {
            $head = $this->seo->render(
                env('APP_NAME') . ' - Loja: ' . ($company->social_name ?? 'Particular') . ' - Contato',
                $company->social_name ?? 'Particular',
                route('web.filterCompanyContact', ['slug' => $company->slug]),
                $company->cover()
            );
            if ($company->template == 'Alfa') {
                return view('web.templates.template-1.contact', [
                    'head' => $head,
                    'company' => $company
                ]);
            } else {
                return redirect()->route('web.filterCompany', ['slug' => $company->slug]);
            }
        } else {
            return redirect()->route('web.companies');
        }
    }

    public function spotlight()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Destaque',
            'Confira nosso veículo de destaque na melhor plataforma web do Rio de Janeiro',
            route('web.spotlight'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.spotlight', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent
        ]);
    }

    public function contact()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Contato',
            'Quer conversar com um corretor exclusivo e ter o atendimento diferenciado em busca do seu veículo dos sonhos? Entre em contato com a nossa equipe!',
            route('web.contact'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.contact', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent
        ]);
    }

    public function buy()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Compra',
            'Compre o veículo dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.buy'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        $filter = new FilterController();
        $filter->clearAllData();
        $automotives = Automotive::sale()->available()->sortable(['created_at' => 'desc'])->paginate(20);

        session()->remove('user');
        session()->remove('city');
        session()->remove('brand');
        session()->remove('model');
        session()->remove('year');
        session()->remove('mileage');
        session()->remove('price_base');
        session()->remove('price_limit');

        $cities = [];
        if ($automotives->count()) {
            foreach ($automotives as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        return view('web.filter', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
            'automotives' => $automotives,
            'type' => 'sale',
            'cities' => $cities,
            'banner' => $banner
        ]);
    }

    public function buyAutomotive(Request $request)
    {

        $automotive = Automotive::where('slug', $request->slug)->first();
        if ($automotive) {
            $automotive->views = $automotive->views + 1;
            $automotive->save();
            $head = $this->seo->render(
                ($automotive->headline ?? $automotive->title) . ' - R$ ' . ($automotive->sale_price ?? $automotive->rent_price),
                $automotive->city . '-' . $automotive->state,
                // env('APP_NAME') . ' - Compra',
                // $automotive->headline ?? $automotive->title,
                route('web.buyAutomotive', ['slug' => $automotive->slug]),
                $automotive->cover()
            );
            $forSale = Automotive::sale()->available()->first();
            $forRent = Automotive::rent()->available()->first();
            $company = Company::where('user', $automotive->ownerObject()->id)->first();
            $banner = Banner::first();
            return view('web.automotive', [
                'head' => $head,
                'forSale' => $forSale,
                'forRent' => $forRent,
                'automotive' => $automotive,
                'type' => 'sale',
                'company' => $company,
                'banner' => $banner
            ]);
        } else {
            return redirect()->route('web.filter');
        }
    }

    public function filterBrand($brand)
    {
        $head = $this->seo->render(
            env('APP_NAME'),
            'Encontre o veículo dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.filter'),
            asset('frontend/assets/images/share.png')
        );

        $brands = Automotive::pluck('brand')->toArray();
        $brandsFilter = [];
        foreach ($brands as $b) {
            if (Str::slug($b) == $brand) {
                $brandsFilter[] = $b;
            }
        }

        $automotives = Automotive::whereIn('brand', $brandsFilter)->sale()->available()->inRandomOrder()->paginate();

        $collect = Automotive::sale()->available()->get();
        $cities = [];
        if ($collect->count()) {
            foreach ($collect as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        $spotlight = Automotive::sale()->available()->spotlight()->inRandomOrder()->take(12)->get();

        $state = [];
        $brand = [];
        $model = [];
        $cityCar = [];
        $mileageCar = [];

        if (!empty($collect)) {

            foreach ($collect as $automotive) {
                $state[] = $automotive->state;
                $cityCar[] = $automotive->city;
                $brand[] = ['title' => $automotive->brand, 'link' => Str::slug($automotive->brand)];
                $model[] = ['title' => $automotive->model, 'link' => Str::slug($automotive->model)];
                $mileageCar[] = floatVal($automotive->mileage);
            }
            $state = collect(array_filter($state))->unique()->sort();
            $brand = collect(array_filter($brand))->unique()->sort();
            $model = collect(array_filter($model))->unique()->sort();
            $cityCar = collect(array_filter($cityCar))->unique()->sort();
            $mileageCar = collect(array_filter($mileageCar))->unique()->sort()->max();
        }

        $cityState = [];
        if (count($state) && count($cityCar)) {
            foreach ($collect as $automotive) {
                if ($state->contains($automotive->state) && !$cityCar->contains($automotive->city)) {
                    $cityState[] = $automotive->city;
                }
            }
            $cityState = collect(array_filter($cityState))->unique()->sort();
        }

        $users = User::where('banner_views_limit', '>', 0)->get();
        $clientBanner = ClientBanner::whereIn('user', $users->pluck('id'))->inRandomOrder()->first();
        if ($clientBanner) {
            $clientBanner->views = $clientBanner->views + 1;
            $clientBanner->update();
            $userBanner = User::where('id', $clientBanner->user)->first();
            if ($userBanner) {
                $userBanner->banner_views_limit = $userBanner->banner_views_limit - 1;
                $userBanner->update();
            }
        }

        return view('web.filter', [
            'head' => $head,
            'automotives' => $automotives,
            'cities' => $cities,
            'banner' => $banner,
            'spotlight' => $spotlight,
            'brand' => $brand,
            'model' => $model,
            'state' => $state,
            'cityState' => $cityState,
            'collect' => $collect,
            'mileageMax' => $mileageCar,
            'clientBanner' => $clientBanner
        ]);
    }

    public function filterModel($model)
    {
        $head = $this->seo->render(
            env('APP_NAME'),
            'Encontre o veículo dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.filter'),
            asset('frontend/assets/images/share.png')
        );

        $models = Automotive::pluck('model')->toArray();

        $modelsFilter = [];
        foreach ($models as $m) {
            if (Str::slug($m) == $model) {
                $modelsFilter[] = $m;
            }
        }

        $automotives = Automotive::whereIn('model', $modelsFilter)->sale()->available()->inRandomOrder()->paginate();

        $collect = Automotive::sale()->available()->get();
        $cities = [];
        if ($collect->count()) {
            foreach ($collect as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        $spotlight = Automotive::sale()->available()->spotlight()->inRandomOrder()->take(12)->get();

        $state = [];
        $brand = [];
        $model = [];
        $cityCar = [];
        $mileageCar = [];

        if (!empty($collect)) {

            foreach ($collect as $automotive) {
                $state[] = $automotive->state;
                $cityCar[] = $automotive->city;
                $brand[] = ['title' => $automotive->brand, 'link' => Str::slug($automotive->brand)];
                $model[] = ['title' => $automotive->model, 'link' => Str::slug($automotive->model)];
                $mileageCar[] = floatVal($automotive->mileage);
            }
            $state = collect(array_filter($state))->unique()->sort();
            $brand = collect(array_filter($brand))->unique()->sort();
            $model = collect(array_filter($model))->unique()->sort();
            $cityCar = collect(array_filter($cityCar))->unique()->sort();
            $mileageCar = collect(array_filter($mileageCar))->unique()->sort()->max();
        }

        $cityState = [];
        if (count($state) && count($cityCar)) {
            foreach ($collect as $automotive) {
                if ($state->contains($automotive->state) && !$cityCar->contains($automotive->city)) {
                    $cityState[] = $automotive->city;
                }
            }
            $cityState = collect(array_filter($cityState))->unique()->sort();
        }

        $users = User::where('banner_views_limit', '>', 0)->get();
        $clientBanner = ClientBanner::whereIn('user', $users->pluck('id'))->inRandomOrder()->first();
        if ($clientBanner) {
            $clientBanner->views = $clientBanner->views + 1;
            $clientBanner->update();
            $userBanner = User::where('id', $clientBanner->user)->first();
            if ($userBanner) {
                $userBanner->banner_views_limit = $userBanner->banner_views_limit - 1;
                $userBanner->update();
            }
        }

        return view('web.filter', [
            'head' => $head,
            'automotives' => $automotives,
            'cities' => $cities,
            'banner' => $banner,
            'spotlight' => $spotlight,
            'brand' => $brand,
            'model' => $model,
            'state' => $state,
            'cityState' => $cityState,
            'collect' => $collect,
            'mileageMax' => $mileageCar,
            'clientBanner' => $clientBanner
        ]);
    }

    public function filterCity($request)
    {

        $head = $this->seo->render(
            env('APP_NAME'),
            'Encontre o veículo dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.filter'),
            asset('frontend/assets/images/share.png')
        );

        $filter = new FilterController();
        $itemAutomotives = $filter->createQuery('id');
        foreach ($itemAutomotives as $automotive) {
            $automotives[] = $automotive->id;
        }

        $cityRequest = explode('-', $request)[0];
        $stateRequest = explode('-', $request)[1];

        if (!empty($automotives)) {
            $automotives = Automotive::whereIn('id', $automotives)
                ->where('city', $cityRequest)->where('state', $stateRequest)
                ->sale()->available()->inRandomOrder()->get();
            $automotivesPaginate = Automotive::whereIn('id', $automotives->pluck('id'))
                ->where('city', $cityRequest)->where('state', $stateRequest)
                ->sale()->available()->inRandomOrder()->paginate(36);
        } else {
            $automotives = null;
            $automotivesPaginate = null;
        }

        $filter->clearAllData();

        $collect = Automotive::sale()->available()->get();
        $cities = [];
        if ($collect->count()) {
            foreach ($collect as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        $spotlight = Automotive::sale()->available()->spotlight()->inRandomOrder()->take(12)->get();

        // $brand = [];
        // $model = [];
        $state = [];
        $cityCar = [];
        $mileageCar = [];

        if (count($collect) > 0) {
            foreach ($collect as $automotive) {
                $state[] = $automotive->state;
                $cityCar[] = $automotive->city;
                // $brand[] = ['title' => $automotive->brand, 'link' => Str::slug($automotive->brand)];
                // $model[] = ['title' => $automotive->model, 'link' => Str::slug($automotive->model)];
                $mileageCar[] = floatVal($automotive->mileage);
            }

            $state = collect(array_filter($state))->unique()->sort();
            // $brand = collect(array_filter($brand))->unique()->sort();
            // $model = collect(array_filter($model))->unique()->sort();
            $cityCar = collect(array_filter($cityCar))->unique()->sort();
            $mileageCar = collect(array_filter($mileageCar))->unique()->sort()->max();
        }

        $cityState = [];
        // if (count($state) && count($cityCar)) {
        //     foreach ($collect as $automotive) {
        //         if ($state->contains($automotive->state) && !$cityCar->contains($automotive->city)) {
        //             $cityState[] = $automotive->city;
        //         }
        //     }
        //     $cityState = collect(array_filter($cityState))->unique()->sort();
        // }

        foreach ($collect as $automotive) {
            if ($automotive->city && $automotive->state) {
                $cityState[] = $automotive->city . '-' . $automotive->state;
            }
        }
        $cityState = collect(array_filter($cityState))->unique()->sort();


        $users = User::where('banner_views_limit', '>', 0)->get();
        $clientBanner = ClientBanner::whereIn('user', $users->pluck('id'))->inRandomOrder()->first();
        if ($clientBanner) {
            $clientBanner->views = $clientBanner->views + 1;
            $clientBanner->update();
            $userBanner = User::where('id', $clientBanner->user)->first();
            if ($userBanner) {
                $userBanner->banner_views_limit = $userBanner->banner_views_limit - 1;
                $userBanner->update();
            }
        }

        return view('web.filter', [
            'head' => $head,
            'automotives' => $automotivesPaginate,
            'cities' => $cities,
            'banner' => $banner,
            'spotlight' => $spotlight,
            // 'brand' => $brand,
            // 'model' => $model,
            'state' => $state,
            'cityState' => $cityState,
            'collect' => $collect,
            'mileageMax' => $mileageCar,
            'clientBanner' => $clientBanner,
        ]);
    }

    public function filterOrder($type, $order)
    {


        $head = $this->seo->render(
            env('APP_NAME'),
            'Encontre o veículo dos seus sonhos na melhor plataforma web do Rio de Janeiro',
            route('web.filter'),
            asset('frontend/assets/images/share.png')
        );

        $filter = new FilterController();
        $itemAutomotives = $filter->createQuery('id');
        foreach ($itemAutomotives as $automotive) {
            $automotives[] = $automotive->id;
        }


        if (!empty($automotives) && $type == 'preco') {
            if ($order == 'menor') {
                $automotives = Automotive::whereIn('id', $automotives)
                    ->sale()->available()
                    ->orderBy('sale_price')
                    ->get();
                $automotivesPaginate = Automotive::whereIn('id', $automotives->pluck('id'))
                    ->sale()->available()
                    ->orderBy('sale_price')
                    ->paginate(36);
            } else {
                $automotives = Automotive::whereIn('id', $automotives)
                    ->sale()->available()
                    ->orderBy('sale_price', 'desc')
                    ->get();
                $automotivesPaginate = Automotive::whereIn('id', $automotives->pluck('id'))
                    ->sale()->available()
                    ->orderBy('sale_price', 'desc')
                    ->paginate(36);
            }
        } elseif (!empty($automotives) && $type == 'uso') {
            $automotives = Automotive::whereIn('id', $automotives)
                ->sale()->available()
                ->orderBy('year', 'desc')
                ->get();
            $automotivesPaginate = Automotive::whereIn('id', $automotives->pluck('id'))
                ->sale()->available()
                ->orderBy('year', 'desc')
                ->paginate(36);
        } elseif (!empty($automotives) && $type == 'km') {
            $automotives = Automotive::whereIn('id', $automotives)
                ->sale()->available()
                ->orderBy('mileage')
                ->get();
            $automotivesPaginate = Automotive::whereIn('id', $automotives->pluck('id'))
                ->sale()->available()
                ->orderBy('mileage')
                ->paginate(36);
        } else {
            $automotives = null;
            $automotivesPaginate = null;
        }

        $filter->clearAllData();

        $collect = Automotive::sale()->available()->get();
        $cities = [];
        if ($collect->count()) {
            foreach ($collect as $automotive) {
                $city[] = $automotive->city;
            }
            $cities = collect(array_filter($city))->unique()->sort();
        }

        $banner = Banner::first();

        $spotlight = Automotive::sale()->available()->spotlight()->inRandomOrder()->take(12)->get();

        // $brand = [];
        // $model = [];
        $state = [];
        $cityCar = [];
        $mileageCar = [];

        if (count($collect) > 0) {
            foreach ($collect as $automotive) {
                $state[] = $automotive->state;
                $cityCar[] = $automotive->city;
                // $brand[] = ['title' => $automotive->brand, 'link' => Str::slug($automotive->brand)];
                // $model[] = ['title' => $automotive->model, 'link' => Str::slug($automotive->model)];
                $mileageCar[] = floatVal($automotive->mileage);
            }

            $state = collect(array_filter($state))->unique()->sort();
            // $brand = collect(array_filter($brand))->unique()->sort();
            // $model = collect(array_filter($model))->unique()->sort();
            $cityCar = collect(array_filter($cityCar))->unique()->sort();
            $mileageCar = collect(array_filter($mileageCar))->unique()->sort()->max();
        }

        $cityState = [];
        // if (count($state) && count($cityCar)) {
        //     foreach ($collect as $automotive) {
        //         if ($state->contains($automotive->state) && !$cityCar->contains($automotive->city)) {
        //             $cityState[] = $automotive->city;
        //         }
        //     }
        //     $cityState = collect(array_filter($cityState))->unique()->sort();
        // }

        foreach ($collect as $automotive) {
            if ($automotive->city && $automotive->state) {
                $cityState[] = $automotive->city . '-' . $automotive->state;
            }
        }
        $cityState = collect(array_filter($cityState))->unique()->sort();


        $users = User::where('banner_views_limit', '>', 0)->get();
        $clientBanner = ClientBanner::whereIn('user', $users->pluck('id'))->inRandomOrder()->first();
        if ($clientBanner) {
            $clientBanner->views = $clientBanner->views + 1;
            $clientBanner->update();
            $userBanner = User::where('id', $clientBanner->user)->first();
            if ($userBanner) {
                $userBanner->banner_views_limit = $userBanner->banner_views_limit - 1;
                $userBanner->update();
            }
        }

        return view('web.filter', [
            'head' => $head,
            'automotives' => $automotivesPaginate,
            'cities' => $cities,
            'banner' => $banner,
            'spotlight' => $spotlight,
            // 'brand' => $brand,
            // 'model' => $model,
            'state' => $state,
            'cityState' => $cityState,
            'collect' => $collect,
            'mileageMax' => $mileageCar,
            'clientBanner' => $clientBanner,
        ]);
    }

    public function sendEmail(Request $request)
    {
        if (empty($request['email'])) {
            return redirect()->route('web.home');
        }

        $data = [
            'reply_name' => $request->name,
            'reply_email' => $request->email,
            'cell' => $request->cell,
            'message' => $request->message,
            'company' => $request->ownerEmail
        ];

        Mail::send(new Contact($data));
        Storage::append('usuarios.txt', $request['email']);

        return redirect()->route('web.sendEmailSuccess');
    }

    public function sendEmailSuccess()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - E-mail enviado com sucesso!',
            'E-mail enviado com sucesso para a melhor plataforma web do Rio de Janeiro',
            route('web.policy'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.contact_success', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
        ]);
    }

    public function register()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Cadastre-se',
            'Cadastre-se namelhor plataforma web do Rio de Janeiro',
            route('web.register'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.register', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
        ]);
    }

    public function policy()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Política de Privacidade',
            'Política de Privacidade da melhor plataforma web do Rio de Janeiro',
            route('web.policy'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        $term = Term::first();

        return view('web.policy', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
            'term' => $term,
        ]);
    }

    public function banner()
    {
        $head = $this->seo->render(
            env('APP_NAME') . ' - Cadastre-se',
            'Cadastre-se namelhor plataforma web do Rio de Janeiro',
            route('web.banner'),
            asset('frontend/assets/images/share.png')
        );
        $forSale = Automotive::sale()->available()->first();
        $forRent = Automotive::rent()->available()->first();
        return view('web.banner', [
            'head' => $head,
            'forSale' => $forSale,
            'forRent' => $forRent,
        ]);
    }
}
