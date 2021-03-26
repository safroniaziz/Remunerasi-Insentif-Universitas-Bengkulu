@php
    use App\Usulan;
    use App\TotalSkor;
    use App\NilaiFormulir3;
@endphp
@extends('layouts.layout')
@section('title', 'Dashboard')
@section('login_as', 'Administrator')
@section('user-login')
   
@endsection
@section('user-login2')
    
@endsection
@section('sidebar-menu')
    @include('admin/sidebar')
@endsection
@push('styles')
    <style>
        #detail:hover{
            text-decoration: underline !important;
            cursor: pointer !important;
            color:teal;
        }
        #selengkapnya{
            color:#5A738E;
            text-decoration:none;
            cursor:pointer;
        }
        #selengkapnya:hover{
            color:#007bff;
        }
    </style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-tasks"></i>&nbsp;Manajemen Periode Remunerasi Insentif Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            <form action="{{ route('admin.periode.post') }}" method="POST">
                {{ csrf_field() }} {{ method_field('POST') }}
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info-new alert-block">
                            <i class="fa fa-info-circle"></i>&nbsp; Silahkan tambahkan periode baru jika diperlukan.
                        </div>
                    </div>
                    <div class="form-status_periode col-md-6">
                        <label>Masa Kinerja</label>
                        <input type="text" name="masa_kinerja" id="masa_kinerja" class="form-control @error('masa_kinerja') is-invalid @enderror">
                        @error('masa_kinerja')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-status_periode col-md-6">
                        <label>Periode Pembayaran</label>
                        <input type="date" name="periode_pembayaran" id="periode_pembayaran" class="form-control @error('periode_pembayaran') is-invalid @enderror">
                        @error('periode_pembayaran')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                
                    <div class="col-md-12 text-center mt-2">
                        <button type="reset" name="reset" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    </div>
                </div>
            </form>
           <div class="row">
               <div class="col-md-12">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th>No</th>
                               <th>Masa Kinerja</th>
                               <th>Periode Pembayaran</th>
                               <th>Status</th>
                               <th>Ubah Status</th>
                               <th>Aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($periodes as $periode)
                               <tr>
                                   <td>{{ $no++ }}</td>
                                   <td>{{ $periode->masa_kinerja }}</td>
                                   <td>{{ $periode->periode_pembayaran }}</td>
                                   <td>
                                    @if($periode->status == "aktif")
                                        <label class="badge badge-primary">Aktif</label>
                                        @else
                                        <label class="badge badge-danger">Tidak Aktif</label>
                                    @endif
                                </td>
                                <td>
                                 @if ($periode->status == "aktif")
                                     <form action="{{ route('admin.periode.non_aktifkan_status', [$periode->id]) }}" method="POST">
                                         {{ csrf_field() }} {{ method_field('PATCH') }}
                                         <button type="submit" class="btn btn-danger btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-down"></i></button>
                                     </form>
                                     @else
                                     <form action="{{ route('admin.periode.aktifkan_status', [$periode->id]) }}" method="POST">
                                         {{ csrf_field() }} {{ method_field('PATCH') }}
                                         <button type="submit" class="btn btn-primary btn-sm" style="color:white; cursor:pointer;"><i class="fa fa-thumbs-up"></i></button>
                                     </form>
                                 @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.periode.delete') }}" method="POST">
                                        {{ csrf_field() }} {{ method_field('DELETE') }}
                                        <input type="hidden" name="id" value="{{ $periode->id }}">
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>&nbsp;Hapus</button>
                                    </form>
                                </td>
                               </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
           </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("table[id^='table']").DataTable({
                responsive : true,
                "ordering": true,
            });
        } );
    </script>
@endpush