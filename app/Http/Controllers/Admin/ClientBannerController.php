<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use LaraCar\ClientBanner;
use LaraCar\Http\Controllers\Controller;
use LaraCar\Http\Requests\Admin\ClientBannerRequest;

class ClientBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner = ClientBanner::where('user', Auth::user()->id)->first();
        return view('admin.client-banners.index', \compact('banner'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientBannerRequest $request)
    {
        $bannerClient = ClientBanner::where('user', Auth::user()->id)->first();
        if ($bannerClient) {
            Storage::delete($bannerClient->cover);
            if (!empty($request->file('cover'))) {
                $bannerClient->cover = $request->file('cover')
                    ->storeAs('banner', str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                        ->extension());
            }
            $bannerClient->update();
        } else {
            $banner = new ClientBanner();
            $banner->user = Auth::user()->id;
            if (!empty($request->file('cover'))) {
                $banner->cover = $request->file('cover')
                    ->storeAs('banner', str_replace('.', '', microtime(true)) . '.' . $request->file('cover')
                        ->extension());
            }
            $banner->save();
        }

        return redirect()->route('admin.client-banner.index')
            ->with(['color' => 'green', 'message' => 'Banner criado com sucesso!']);
    }
}
