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
               <div class="col-md-12">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th class="text-center" width="4%">No</th>
                               <th class="text-center">NIP</th>
                               <th class="text-center">Rate Remun</th>
                               <th class="text-center">Keterangan</th>
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
                                    <td>Rp {{ number_format($detail_rubrik->rate_remun,0,',','.') }}</td>
                                    <td>{!! $detail_rubrik->keterangan !!}</td>
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
