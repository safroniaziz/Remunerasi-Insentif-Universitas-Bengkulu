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
            <form action="{{ route('operator.dataremun.store') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info-new alert-block">
                            <i class="fa fa-info-circle"></i>&nbsp; Silahkan tambahkan isian rubrik baru jika diperlukan.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label>Nama Rubrik</label>
                        <select name="id_rubrik" id="id_rubrik" class="form-control">
                            <option value="">-- Pilih nama rubrik --</option>
                            <option value="1">contoh rubrik</option>
                            @foreach ($rubriks as $rubrik)
                                <option value="{{$rubrik->id_rubrik}}" >{{ $rubrik->nama_rubrik }}</option>
                            @endforeach
                        </select>
                        @error('id_rubrik')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Nomor SK</label>
                        <input type="text" name="no_sk" id="no_sk" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" class="form-control @error('no_sk') is-invalid @enderror">
                        @error('no_sk')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label>Upload file</label>
                        <input type="file" name="file_isian" id="file_isian" class="form-control @error('file_isian') is-invalid @enderror">
                        @error('file_isian')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Periode</label>
                        <select name="id_periode" id="id_periode" class="form-control">
                            <option value="">-- Pilih masa kinerja --</option>
                            <option value="1">contoh periode</option>
                            @foreach ($periodes as $periode)
                                <option value="{{$periode->periode_id}}" >{{ $periode->masa_kinerja }}</option>
                            @endforeach
                        </select>
                        @error('id_periode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-md-12 text-center mt-3">
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
                               <th width="4%">No</th>
                               <th class="text-center">Nama Rubrik</th>
                               <th class="text-center">Nomor SK</th>
                               <th class="text-center">Isian</th>
                               <th class="text-center">File</th>
                               <th class="text-center">Periode</th>
                               <th class="text-center" width="5%">Detail Rubrik</th>
                               <th class="text-center">Status</th>
                               <th class="text-center">Ubah Status</th>
                               <th class="text-center">Aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($isian_rubriks as $isian_rubrik)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $isian_rubrik->pengguna_rubrik_id }}</td>
                                    <td>{{ $isian_rubrik->nomor_sk }}</td>
                                    <td class="text-center">
                                        {{ $isian_rubrik->isian_1 }}
                                        <hr>
                                        <button type="button" id="modal_isi" class="btn btn-primary btn-sm" @if ($isian_rubrik->status_validasi=='aktif') disabled @endif data-toggle="modal" data-id="{{ $isian_rubrik->id }}" class="btn btn-primary btn-sm text-center"><i class="fa fa-plus-circle"></i>&nbsp; Tambah</button>
                                    </td>
                                    <td class="text-center"><a href="{{ asset('upload/file_remun/'.$isian_rubrik->file_upload) }}" download="data" class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                                    <td>{{ $isian_rubrik->periode_id }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('operator.detailrubrik',$isian_rubrik) }}"  class="btn btn-primary btn-sm text-center"><i class="fa fa-info-circle"></i></a>
                                    </td>
                                    <td class="text-center">
                                        @if ($isian_rubrik->status_validasi=='nonaktif')
                                            <h6><span class="badge badge-danger"><i class="fa fa-close"></i> &nbsp; belum Dikirim</span></h6>
                                        @else
                                            <h6><span class="badge badge-info"><i class="fa fa-clock-o"></i> &nbsp; Menunggu Verifikasi</span></h6>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($isian_rubrik->status_validasi=='nonaktif')
                                            <form action="{{ route('operator.dataremun.status',$isian_rubrik->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <button type="submit"  class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp; Selesai</button>
                                            </form>
                                        @else
                                            <h6><span class="badge badge-success"><i class="fa fa-check-circle-o"></i></span></h6>
                                        @endif
                                    </td>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('operator.dataremun.destroy',$isian_rubrik->id) }}" method="POST">
                                            <a href="#" @if ($isian_rubrik->status_validasi=='aktif') disabled @endif class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                            @csrf @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" @if ($isian_rubrik->status_validasi=='aktif') disabled @endif><i class="fa fa-trash"></i></button>
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
    <section>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah isian</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('operator.dataremun.tambah_isian','data') }}" method="post">
                        @csrf @method('PUT')
                        <h2 id="nama_rubrik"></h2>
                        <input type="hidden" name="isian_id" id="isian_id" value="adjakl">
                        <div class="col-md-12">
                            <label>Jenis isian Rubrik</label>
                            <select name="jenis_isian" id="jenis_isian" class="form-control">
                                <option value="">-- Pilih jenis isian rubrik --</option>
                                <option value="1">contoh rubrik</option>
                            </select>
                            @error('jenis_isian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-2 mb-4">
                            <label>Isian Rubrik</label>
                            <input type="text" name="isian" id="isian" class="form-control @error('isian') is-invalid @enderror">
                            @error('isian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp; Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp; Simpan</button>
                        </div>
                    </form>
                </div>

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

        $(document).ready(function () {
            $('#modal_isi').click(function (e) {
                e.preventDefault();
                let data=$(this).data('id');
                $('#isian_id').val(data);
                $('#exampleModal').modal('show');
            });
        });
    </script>

@endpush
