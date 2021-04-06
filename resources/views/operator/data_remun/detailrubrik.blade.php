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
                        <select name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror">
                            <option value="">-- Pilih nama  --</option>
                            <option value="1">contoh nama</option>
                        </select>
                        @error('nip')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Rate Remun</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="text" name="rate_remun" id="rate_remun" oninput="this.value = this.value.replace(/[^0-9]/g, '');" aria-describedby="basic-addon1" class="form-control @error('rate_remun') is-invalid @enderror">
                            @error('rate_remun')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Keterangan</label>
                        <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" cols="5" rows="5"></textarea>
                        @error('keterangan')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                        <p><b> Nama Rubrik  : {{ $isian_rubrik->rubrik->nama_rubrik }} </b></p>
                    </div>
                    <div class="col-md-6">
                        <p><b> Nomor SK  : {{ $isian_rubrik->nomor_sk }} </b></p>
                    </div>
                    <div class="col-md-6 mt-2">
                        <p><b> Periode  : {{ $isian_rubrik->periode->masa_kinerja }} </b></p>
                    </div>
                    <div class="col-md-6 mt-2">
                        <p><b> Isian Rubrik  : {{ $isian_rubrik->isian_1 }} </b></p>
                    </div>
                </div>
            </div>
            <hr>
           <div class="row">
               <div class="col-md-6">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th class="text-center" width="4%">No</th>
                               <th class="text-center">NIP</th>
                               <th class="text-center">Rate Remun</th>
                               <th class="text-center">Keterangan</th>
                               @if ($isian_rubrik->status_validasi=='nonaktif')
                                    <th class="text-center">Aksi</th>
                               @endif
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($isian_rubrik->detailisianrubrik as $detail_rubrik)
                                <tr>
                                    <td >{{ $no++."." }}</td>
                                    <td>{{ $detail_rubrik->nip }}</td>
                                    <td>Rp {{ number_format($detail_rubrik->rate_remun,0,',','.') }}</td>
                                    <td>{!! $detail_rubrik->keterangan !!}</td>
                                    @if ($isian_rubrik->status_validasi=='nonaktif')
                                        <td class="text-center">
                                            <form action="{{ route('operator.detailrubrik.destroy',$isian_rubrik->id) }}" id="hapus_form" method="POST">
                                                @csrf @method('delete')
                                                <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></a>
                                                <input type="hidden" name="id_detail_rubrik" value="{{ $detail_rubrik->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm" id="hapus_data"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                           @endforeach
                       </tbody>
                   </table>
               </div>
               <div class="col-md-6">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               @foreach ($rubriks as $key => $item)
                                    @if ($item && str_contains($key,'nama_kolom'))
                                        <th class="text-center" width="4%">{{ $item }}</th>
                                    @endif
                               @endforeach
                           </tr>
                       </thead>
                       <tbody>
                                <tr>
                                    @foreach ($isian as $key => $data)
                                        @if ($data && str_contains($key,'isian'))
                                            <th class="text-center">{{ $data }}</th>
                                        @endif
                                    @endforeach
                                </tr>
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
            //data table
            $("table[id^='table']").DataTable({
                responsive : true,
                "ordering": true,
            });

            $('#hapus_data').click(function (e) {
                e.preventDefault();
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang sudah dihapus tidak dapat dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, saya yakin!',
                    cancelButtonText: 'Tidak, Batalkan!',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $('#hapus_form').submit();
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                })
            });
        } );

    </script>

@endpush
