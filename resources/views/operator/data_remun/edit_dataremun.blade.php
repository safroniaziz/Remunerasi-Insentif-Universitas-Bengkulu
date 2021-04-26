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
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            <form action="{{ route('operator.dataremun.store') }}" method="POST" id="test_form" enctype="multipart/form-data">
                @csrf @method('POST')
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info-new alert-block">
                            <i class="fa fa-info-circle"></i>&nbsp; Silahkan tambahkan isian rubrik baru jika diperlukan.
                        </div>
                    </div>
                    <input type="hidden" name="id_file" id="id_file" value="">
                    <div class="col-md-6">
                        <label for="id_rubrik">Nama Rubrik</label>
                        <select name="id_rubrik" id="id_rubrik" class="form-control @error('id_rubrik') is-invalid @enderror">
                            <option value="">-- Pilih nama rubrik --</option>
                            @foreach ($data_rubriks as $rubrik)
                                <option value="{{$rubrik->id}}" {{ $rubrik->id==$data->rubrik_id ? 'selected':'' }} >{{ $rubrik->nama_rubrik }}</option>
                            @endforeach
                        </select>
                        @error('id_rubrik')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="no_sk">Nomor SK</label>
                        <input type="text" name="no_sk" id="no_sk"  class="form-control @error('no_sk') is-invalid @enderror" value="{{ $data->nomor_sk }}">
                        @error('no_sk')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="id_periode">Periode</label>
                        <select name="id_periode" id="id_periode" class="form-control @error('id_periode') is-invalid @enderror">
                            <option value="">-- Pilih masa kinerja --</option>
                            @foreach ($periodes as $periode)
                                <option value="{{$periode->id}}" {{ $periode->id==$data->periode_id ?'selected':'' }} >{{ $periode->masa_kinerja }}</option>
                            @endforeach
                        </select>
                        @error('id_periode')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="col-md-6 mt-2">
                        <label for="id_unit">Nama unit</label>
                        <select name="id_unit" id="id_unit" class="form-control @error('id_unit') is-invalid @enderror">
                            <option value="">-- Pilih nama unit --</option>
                            @foreach ($units as $unit)
                                <option value="{{$unit->id}}" {{ $unit->id==old('id_unit')? 'selected':'' }} >{{ $unit->nm_unit }}</option>
                            @endforeach
                        </select>
                        @error('id_unit')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div> --}}
                    <div class="col-md-6 mt-2 form-group">
                        <label for="file_isian">Upload file</label>
                        <input type="file" name="file_isian" id="file_isian" class="form-control @error('file_isian') is-invalid @enderror">
                        @error('file_isian')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="alert alert-dismissible mt-3 d-none col-12" id="alert_file" role="alert">
                        <span id="tampil_file"></span>
                        <button type="button" class="close" id="alert_hapusfile">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="progress_wrapper" class="col-md-12 d-none mt-2">
                        <div class="progress">
                            <div id="progress" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemax="100" aria-valuemin="0">0%</div>
                        </div>
                    </div>
                    <div id="alert_wrapper"></div>
                    <div id="isian_kolom" class="form-row col-md-12">
                    </div>
                    <div class="loader d-none"></div>
                    <div class="col-md-12 text-center mt-3">
                        <button type="reset" name="reset" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i>&nbsp; Ulangi</button>
                        <button type="submit" name="submit" id="simpan" class="btn btn-primary btn-sm"><i class="fa fa-check-circle"></i>&nbsp; Simpan</button>
                        <button class="btn btn-primary d-none" id="btn_loading" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            unggah berkas...
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')

    <script type="text/javascript">
        //loader
        let alert_wrapper=$('#alert_wrapper');
        $(document).ready(function() {
            var table=$("table[id^='table']").DataTable({
                responsive : true,
                "ordering": true,
                // dom: 'Bfrtip',
                // columnDefs: [
                //     {
                //         targets: 1,
                //         className: 'noVis'
                //     }
                // ],
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf',
                //     {
                //         extend: 'print',
                //         exportOptions: {
                //             columns: ':visible'
                //         }
                //     },
                //     {
                //         extend: 'colvis',
                //         columns: ':not(.noVis)'
                //     }
                // ],
            });
            //ajax isian rubrik
            $('#id_rubrik').change(function () {
                let id=$(this).val();
                $('.loader').removeClass('d-none');
                $('.form_isian').remove();
                $.ajax({
                    type: "get",
                    url: "{{ route('operator.dataremun.kolom_rubrik') }}",
                    data: ({id:id}),
                    contentType: "application/json; charset=utf-8",
                    processData: true,
                    dataType: "json",
                    success: function (data) {
                        let no=1;
                        console.log(data);
                        $.each(data, function(index, value) {
                            if(value){
                                if(index.includes("nama_kolom")){
                                    let angka=parseInt(index.match(/\d/g).join(''));
                                    let hidden=`<input type="hidden" name="isian_angka[]" value="isian_`+angka+`">`
                                    let isian_kolom='';
                                    if(angka>=1 && angka<=4){
                                        isian_kolom=`<div class="col-md-6 mt-2 form_isian">
                                            <label for="nama_kolom_`+angka+`">`+value+`</label>
                                            <input type="text" name="nama_kolom[`+angka+`]" id="nama_kolom_`+angka+`" required class="form-control @error('nama_kolom_`+angka+`') is-invalid @enderror" value="{{ old('nama_kolom_`+angka+`') }}">
                                            @error('nama_kolom_`+angka+`')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>`
                                    }
                                    else if(angka>=5 && angka<=8){
                                        isian_kolom=`<div class="col-md-6 mt-2 form_isian">
                                            <label for="nama_kolom_`+angka+`">`+value+`</label>
                                            <input type="number" name="nama_kolom[`+angka+`]" id="nama_kolom_`+angka+`" required class="form-control @error('nama_kolom_`+angka+`') is-invalid @enderror" value="{{ old('nama_kolom_`+angka+`') }}">
                                            @error('nama_kolom_`+angka+`')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>`
                                    }
                                    else if(angka>=9 && angka<=10){
                                        isian_kolom=`<div class="col-md-6 mt-2 form_isian">
                                            <label for="nama_kolom_`+angka+`">`+value+`</label>
                                            <input type="date" name="nama_kolom[`+angka+`]" id="nama_kolom_`+angka+`" required class="form-control @error('nama_kolom_`+angka+`') is-invalid @enderror" value="{{ old('nama_kolom_`+angka+`') }}">
                                            @error('nama_kolom_`+angka+`')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>`
                                    }
                                    $('#isian_kolom').append(hidden);
                                    $('#isian_kolom').append(isian_kolom);
                                }
                            }
                        });
                        $('.loader').addClass('d-none');
                    }
                });
            });

            // upload file
            $('#file_isian').change(function (e) {
                e.preventDefault();
                // let file=  e.target.files;
                let form_url="{{ route('operator.dataremun.upload') }}";
                var data = new FormData();
                let progress=$('#progress');
                let token="{{ csrf_token() }}";
                let progress_wrapper=$('#progress_wrapper');
                let progress_status=$('#progress_status');
                let btn_loading=$('#btn_loading');
                let simpan=$('#simpan');
                progress_wrapper.removeClass('d-none');
                simpan.addClass('d-none');
                btn_loading.removeClass('d-none');
                data.append('file_isian', $('#file_isian')[0].files[0]);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "post",
                    url: "{{ route('operator.dataremun.upload') }}",
                    data: data,
                    contentType: false,
                    processData: false,
                    xhr: function()
                    {
                        var xhr = new window.XMLHttpRequest();
                        //Upload progress
                        xhr.upload.addEventListener("progress", function(evt){
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round(((evt.loaded / evt.total)*100))+"%";
                            //Do something with upload progress
                            progress.css("width",percentComplete);
                            progress.html(percentComplete);
                        }
                        }, true);
                        xhr.upload.onload = function () { progress.html('saving file...'); };
                        return xhr;
                    },
                    success: function (response) {
                        progress_wrapper.addClass('d-none');
                        $('#id_file').val(response.id);
                        show_alert(response,'secondary');
                        $('#file_isian').attr('disabled','true');
                        btn_loading.addClass('d-none');
                        simpan.removeClass('d-none');

                    },
                    error : function(err){
                        progress_wrapper.addClass('d-none');
                        console.log(err);
                        show_alert('gagal upload file','danger');
                        btn_loading.addClass('d-none');
                        simpan.removeClass('d-none');
                    }
                });

            });
            //show alert
            function show_alert(message, alert){
                if(alert=='danger'){
                    $('#alert_file').addClass('alert-'+alert);
                    $('#tampil_file').html(message);
                    $('#alert_file').removeClass('d-none');
                }
                else{
                    var SITEURL = "{{URL('/operator/data_remunisasi')}}";
                    $('#alert_file').addClass('alert-'+alert);
                    $('#tampil_file').html(`<a href="${SITEURL+"/"+message.id+"/download"}"  class="alert-link"><i class="fa fa-file"></i>&nbsp${message.file_asli}</a>`);
                    $('#alert_file').removeClass('d-none');

                }
            }

            $('#alert_hapusfile').click(function (e) {
                let id_file=$('#id_file').val();
                if(id_file!=''){
                    $.ajax({
                        type: "delete",
                        url: "{{ route('operator.dataremun.hapus_file') }}",
                        data: JSON.stringify({id:id_file}),
                        contentType: "application/json; charset=utf-8",
                        processData: true,
                        dataType: "json",
                        success: function (data) {
                            console.log(data);
                        },
                        error :function(err){
                            console.log(err);
                        }
                    });
                }
                $('#file_isian').removeAttr('disabled');
                $('#file_isian').val('');
                $('#alert_file').addClass('d-none');
                $('#id_file').val('');
            });
        } );

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
                        title: 'Apakah anda yakin?',
                        text: "Data yang sudah dikirim tidak dapat diubah kembali",
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
