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
        session()->remove('category');
        session()->remove('state');
        session()->remove('model');

        if ($request->search === 'buy') {
            session()->put('user', $user);
            session()->put('sale', true);
            session()->remove('rent');
            $categoryAutomotives = $this->createQuery('category');
        }

        if ($request->search === 'rent') {
            session()->put('user', $user);
            session()->put('rent', true);
            session()->remove('sale');
            $categoryAutomotives = $this->createQuery('category');
        }

        if ($categoryAutomotives->count()) {
            foreach ($categoryAutomotives as $automotive) {
                $category[] = $automotive->category;
            }

            $collect = collect($category);
            return response()->json($this->setResponse('success', $collect->unique()->toArray()));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function category(Request $request)
    {
        session()->remove('category');
        session()->remove('state');
        session()->remove('model');

        session()->put('category', $request->search);
        $stateAutomotives = $this->createQuery('state');

        if ($stateAutomotives->count()) {
            foreach ($stateAutomotives as $item) {
                $states[] = $item->state;
            }

            if (!empty(array_filter($states))) {
                $collect = collect($states);
                return response()->json($this->setResponse('success', $collect->unique()->toArray()));
            } else {
                return response()->json($this->setResponse('success', ['Indiferente']));
            }
        } else {
            return response()->json($this->setResponse('success', ['Sem resultados']));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }

    public function state(Request $request)
    {
        session()->remove('state');
        session()->remove('model');

        session()->put('state', $request->search);
        $modelAutomotives = $this->createQuery('model');

        if ($modelAutomotives->count()) {
            foreach ($modelAutomotives as $item) {
                $models[] = $item->model;
            }

            if (!empty(array_filter($models))) {
                $collect = collect($models);
                return response()->json($this->setResponse('success', $collect->unique()->toArray()));
            } else {
                return response()->json($this->setResponse('success', ['Indiferente']));
            }
        } else {
            return response()->json($this->setResponse('success', ['Sem resultados']));
        }

        return response()->json($this->setResponse('fail', [], 'Ooops, não foi retornado nenhum dado para essa pesquisa!'));
    }


    public function model(Request $request)
    {

        session()->remove('model');

        session()->put('model', $request->search);

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
        session()->remove('category');
        session()->remove('state');
        session()->remove('model');
    }

    public function createQuery($field)
    {
        $user = session('user');
        $sale = session('sale');
        $rent = session('rent');
        $category = session('category');
        $state = session('state');
        $model = session('model');

        $query = DB::table('automotives')
            ->where('status', '1')->where('sale', '1')->whereDate('active_date', '>=', Carbon::now()->subDays(30))
            ->when($user, function ($query, $user) {
                return $query->where('user', '=', $user);
            })
            ->when($sale, function ($query, $sale) {
                return $query->where('sale', $sale);
            })
            ->when($rent, function ($query, $rent) {
                return $query->where('rent', $rent);
            })
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->when($state, function ($query, $state) {
                if ($state == 'Indiferente') {
                    return $query;
                }
                return $query->where('state', $state);
            })
            ->when($model, function ($query, $model) {

                if ($model == 'Indiferente') {
                    return $query;
                }
                return $query->where('model', $model);
            })
            ->get(explode(',', $field));
        return $query;
    }
}
