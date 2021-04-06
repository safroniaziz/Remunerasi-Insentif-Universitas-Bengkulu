@extends('layouts.layout')
@section('title', 'Data Remunisasi')
@section('login_as', 'Verifikator')
@section('user-login')

@endsection
@section('user-login2')

@endsection
@section('sidebar-menu')
    @include('verifikator/sidebar')
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
        a.disabled {
            pointer-events: none;
            cursor: default;
        }
        .loader {
            border: 10px solid #dfe1e2; /* Light grey */
            border-top: 10px solid rgb(22, 22, 134);
            border-bottom: 10px solid rgb(22, 22, 134);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        td.details-control::before {
            content: "\f055 ";
            color: #007bff;
            padding-right: 5px;
            font-size: 1.3em;
            font-family: "FontAwesome";
            cursor: pointer;
        }
        tr.shown td.details-control::before {
            content: "\f056";
            color:red;
            padding-right: 5px;
            font-family: "FontAwesome";
        }
    </style>
@endpush
@section('content')
    <section class="panel" style="margin-bottom:20px;">
        <header class="panel-heading" style="color: #ffffff;background-color: #074071;border-color: #fff000;border-image: none;border-style: solid solid none;border-width: 4px 0px 0;border-radius: 0;font-size: 14px;font-weight: 700;padding: 15px;">
            <i class="fa fa-tasks"></i>&nbsp;Manajemen Data Remunerasi Insentif Universitas Bengkulu
        </header>
        <div class="panel-body" style="border-top: 1px solid #eee; padding:15px; background:white;">
           <div class="row">
               <div class="col-md-12">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th width="4%">no</th>
                               <th class="text-center">Nama Rubrik</th>
                               <th class="text-center">Nomor SK</th>
                               <th class="text-center">unit</th>
                               <th class="text-center">File</th>
                               <th class="text-center">Periode</th>
                               <th class="text-center">Status</th>
                               <th class="text-center">Verifikasi</th>
                               <th class="text-center">Aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($rubriks as $rubrik)
                                @foreach ($rubrik->isianrubrik->where('status_validasi','!=','nonaktif') as $isian_rubrik)
                                        <tr data-isian="{{ $isian_rubrik }}" data-kolom="{{ $rubrik }}" class="kolom_data">
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $isian_rubrik->rubrik->nama_rubrik }}</td>
                                            <td>{{ $isian_rubrik->nomor_sk }}</td>
                                            <td class="text-center">{{ $isian_rubrik->nm_unit }}</td>
                                            <td class="text-center"><a href="{{ route('operator.dataremun.download',$isian_rubrik->file_upload) }}"  class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                                            <td>{{ $isian_rubrik->periode->masa_kinerja }}</td>
                                            <td class="text-center">
                                                @if ($isian_rubrik->status_validasi=='nonaktif')
                                                    <h6><span class="badge badge-warning"><i class="fa fa-exclamation-circle"></i> &nbsp; Belum dikirim</span></h6>
                                                @elseif ($isian_rubrik->status_validasi=='aktif')
                                                    <h6><span class="badge badge-info"><i class="fa fa-clock-o"></i> &nbsp; Menunggu Verifikasi</span></h6>
                                                @elseif($isian_rubrik->status_validasi=="terverifikasi")
                                                    <h6><span class="badge badge-success"><i class="fa fa-check"></i> &nbsp; Terverifikasi</span></h6>
                                                @else
                                                    <h6><span class="badge badge-danger"><i class="fa fa-times"></i> &nbsp; Ditolak</span></h6>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if ($isian_rubrik->status_validasi=='aktif')
                                                    <form action="{{ route('verifikator.dataremun.verifikasi',$isian_rubrik->id) }}" class="selesai_form" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="terverifikasi">
                                                        <button type="submit" class="btn btn-success btn-sm data_selesai" data-detail="{{ $isian_rubrik->detailisianrubrik->count() }}"><i class="fa fa-check"></i>&nbsp; Verifikasi</button>
                                                    </form>
                                                    <form action="{{ route('verifikator.dataremun.verifikasi',$isian_rubrik->id) }}" class="selesai_form" method="POST">
                                                        @csrf @method('PUT')
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="btn btn-danger btn-sm data_selesai" data-detail="{{ $isian_rubrik->detailisianrubrik->count() }}"><i class="fa fa-exclamation-circle"></i>&nbsp; Tolak</button>
                                                    </form>
                                                @else
                                                    <h6><span class="badge badge-success"><i class="fa fa-check-circle-o"></i></span></h6>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('verifikator.detailrubrik',$isian_rubrik) }}"  class="btn btn-primary btn-sm text-center"><i class="fa fa-info-circle"></i></a>
                                            </td>
                                        </tr>
                                @endforeach
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
        //loader
        $('.loader').hide();
        function checkAdult(data) {
            return data.includes('nama_kolom');
        }
        function format ( d ) {
            return ` <div class="mt-3 col-md-12">
                        <h6>Detail isian rubrik :</h6>
                    </div>
                    <div class="mt-3 col-md-4">
                        <p>SKS : test</p>
                    </div> <div class="mt-3 col-md-4">
                        <p>data : test2</p>
                    </div><div class="mt-3 col-md-4">
                        <p>contoh Integer : 1</p>
                    </div>
                    </div><div class="mt-3 col-md-4">
                        <p>contoh Integer2 : 2</p>
                    </div>
                    </div><div class="mt-3 col-md-4">
                        <p>contoh date : 07-04-2021</p>
                    </div>
                    </div><div class="mt-3 col-md-4">
                        <p>contoh date : 07-0420</p>
                    </div>`;
        }
        $(document).ready(function() {

            var table=$("table[id^='table']").DataTable({
                responsive : true,
                "ordering": true,
                "columns": [
                    {
                        "class":          "details-control",
                        "orderable":      false,
                    },

                    { "data": "nama_rubrik" },
                    { "data": "no_sk" },
                    { "data": "unit" },
                    { "data": "file" },
                    { "data": "periode" },
                    { "data": "status" },
                    { "data": "ubah_status" },
                    { "data": "aksi" },
                ],
            });
            $('#table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var data = $(this).closest('.kolom_data');
                console.log(data.data('isian'));
                console.log(data.data('kolom'));
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
        });
        $(document).ready(function () {

            //sweet alert hapus
            $('.hapus_data').click(function (e) {
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
                        $('.hapus_form').submit();
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                    }
                })
            });

            //selesai verifikasi
            $('.data_selesai').click(function (e) {
                e.preventDefault();
                let selesai=$('.data_selesai').data('detail');
                if(selesai<=0){
                    Swal.fire(
                        'Lengkapi detail rubrik',
                        'Silahkan lengkapi detail rubrik terlebih dahulu !',
                        'warning'
                    )
                }
                else{
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary',
                            cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                    })
                    swalWithBootstrapButtons.fire({
                        title: 'Apakah sudah cek data dengan benar?',
                        text: "Data yang sudah diverikasi tidak dapat diubah kembali",
                        icon: 'success',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, saya yakin!',
                        cancelButtonText: 'Tidak, Batalkan!',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $('.selesai_form').submit();
                        } else if (result.dismiss === Swal.DismissReason.cancel ) {
                        }
                    })
                }
            });
        });
    </script>

@endpush
