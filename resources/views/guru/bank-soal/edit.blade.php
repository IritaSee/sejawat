@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <a href="javascript:void(0);" class="btn btn-primary tambah-pg" style="position: fixed; right: -10px; top: 50%; z-index: 9999;">Tambah Soal</a>
        <div class="layout-px-spacing">
            <form action="{{ url('/guru/bank_soal') }}/{{ $bank_soal->kode }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Edit Bank Soal Ujian Pilihan Ganda</h5>
                                <div class="row mt-2">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="">Nama Ujian / Quiz</label>
                                            <input type="text" name="nama" class="form-control" value="{{ $bank_soal->nama }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row layout-top-spacing">
                    <div class="col-lg-12 layout-spacing">
                        <div class="widget shadow p-3">
                            <div class="widget-heading">
                                <h5 class="">Soal Ujian</h5>
                            </div>
                            <div id="soal_pg">
                                @php
                                    $index_soal = 1;
                                @endphp
                                @foreach ($detail_bank_soal as $soal)
                                    <div class="isi_soal">
                                        @if ($index_soal != 1)
                                            <hr>
                                        @endif
                                        <div class="form-group">
                                            <label for="">Soal No. {{ $index_soal }}</label>
                                            <textarea name="soal[]" cols="30" rows="2" class="summernote" wrap="hard" required>{{ $soal->soal }}</textarea>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Pilihan A</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">A</span>
                                                        </div>
                                                        <input type="text" name="pg_1[]" class="form-control" placeholder="Opsi A" autocomplete="off" value="{{ str_replace('A. ', '', $soal->pg_1) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Pilihan B</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">B</span>
                                                        </div>
                                                        <input type="text" name="pg_2[]" class="form-control"
                                                            placeholder="Opsi B" autocomplete="off"  value="{{ str_replace('B. ', '', $soal->pg_2) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Pilihan C</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">C</span>
                                                        </div>
                                                        <input type="text" name="pg_3[]" class="form-control"
                                                            placeholder="Opsi C" autocomplete="off"  value="{{ str_replace('C. ', '', $soal->pg_3) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Pilihan D</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">D</span>
                                                        </div>
                                                        <input type="text" name="pg_4[]" class="form-control"
                                                            placeholder="Opsi D" autocomplete="off" value="{{ str_replace('D. ', '', $soal->pg_4) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Pilihan E</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">E</span>
                                                        </div>
                                                        <input type="text" name="pg_5[]" class="form-control"
                                                            placeholder="Opsi E" autocomplete="off" value="{{ str_replace('E. ', '', $soal->pg_5) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="">Jawaban</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text" id="basic-addon5">
                                                                <svg viewBox="0 0 24 24" width="24" height="24"
                                                                    stroke="currentColor" stroke-width="2" fill="none"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="css-i6dzq1">
                                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                                </svg>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="jawaban[]" class="form-control"
                                                            placeholder="Contoh : A" autocomplete="off"  value="{{ $soal->jawaban }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($index_soal != 1)
                                            <a href="javascript:void(0);" class="btn btn-danger hapus-pg">Hapus</a>
                                        @endif
                                    </div>
                                    @php
                                        $index_soal++;
                                        $no_soal = $index_soal;
                                    @endphp
                                @endforeach
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <a href="{{ url('/guru/bank_soal') }}" class="btn btn-danger btn-sm"><span data-feather="arrow-left-circle"></span> kembali</a>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->
    <script>
        $(document).ready(function() {
            function uploadImage(e,o){var a=new FormData;a.append("image",e),$.ajax({headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},url:"{{ route('summernote_upload') }}",cache:!1,contentType:!1,processData:!1,data:a,type:"post",success:function(e){$(o).summernote("insertImage",e)},error:function(e){console.log(e)}})}function deleteImage(e){$.ajax({headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},data:{src:e},type:"post",url:"{{ route('summernote_delete') }}",cache:!1,success:function(e){console.log(e)}})}setInterval(()=>{$(".summernote").summernote({placeholder:"Hello stand alone ui",tabsize:2,height:120,toolbar:[["style",["style"]],["font",["bold","underline","clear"]],["color",["color"]],["para",["ul","ol","paragraph"]],["table",["table"]],["insert",["link","picture","video"]],["view",["fullscreen","help"]]],callbacks:{onImageUpload:function(e,o=this){uploadImage(e[0],o)},onMediaDelete:function(e){deleteImage(e[0].src)}}})},1e3);
            var no_soal = "{{ $no_soal }}";
            $('.tambah-pg').click(function() {
                const pg = `
                    <div class="isi_soal">
                    <hr>
                        <div class="form-group">
                            <label for="">Soal No . ` + no_soal + `</label>
                            <textarea name="soal[]" cols="30" rows="2" class="summernote" wrap="hard" required></textarea>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan A</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">A</span>
                                        </div>
                                        <input type="text" name="pg_1[]" class="form-control" placeholder="Opsi A" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan B</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">B</span>
                                        </div>
                                        <input type="text" name="pg_2[]" class="form-control" placeholder="Opsi B" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan C</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">C</span>
                                        </div>
                                        <input type="text" name="pg_3[]" class="form-control" placeholder="Opsi C" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan D</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">D</span>
                                        </div>
                                        <input type="text" name="pg_4[]" class="form-control" placeholder="Opsi D" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Pilihan E</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">E</span>
                                        </div>
                                        <input type="text" name="pg_5[]" class="form-control" placeholder="Opsi E" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Jawaban</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon5">
                                                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                    <polyline points="20 6 9 17 4 12"></polyline>
                                                </svg>
                                            </span>
                                        </div>
                                        <input type="text" name="jawaban[]" class="form-control" placeholder="Contoh : A" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0);" class="btn btn-danger hapus-pg">Hapus</a>
                    </div>
                `;

                $('#soal_pg').append(pg);
                no_soal++;
            });
            $("#soal_pg").on("click",".isi_soal a",function(){$(this).parents(".isi_soal").remove(),--no_soal});
        })
    </script>

    {!! session('pesan') !!}
@endsection
