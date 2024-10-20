@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3" style="min-height: 500px;">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="widget-heading">
                                    <h5 class="">Bank Soal Ujian</h5>
                                    <a href="javascript:void(0)" class="btn btn-primary mt-3" data-toggle="modal"
                                        data-target="#tambah_bank">Tambah</a>
                                </div>
                                <div class="table-responsive mt-3" style="overflow-x: scroll;">
                                    <table id="datatable-table" class="table text-center text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Jenis Ujian</th>
                                                <th>Total Soal</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($bank_soal as $bs)
                                                <tr>
                                                    <td>{{ $bs->nama }}</td>
                                                    <td>{{ ($bs->jenis == 0) ? 'Pilihan Ganda' : 'Essay'; }}</td>
                                                    <td>{{ $bs->total_soal }} soal</td>
                                                    <td>
                                                        @if ($bs->jenis == 0)
                                                            <a href="{{ url('/guru/bank_soal/' . $bs->kode) }}" class="btn btn-primary btn-sm">
                                                                <span data-feather="eye"></span>
                                                            </a>
                                                            <a href="{{ url('/guru/bank_soal/' . $bs->kode) . '/edit' }}" class="btn btn-success btn-sm">
                                                                <span data-feather="edit"></span>
                                                            </a>
                                                        @endif

                                                        @if ($bs->jenis == 1)
                                                            <a href="{{ url('/guru/bank_soal_essay/' . $bs->kode) }}" class="btn btn-primary btn-sm">
                                                                <span data-feather="eye"></span>
                                                            </a>
                                                            <a href="{{ url('/guru/bank_soal_essay/' . $bs->kode) . '/edit' }}" class="btn btn-success btn-sm">
                                                                <span data-feather="edit"></span>
                                                            </a>
                                                        @endif
                                                        <form action="{{ url('/guru/bank_soal/' . $bs->kode) }}" method="post" class="d-inline" id="formHapus">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm btn-hapus">
                                                                <span data-feather="trash"></span>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-5 d-flex">
                                <img src="{{ url('/assets/img') }}/bank-soal.svg" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->

    <!-- MODAL -->

    <div class="modal fade" id="tambah_bank" tabindex="-1" role="dialog" aria-labelledby="tambah_bankLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambah_bankLabel">Tambah Bank Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            x
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <a href="{{ url('/guru/bank_soal/create') }}" class="btn btn-primary">Pilihan Ganda</a>
                        <a href="{{ url('/guru/bank_soal_essay') }}" class="btn btn-primary ml-2">Essay</a>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" value="reset" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(){$(".btn-hapus").on("click",function(e){var t=$(this);e.preventDefault(),swal({title:"yakin di hapus?",text:"data yang berkaitan akan dihapus dan tidak bisa di kembalikan!",type:"warning",showCancelButton:!0,cancelButtonText:"tidak",confirmButtonText:"ya, hapus",padding:"2em"}).then(function(e){e.value&&t.parent("form").submit()})}),$("#datatable-table").DataTable({scrollY:"300px",scrollX:!0,scrollCollapse:!0,paging:!0,oLanguage:{oPaginate:{sPrevious:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',sNext:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'},sInfo:"tampilkan halaman _PAGE_ dari _PAGES_",sSearch:'<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',sSearchPlaceholder:"Cari Data...",sLengthMenu:"Hasil :  _MENU_"},stripeClasses:[],lengthMenu:[[-1,5,10,25,50],["All",5,10,25,50]]})});
    </script>

    {!! session('pesan') !!}
@endsection
