@extends('layouts.layout')
@section('title', 'Data Remunisasi')
@section('login_as', 'Operator')
@section('user-login')

@endsection
@section('user-login2')

@endsection
@section('sidebar-menu')
    @include('operator/sidebar')
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
            <i class="fa fa-tasks"></i>&nbsp;Manajemen Data Remunerasi Insentif Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
            @if ($isian_rubrik->status_validasi!='aktif')
            <form action="{{ route('operator.detailrubrik.store',$isian_rubrik->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info-new alert-block">
                            <i class="fa fa-info-circle"></i>&nbsp; Silahkan tambahkan detail isian rubrik baru jika diperlukan.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>NIP</label>
                        <select name="nip" id="nip" class="form-control">
                            <option value="">-- Pilih nama  --</option>
                            <option value="1">contoh nama</option>
                        </select>
                        @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Rate Remun</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="text" name="rate_remun" id="rate_remun" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" aria-describedby="basic-addon1" class="form-control @error('rate_remun') is-invalid @enderror">
                            @error('rate_remun')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" cols="5" rows="5"></textarea>
                    </div>
                    <div class="col-md-12 text-center mt-3">
                        <button type="reset" name="reset" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                        <button type="submit" name="submit" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                    </div>
                </div>
            </form>
            <hr>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <p>Nama Rubrik  : {{ $isian_rubrik->pengguna_rubrik_id }}</p>
                    </div>
                    <div class="col-md-6">
                        <p>Nomor SK  : {{ $isian_rubrik->nomor_sk }}</p>
                    </div>
                    <div class="col-md-6 mt-2">
                        <p>Periode  : {{ $isian_rubrik->periode_id }}</p>
                    </div>
                    <div class="col-md-6 mt-2">
                        <p>Isian Rubrik  : {{ $isian_rubrik->isian_1 }}</p>
                    </div>
                </div>
            </div>
            <hr>
           <div class="row">
               <div class="col-md-12">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th class="text-center" width="4%">No</th>
                               <th class="text-center">NIP</th>
                               <th class="text-center">Rate Remun</th>
                               <th class="text-center">Keterangan</th>
                               @if ($isian_rubrik->status_validasi!='aktif')
                                    <th class="text-center">Aksi</th>
                               @endif
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($detail_rubriks as $detail_rubrik)
                                <tr>
                                    <td >{{ $no++."." }}</td>
                                    <td>{{ $detail_rubrik->nip }}</td>
                                    <td>Rp.{{ $detail_rubrik->rate_remun }}</td>
                                    <td>{!! $detail_rubrik->keterangan !!}</td>
                                    @if ($isian_rubrik->status_validasi!='aktif')
                                        <td class="text-center">
                                            <form action="{{ route('operator.detailrubrik.destroy',$isian_rubrik->id) }}" method="POST">
                                                @csrf @method('delete')
                                                <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                                <input type="hidden" name="id_detail_rubrik" value="{{ $detail_rubrik->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
               <div class="col-md-12 mt-3">
                   <a href="{{ route('operator.dataremun') }}" class="btn btn-danger"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
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
