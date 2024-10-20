@extends('template.main')
@section('content')
    @include('template.navbar.guru')

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-lg-12 layout-spacing">
                    <div class="widget shadow p-3">
                        <div class="widget-heading">
                            <h5 class="">Bank Soal {{ $bank_soal->nama }}</h5>
                            <table class="mt-2">
                                <tr>
                                    <th>Jenis Ujian</th>
                                    <th>: {{ ($bank_soal->jenis == 0) ? 'Pilihan Ganda' : 'Essay'; }}</th>
                                </tr>
                                <tr>
                                    <th>Total Soal</th>
                                    <th>: {{ count($detail_bank_soal) }} Soal</th>
                                </tr>
                                <tr>
                                    <th>Waktu Dibuat</th>
                                    <th>: {{ $bank_soal->created_at }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- soal ujian & jawaban --}}
            <div id="toggleAccordion" class="shadow">
                <div class="card">
                    <div class="card-header bg-white" id="...">
                        <section class="mb-0 mt-0">
                            <div role="menu" class="" data-toggle="collapse" data-target="#defaultAccordionOne" aria-expanded="true" aria-controls="defaultAccordionOne" style="cursor: pointer;">
                                Soal Ujian (Klik untuk lihat & tutup)
                            </div>
                        </section>
                    </div>

                    <div id="defaultAccordionOne" class="collapse show" aria-labelledby="..." data-parent="#toggleAccordion">
                        <div class="card-body">
                        
                            <div class="row">
                                <div class="col-lg-9">
                                    <form id="examwizard-question" action="#" method="POST">
                                        <div class="widget shadow p-2">
                                            <div>
                                                @php
                                                    $no = 1;
                                                    $soal_hidden = '';
                                                @endphp
                                                @foreach ($detail_bank_soal as $soal)
                                                    <div class="question {{ $soal_hidden }} question-{{ $no }}"
                                                        data-question="{{ $no }}">
                                                        <div class="widget-heading pl-2 pt-2" style="border-bottom: 1px solid #e0e6ed;">
                                                            <div class="">
                                                                <h6 class="" style="font-weight: bold">Soal No. <span
                                                                        class="badge badge-primary no-soal">{{ $no }}</span>
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="widget p-3 mt-3">
                                                            <div class="widget-heading" style="min-height: 150px;">
                                                                <h6 class="question-title color-green" style="word-wrap: break-word">
                                                                    {!! $soal->soal !!}
                                                                </h6>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    @php
                                                        $soal_hidden = 'hidden';
                                                        $no++;
                                                    @endphp
                                                @endforeach
                                            </div>
                                            <!-- SOAL -->

                                            <input type="hidden" value="1" id="currentQuestionNumber" name="currentQuestionNumber" />
                                            <input type="hidden" value="{{ $detail_bank_soal->count() }}" id="totalOfQuestion"
                                                name="totalOfQuestion" />
                                            <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
                                            <!-- END SOAL -->
                                        </div>
                                    </form>

                                </div>

                                <div class="col-lg-3" id="quick-access-section" class="table-responsive">
                                    <div class="widget shadow p-3">
                                        <div class="widget-content">
                                            <table class="table text-center table-hover">
                                                <thead class="question-response-header">
                                                    <tr>
                                                        <th class="text-center">No. Soal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach ($detail_bank_soal as $soal)
                                                        <tr class="question-response-rows" data-question="{{ $no }}"
                                                            style="cursor: pointer;">
                                                            <td style="font-weight: bold;">{{ $no }}</td>
                                                        </tr>
                                                        @php
                                                            $no++;
                                                        @endphp
                                                    @endforeach

                                                </tbody>
                                            </table>
                                            <div class="text-nowrap text-center">
                                                <a href="javascript:void(0)" class="btn btn-success" id="quick-access-prev">
                                                    &laquo;
                                                </a>
                                                <span class="alert alert-info" id="quick-access-info"></span>
                                                <a href="javascript:void(0)" class="btn btn-success" id="quick-access-next">&raquo;</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Exmas Footer - Multi Step Pages Footer -->
                            <div class="row mt-3">
                                <div class="col-lg-12 exams-footer p-3">
                                    <div class="row">
                                        <div class="col-sm-1 back-to-prev-question-wrapper text-center">
                                            <a href="javascript:void(0);" id="back-to-prev-question" class="btn btn-success disabled">
                                                Back
                                            </a>
                                        </div>
                                        <div class="col-sm-2 footer-question-number-wrapper text-center">
                                            <div>
                                                <span id="current-question-number-label">1</span>
                                                <span>Dari <b>{{ $detail_bank_soal->count() }}</b></span>
                                            </div>
                                            <div>
                                                Nomor Soal
                                            </div>
                                        </div>
                                        <div class="col-sm-1 go-to-next-question-wrapper text-center">
                                            <a href="javascript:void(0);" id="go-to-next-question" class="btn btn-success">
                                                Next
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ url('/guru/bank_soal') }}" class="btn btn-danger btn-sm mt-3"><span data-feather="arrow-left-circle"></span> kembali</a>
        </div>
        @include('template.footer')
    </div>
    <!--  END CONTENT AREA  -->
    {!! session('pesan') !!}
    @include('error.ew-t-e')
@endsection
