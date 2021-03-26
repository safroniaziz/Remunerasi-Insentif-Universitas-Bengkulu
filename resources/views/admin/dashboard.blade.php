@extends('layouts.layout')
@section('user-login')
    {{-- {{ Auth::user()->nm_user }} --}}
@endsection
@section('user-login2')
    {{-- {{ Auth::user()->nm_user }} --}}
@endsection
@section('login_as', 'Administrator')
@section('sidebar-menu')
    @include('admin/sidebar')
@endsection
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-home"></i>&nbsp;Dashboard
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <div class="row" style="margin-right:-15px; margin-left:-15px;">
                <div class="col-md-12">Selamat datang <strong> {{ Session::get('nm_dosen') }} </strong> di halaman Dashboard Administrator <b> E-Marketing Bank Bengkulu</b></div>
            </div>
        </div>
    </section>

    <section class="panel">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-bar-chart"></i>&nbsp;Statistik Keseluruhan
            <span class="tools pull-right" style="margin-top:-5px;">
                <a class="fa fa-chevron-down" href="javascript:;" style="float: left;margin-left: 3px;padding: 10px;text-decoration: none;"></a>
                <a class="fa fa-times" href="javascript:;" style="float: left;margin-left: 3px;padding: 10px;text-decoration: none;"></a>
            </span>
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua" style="margin-bottom:0px;">
                        <div class="inner">
                        <h3>  </h3>

                        {{-- <p>Jumlah Target</p> --}}
                        </div>
                        <div class="icon">
                        <i class="fa fa-bullseye"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red" style="margin-bottom:0px;">
                        <div class="inner">
                        <h3>  </h3>

                        {{-- <p>Jumlah Pipeline</p> --}}
                        </div>
                        <div class="icon">
                        <i class="fa fa-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow" style="margin-bottom:0px;">
                        <div class="inner">
                        <h3></h3>

                        {{-- <p>Pipeline Berhasil</p> --}}
                        </div>
                        <div class="icon">
                        <i class="fa fa-check"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green" style="margin-bottom:0px;">
                        <div class="inner">
                        <h3></h3>

                        {{-- <p>Pipeline Terverifikasi</p> --}}
                        </div>
                        <div class="icon">
                        <i class="fa fa-check-circle"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection