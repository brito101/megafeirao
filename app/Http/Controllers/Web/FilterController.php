<?php

namespace LaraCar\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaraCar\Http\Controllers\Controller;
use Carbon\Carbon;

class FilterController extends Controller
{

    public function search(Request $request)
    {

        $loja = filter_var(str_replace(
            env('APP_URL') . '/loja/',
            '',
            $request->server('HTTP_REFERER')
        ), FILTER_SANITIZE_STRIPPED);
        $company = DB::table('companies')->where('slug', $loja)->first();

        if ($company) {
            $user = ($company->user);
        } else {
            $user = null;
        }

        session()->remove('user');
        session()->remove('city');
        session()->remove('brand');
        session()->remove('model');
        session()->remove('price_base');
        session()->remove('price_limit');
        session()->remove('year_base');
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        if ($request->search === 'buy') {
            session()->put('user', $user);
            session()->put('sale', true);
            session()->remove('rent');
            $cityAutomotives = $this->createQuery('city');
        }

        if ($request->search === 'rent') {
            session()->put('user', $user);
            session()->put('rent', true);
            session()->remove('sale');
            $cityAutomotives = $this->createQuery('city');
        }

        if ($cityAutomotives->count()) {
            foreach ($cityAutomotives as $automotive) {
                $city[] = $automotive->city;
            }

            $collect = collect($city);
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function city(Request $request)
    {
        session()->remove('brand');
        session()->remove('model');
        session()->remove('price_base');
        session()->remove('price_limit');
        session()->remove('year_base');
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        session()->put('city', $request->search);
        $brandAutomotives = $this->createQuery('brand');

        if ($brandAutomotives->count()) {
            foreach ($brandAutomotives as $automotive) {
                $brand[] = $automotive->brand;
            }

            $brand[] = 'Indiferente';

            $collect = collect($brand)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function brand(Request $request)
    {
        session()->remove('model');
        session()->remove('price_base');
        session()->remove('price_limit');
        session()->remove('year_base');
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        session()->put('brand', $request->search);
        $modelAutomotives = $this->createQuery('model');

        if ($modelAutomotives->count()) {
            foreach ($modelAutomotives as $automotive) {
                $model[] = $automotive->model;
            }

            $model[] = 'Indiferente';

            $collect = collect($model)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function model(Request $request)
    {
        session()->remove('price_base');
        session()->remove('price_limit');
        session()->remove('year_base');
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        session()->put('model', $request->search);

        $priceBaseAutomotives = $this->createQuery('sale_price as price');

        if ($priceBaseAutomotives->count()) {
            foreach ($priceBaseAutomotives as $automotive) {
                $price[] = $automotive->price;
            }

            $collect = collect($price)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function priceBase(Request $request)
    {
        session()->remove('price_limit');
        session()->remove('year_base');
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        session()->put('price_base', $request->search);

        $priceLimitAutomotives = $this->createQuery('sale_price as price');

        if ($priceLimitAutomotives->count()) {
            foreach ($priceLimitAutomotives as $automotive) {
                $price[] = $automotive->price;
            }

            $collect = collect($price)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function priceLimit(Request $request)
    {
        session()->remove('year_base');
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        session()->put('price_limit', $request->search);

        $yearAutomotives = $this->createQuery('year');

        if ($yearAutomotives->count()) {
            foreach ($yearAutomotives as $automotive) {
                $year[] = $automotive->year;
            }

            $year[] = 'Indiferente';

            $collect = collect($year)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function yearBase(Request $request)
    {
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        session()->put('year_base', $request->search);

        $yearAutomotives = $this->createQuery('year');

        if ($yearAutomotives->count()) {
            foreach ($yearAutomotives as $automotive) {
                $year[] = $automotive->year;
            }

            $year[] = 'Indiferente';

            $collect = collect($year)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function yearLimit(Request $request)
    {
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');

        session()->put('year_limit', $request->search);

        $mileageAutmotives = $this->createQuery('mileage');

        if ($mileageAutmotives->count()) {
            foreach ($mileageAutmotives as $automotive) {
                $mileage[] = (int)$automotive->mileage;
            }

            $mileage[] = 'Indiferente';

            $collect = collect($mileage)->unique()->toArray();
            sort($collect);
            return response()->json($this->setResponse('success', $collect));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function mileage(Request $request)
    {

        session()->remove('gear');
        session()->remove('fuel');

        session()->put('mileage', $request->search);

        return response()->json($this->setResponse('success', []));
    }

    public function gear(Request $request)
    {
        session()->put('gear', $request->search);

        return response()->json($this->setResponse('success', []));
    }

    public function fuel(Request $request)
    {
        session()->put('fuel', $request->search);

        return response()->json($this->setResponse('success', []));
    }

    private function setResponse(string $status, array $data = null, string $message = null)
    {
        return [
            'status' => $status,
            'data' => $data,
            'message' => $message
        ];
    }

    public function clearAllData()
    {
        session()->remove('user');
        session()->remove('sale');
        session()->remove('rent');
        session()->remove('city');
        session()->remove('brand');
        session()->remove('model');
        session()->remove('price_base');
        session()->remove('price_limit');
        session()->remove('year_base');
        session()->remove('year_limit');
        session()->remove('mileage');
        session()->remove('gear');
        session()->remove('fuel');
    }

    public function createQuery($field)
    {

        $user = session('user');
        $sale = session('sale');
        $rent = session('rent');
        $city = session('city');
        $brand = session('brand');
        $model = session('model');
        $priceBase = session('price_base');
        $priceLimit = session('price_limit');
        $yearBase = session('year_base');
        $yearLimit = session('year_limit');
        $mileage = session('mileage');
        $gear = session('gear');
        $fuel = session('fuel');

        $query = DB::table('automotives')
            ->where('status', '=', '1')->where('sale', '1')->whereDate('active_date', '>=', Carbon::now()->subDays(30))
            ->when($user, function ($query, $user) {
                return $query->where('user', '=', $user);
            })
            ->when($sale, function ($query, $sale) {
                return $query->where('sale', $sale);
            })
            ->when($rent, function ($query, $rent) {
                return $query->where('rent', $rent);
            })
            ->when($city, function ($query, $city) {
                return $query->where('city', $city);
            })
            ->when($brand, function ($query, $brand) {

                if ($brand == 'Indiferente') {
                    return $query;
                }
                return $query->where('brand', $brand);
            })
            ->when($model, function ($query, $model) {

                if ($model == 'Indiferente') {
                    return $query;
                }
                return $query->where('model', $model);
            })
            ->when($priceBase, function ($query, $priceBase) {
                if ($priceBase == 'Indiferente') {
                    return $query;
                }
                $priceBase = (float) $priceBase;
                return $query->where('sale_price', '>=', $priceBase);
            })
            ->when($priceLimit, function ($query, $priceLimit) {
                if ($priceLimit == 'Indiferente') {
                    return $query;
                }
                $priceLimit = (float) $priceLimit;
                return $query->where('sale_price', '<=', $priceLimit);
            })
            ->when($yearBase, function ($query, $yearBase) {
                if ($yearBase == 'Indiferente') {
                    return $query;
                }
                $yearBase = (int) $yearBase;
                return $query->where('year', '>=', $yearBase);
            })
            ->when($yearLimit, function ($query, $yearLimit) {
                if ($yearLimit == 'Indiferente') {
                    return $query;
                }
                $yearLimit = (int) $yearLimit;
                return $query->where('year', '<=', $yearLimit);
            })
            ->when($mileage, function ($query, $mileage) {
                if ($mileage == 'Indiferente') {
                    return $query;
                }
                return $query->where('mileage', '<=', (int) $mileage);
            })
            ->when($gear, function ($query, $gear) {
                return $query->whereIn('gear', $gear);
            })
            ->when($fuel, function ($query, $fuel) {
                return $query->whereIn('fuel', $fuel);
            })
            ->get(explode(',', $field));

        return $query;
    }
}
