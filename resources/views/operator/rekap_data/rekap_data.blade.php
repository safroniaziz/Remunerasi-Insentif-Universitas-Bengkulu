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
           <div class="row">
               <div class="col-md-12">
                   <table class="table table-hover table-bordered" id="table">
                       <thead>
                           <tr>
                               <th class="text-center" width="4%">No</th>
                               <th class="text-center">Periode</th>
                               <th class="text-center">Nama</th>
                               <th class="text-center">Nip</th>
                               <th class="text-center">Total Remun</th>
                           </tr>
                       </thead>
                       <tbody>
                           @php
                               $no=1;
                           @endphp
                           @foreach ($rekapitulasi as $data)
                                <tr>
                                    <td >{{ $no++."." }}</td>
                                    <td>{{ $data->periode->masa_kinerja }}</td>
                                    <td>{{ $data->nip }}</td>
                                    <td>{{ $data->nip }}</td>
                                    <td>Rp {{ number_format($data->total_remun,0,',','.') }}</td>
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
            //data table
            $("table[id^='table']").DataTable({
                responsive : true,
                "ordering": true,
                dom: 'Bfrtip',
                columnDefs: [
                    {
                        targets: 1,
                        className: 'noVis'
                    }
                ],
                buttons: [
                    'copy', 'csv', 'excel', 'pdf',
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        columns: ':not(.noVis)'
                    }
                ],
            });
        } );

    </script>

@endpush
