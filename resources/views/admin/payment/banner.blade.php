@extends('admin.master.master')

@section('content')
<div style="flex-basis: 100%;">
    <section class="dash_content_app">
        <header class="dash_content_app_header pb-1">
            <h2 class="icon-bookmark">Banner</h2>
            <div class="dash_content_app_header_actions">
                <nav class="dash_content_app_breadcrumb">
                    <ul>
                        <li><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="dash_content_app_box">
                <div class="text-center">
                    <h1>Em Breve</h1>
            </div>
        </div>

    </section>
</div>
@endsection