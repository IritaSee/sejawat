@extends('template.main')
@section('content')
    @include('template.navbar.siswa')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
        <div class="layout-px-spacing">

            <div class="row layout-top-spacing">
                <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-one p-3">
                        <div class="widget-heading">
                            <h5 class="">Notifikasi Tugas</h5>
                        </div>

                        <div class="widget-content">
                            @if ($notif_tugas->count() > 0)
                                @foreach ($notif_tugas as $ts)
                                    <a href="{{ url('/siswa/tugas/' . $ts->kode) }}">
                                        <div class="transactions-list mt-1">
                                            <div class="t-item">
                                                <div class="t-company-name">
                                                    <div class="t-icon">
                                                        <div class="icon">
                                                            <svg viewBox="0 0 24 24" width="24" height="24"
                                                                stroke="currentColor" stroke-width="2" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="css-i6dzq1">
                                                                <path
                                                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                                </path>
                                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                                <line x1="16" y1="13" x2="8"
                                                                    y2="13"></line>
                                                                <line x1="16" y1="17" x2="8"
                                                                    y2="17"></line>
                                                                <polyline points="10 9 9 9 8 9"></polyline>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="t-name">
                                                        <h4>{{ $ts->tugas->nama_tugas }}</h4>
                                                        <p class="meta-date">{{ $ts->tugas->mapel->nama_mapel }}</p>
                                                    </div>
                                                </div>
                                                <div class="t-rate rate-dec">
                                                    <p>
                                                        <span>Due Date</span><br>
                                                        <span>{{ $ts->tugas->due_date }}</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="transactions-list" style="background: #b9eabb; border: 2px dashed #45c849;">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4 style="color: #45c849;">WOoHOO.. Belum Ada Tugas
                                                    <span data-feather="smile"></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-one p-3">
                        <div class="widget-heading">
                            <h5 class="">Notifikasi Materi</h5>
                        </div>

                        <div class="widget-content">
                            @if ($notif_materi->count() > 0)
                                @foreach ($notif_materi as $nm)
                                    <a href="{{ url('/siswa/materi/' . $nm->kode) }}">
                                        <div class="transactions-list mt-1">
                                            <div class="t-item">
                                                <div class="t-company-name">
                                                    <div class="t-icon">
                                                        <div class="icon">
                                                            <span data-feather="book"></span>
                                                        </div>
                                                    </div>
                                                    <div class="t-name">
                                                        <h4>{{ $nm->materi->nama_materi }}</h4>
                                                        <p class="meta-date">{{ $nm->materi->mapel->nama_mapel }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="transactions-list" style="background: #ffeccb; border: 2px dashed #e2a03f;">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4 style="color: #e2a03f;">Heeemm.. Belum Ada Materi
                                                    <svg viewBox="0 0 24 24" width="24" height="24"
                                                        stroke="currentColor" stroke-width="2" fill="none"
                                                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="8" y1="15" x2="16" y2="15">
                                                        </line>
                                                        <line x1="9" y1="9" x2="9.01" y2="9">
                                                        </line>
                                                        <line x1="15" y1="9" x2="15.01" y2="9">
                                                        </line>
                                                    </svg>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-md-6 col-sm-12 col-12 layout-spacing">
                    <div class="widget widget-table-one p-3">
                        <div class="widget-heading">
                            <h5 class="">Notifikasi Tryout</h5>
                        </div>

                        <div class="widget-content">
                            @if ($notif_ujian->count() > 0)
                                @foreach ($notif_ujian as $nu)
                                    @if ($nu->ujian->jenis === 0)
                                        <a href="{{ url('/siswa/ujian/' . $nu->kode) }}"
                                            class="@if ($nu->waktu_berakhir == null) btn-kerjakan @endif">
                                            <div class="transactions-list mt-1">
                                                <div class="t-item">
                                                    <div class="t-company-name">
                                                        <div class="t-icon">
                                                            <div class="icon">
                                                                <span data-feather="cast"></span>
                                                            </div>
                                                        </div>
                                                        <div class="t-name">
                                                            <h4>{{ $nu->ujian->nama }}</h4>
                                                            <p class="meta-date">{{ $nu->ujian->mapel->nama_mapel }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @else
                                        <a href="{{ url('/siswa/ujian_essay/' . $nu->kode) }}">
                                            <div class="transactions-list mt-1">
                                                <div class="t-item">
                                                    <div class="t-company-name">
                                                        <div class="t-icon">
                                                            <div class="icon">
                                                                <span data-feather="cast"></span>
                                                            </div>
                                                        </div>
                                                        <div class="t-name">
                                                            <h4>{{ $nu->ujian->nama }}</h4>
                                                            <p class="meta-date">{{ $nu->ujian->mapel->nama_mapel }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            @else
                                <div class="transactions-list"
                                    style="background: hsl(355, 82%, 85%); border: 2px dashed #e7515a;">
                                    <div class="t-item">
                                        <div class="t-company-name">
                                            <div class="t-name">
                                                <h4 style="color: #e7515a;">Tidak ada tryout yang belum dikerjakan!
                                                    <span data-feather="smile"></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row layout-top-spacing">
                <!-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget widget-five">
                        <div class="widget-content">
                            <div class="header">
                                <div class="header-body">
                                    <h6>Total Tugas</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="">
                                    <p class="task-left">
                                        {{ $tugas->count() }}
                                    </p>
                                    @php
                                        $tugas_telat = 0;
                                        $tugas_tidak_telat = 0;
                                    @endphp
                                    @foreach ($tugas as $t)
                                        @if ($t->is_telat === 1)
                                            @php
                                                $tugas_telat++;
                                            @endphp
                                        @endif

                                        @if ($t->is_telat === 0)
                                            @php
                                                $tugas_tidak_telat++;
                                            @endphp
                                        @endif
                                    @endforeach
                                    <p class="task-completed"><span>{{ $tugas_tidak_telat }} Tugas Sukses
                                            Dikerjakan</span></p>
                                    <p class="task-hight-priority"><span>{{ $tugas_telat }} Tugas</span> Terlambat
                                        Dikerjakan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget widget-five">
                        <div class="widget-content">
                            <div class="header">
                                <div class="header-body">
                                    <h6>Total Materi</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="">
                                    <p class="task-left">
                                        {{ $materi->count() }}
                                    </p>
                                    <p class="task-completed"><span>Ada {{ $materi->count() }} Materi Dikelas Kamu</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
 -->
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                    <div class="widget widget-five">
                        <div class="widget-content">
                            <div class="header">
                                <div class="header-body">
                                    <h6>Hasil Tryout Terbaru</h6>
                                </div>
                            </div>
                            <div class="w-content">
                                <div class="">
                                    <p class="task-left">
                                       {{ $nilai }}
                                    </p>
                                    <p class="task-completed"><span>Ada {{ $salah }} Jawaban Salah</span></p>
                                    <p class="task-completed"><span>Tidak Dijawab: {{ $tidakDijawab }}</span></p>
                                    <p class="task-completed"><span>Nilai: <span class="badge badge-primary">{{ $nilai }} / 100</span></span></p>
                                    @if (!empty($needs_improvement))
                                        <p class="task-completed">
                                            <span>Lebih banyak belajar lagi untuk Tipe Soal: {{ implode(', ', $needs_improvement) }}</span>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $tipeDeskripsi = [
                        1 => 'Mengingat',
                        2 => 'Memahami',
                        3 => 'Menerapkan',
                        4 => 'Menganalisis',
                        5 => 'Mengevaluasi',
                        6 => 'Menciptakan',
                    ];

                    // Mapping data untuk chart berdasarkan tipe soal
                    $chartData = [];
                    foreach ($filtered_tipe_soal as $tipe => $results) {
                        $correct_count = count(array_filter($results, fn($value) => $value === 1));
                        $wrong_count = count(array_filter($results, fn($value) => $value === 0));
                        $chartData[] = [
                            'tipe' => $tipeDeskripsi[$tipe] ?? 'Tidak Diketahui',
                            'benar' => $correct_count,
                            'salah' => $wrong_count,
                        ];
                    }
                @endphp


                <div class="row">
                    @foreach ($chartData as $index => $data)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                            <div class="widget widget-five">
                                <div class="widget-content">
                                    <div class="header">
                                        <div class="header-body">
                                            <h6>Evaluasi Perfoma {{ $data['tipe'] }}</h6>
                                        </div>
                                    </div>
                                    <div class="w-content">
                                        <!-- Chart Container -->
                                        <div class="chart-container">
                                            <canvas id="chart{{ $index + 1 }}"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const chartData = @json($chartData);
                        chartData.forEach((data, index) => {
                            const totalSoal = data.benar + data.salah;
                            const ctx = document.getElementById(`chart${index + 1}`).getContext('2d');
                            new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['Benar', 'Salah'],
                                    datasets: [{
                                        data: [data.benar, data.salah],
                                        backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                                        borderWidth: 1,
                                    }],
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'bottom', 
                                        },
                                        title: {
                                            display: true,
                                            text: `Jumlah Soal: ${totalSoal}`, 
                                        },
                                    },
                                },
                            });
                        });
                    });
                </script>
                </div>
            </div>

        </div>
        <div class="footer-wrapper">
            <div class="footer-section f-section-1">
                <p class="">Copyright © 2024 Developer</p>
            </div>
            <div class="footer-section f-section-2">
                <p class="">CBT</p>
            </div>
        </div>
    </div>
    <!--  END CONTENT AREA  -->


    {!! session('pesan') !!}
    <script>
        $(".btn-kerjakan").click(function(e) {
            e.preventDefault();
            var t = $(this).attr("href");
            swal({
                title: "yakin mulai Tryout?",
                text: "waktu Tryout akan dimulai & tidak bisa berhenti!",
                type: "warning",
                showCancelButton: !0,
                cancelButtonText: "tidak",
                confirmButtonText: "ya, mulai",
                padding: "2em"
            }).then(function(e) {
                e.value && (document.location.href = t)
            })
        })
    </script>
@endsection
