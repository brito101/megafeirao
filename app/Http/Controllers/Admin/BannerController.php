<?php

namespace LaraCar\Http\Controllers\Admin;

use Illuminate\Http\Request;
use LaraCar\Http\Controllers\Controller;
use LaraCar\Banner;
use LaraCar\Http\Requests\Admin\Banner as BannerRequest;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
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
        $banner = Banner::first();
        return view('admin.banner', [
            'banner' => $banner
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BannerRequest $request)
    {

        $banner = new Banner();
        $banner->link1 = $request['link1'];
        $banner->link2 = $request['link2'];
        $banner->link3 = $request['link3'];
        $banner->link4 = $request['link4'];
        $banner->link5 = $request['link5'];
        $banner->link6 = $request['link6'];
        $banner->link7 = $request['link7'];
        $banner->link8 = $request['link8'];
        $banner->link9 = $request['link9'];
        if (!empty($request->file('cover1'))) {
            $banner->cover1 = $request->file('cover1')
                ->storeAs('cover1', str_replace('.', '', microtime(true)) . '.' . $request->file('cover1')
                    ->extension());
        }
        if (!empty($request->file('cover2'))) {
            $banner->cover2 = $request->file('cover2')
                ->storeAs('cover2', str_replace('.', '', microtime(true)) . '.' . $request->file('cover2')
                    ->extension());
        }
        if (!empty($request->file('cover3'))) {
            $banner->cover3 = $request->file('cover3')
                ->storeAs('cover3', str_replace('.', '', microtime(true)) . '.' . $request->file('cover3')
                    ->extension());
        }
        if (!empty($request->file('cover4'))) {
            $banner->cover4 = $request->file('cover4')
                ->storeAs('cover4', str_replace('.', '', microtime(true)) . '.' . $request->file('cover4')
                    ->extension());
        }
        if (!empty($request->file('cover5'))) {
            $banner->cover5 = $request->file('cover5')
                ->storeAs('cover5', str_replace('.', '', microtime(true)) . '.' . $request->file('cover5')
                    ->extension());
        }
        if (!empty($request->file('cover6'))) {
            $banner->cover6 = $request->file('cover6')
                ->storeAs('cover6', str_replace('.', '', microtime(true)) . '.' . $request->file('cover6')
                    ->extension());
        }
        if (!empty($request->file('cover7'))) {
            $banner->cover7 = $request->file('cover7')
                ->storeAs('cover7', str_replace('.', '', microtime(true)) . '.' . $request->file('cover7')
                    ->extension());
        }
        if (!empty($request->file('cover8'))) {
            $banner->cover8 = $request->file('cover8')
                ->storeAs('cover8', str_replace('.', '', microtime(true)) . '.' . $request->file('cover8')
                    ->extension());
        }
        if (!empty($request->file('cover9'))) {
            $banner->cover9 = $request->file('cover9')
                ->storeAs('cover9', str_replace('.', '', microtime(true)) . '.' . $request->file('cover9')
                    ->extension());
        }
        $banner->save();

        return redirect()->route('admin.banner.index')
            ->with(['color' => 'green', 'message' => 'Banners criados com sucesso!']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::first();
        if (!empty($request->file('cover1'))) {
            Storage::delete($banner->cover1);
            $banner->cover1 = '';
        }
        if (!empty($request->file('cover2'))) {
            Storage::delete($banner->cover2);
            $banner->cover2 = '';
        }
        if (!empty($request->file('cover3'))) {
            Storage::delete($banner->cover3);
            $banner->cover3 = '';
        }
        if (!empty($request->file('cover4'))) {
            Storage::delete($banner->cover4);
            $banner->cover4 = '';
        }
        if (!empty($request->file('cover5'))) {
            Storage::delete($banner->cover5);
            $banner->cover5 = '';
        }
        if (!empty($request->file('cover6'))) {
            Storage::delete($banner->cover6);
            $banner->cover6 = '';
        }
        if (!empty($request->file('cover7'))) {
            Storage::delete($banner->cover7);
            $banner->cover7 = '';
        }
        if (!empty($request->file('cover8'))) {
            Storage::delete($banner->cover8);
            $banner->cover8 = '';
        }
        if (!empty($request->file('cover9'))) {
            Storage::delete($banner->cover9);
            $banner->cover9 = '';
        }
        $banner->link1 = $request['link1'];
        $banner->link2 = $request['link2'];
        $banner->link3 = $request['link3'];
        $banner->link4 = $request['link4'];
        $banner->link5 = $request['link5'];
        $banner->link6 = $request['link6'];
        $banner->link7 = $request['link7'];
        $banner->link8 = $request['link8'];
        $banner->link9 = $request['link9'];
        if (!empty($request->file('cover1'))) {
            $banner->cover1 = $request->file('cover1')
                ->storeAs('cover1', str_replace('.', '', microtime(true)) . '.' . $request->file('cover1')
                    ->extension());
        }
        if (!empty($request->file('cover2'))) {
            $banner->cover2 = $request->file('cover2')
                ->storeAs('cover2', str_replace('.', '', microtime(true)) . '.' . $request->file('cover2')
                    ->extension());
        }
        if (!empty($request->file('cover3'))) {
            $banner->cover3 = $request->file('cover3')
                ->storeAs('cover3', str_replace('.', '', microtime(true)) . '.' . $request->file('cover3')
                    ->extension());
        }
        if (!empty($request->file('cover4'))) {
            $banner->cover4 = $request->file('cover4')
                ->storeAs('cover4', str_replace('.', '', microtime(true)) . '.' . $request->file('cover4')
                    ->extension());
        }
        if (!empty($request->file('cover5'))) {
            $banner->cover5 = $request->file('cover5')
                ->storeAs('cover5', str_replace('.', '', microtime(true)) . '.' . $request->file('cover5')
                    ->extension());
        }
        if (!empty($request->file('cover6'))) {
            $banner->cover6 = $request->file('cover6')
                ->storeAs('cover6', str_replace('.', '', microtime(true)) . '.' . $request->file('cover6')
                    ->extension());
        }
        if (!empty($request->file('cover7'))) {
            $banner->cover7 = $request->file('cover7')
                ->storeAs('cover7', str_replace('.', '', microtime(true)) . '.' . $request->file('cover7')
                    ->extension());
        }
        if (!empty($request->file('cover8'))) {
            $banner->cover8 = $request->file('cover8')
                ->storeAs('cover8', str_replace('.', '', microtime(true)) . '.' . $request->file('cover8')
                    ->extension());
        }
        if (!empty($request->file('cover9'))) {
            $banner->cover9 = $request->file('cover9')
                ->storeAs('cover9', str_replace('.', '', microtime(true)) . '.' . $request->file('cover9')
                    ->extension());
        }
        $banner->save();
        return redirect()->route('admin.banner.index')
            ->with(['color' => 'green', 'message' => 'Banners atualizados com sucesso!']);
    }
}
