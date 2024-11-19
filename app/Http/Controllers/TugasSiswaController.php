<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\FileModel;
use App\Models\Notifikasi;
use App\Models\TugasSiswa;
use App\Models\WaktuUjian;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TugasSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
    //         ->where('date_send', null)
    //         ->get();
    //     $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
    //         ->where('selesai', null)
    //         ->get();
    //     $siswa = Siswa::firstWhere('id', session()->get('id'));
    //     return view('siswa.tugas.index', [
    //         'title' => 'Data Tugas',
    //         'plugin' => '
    //             <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
    //             <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
    //             <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
    //             <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
    //         ',
    //         'menu' => [
    //             'menu' => 'tugas',
    //             'expanded' => 'tugas'
    //         ],
    //         'siswa' => $siswa,
    //         'tugas' => Tugas::where('kelas_id', $siswa->kelas_id)->get(),
    //         'notif_tugas' => $notif_tugas,
    //         'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
    //         'notif_ujian' => $notif_ujian
    //     ]);
    // }

    public function index()
    {
        // Mengambil data siswa berdasarkan ID dari sesi
        $siswa = Siswa::find(session()->get('id'));
        $kelas_id = $siswa->kelas_id;

        // Mengambil semua tugas yang ditugaskan ke kelas siswa
        $tugas_kelas = Tugas::where('kelas_id', $kelas_id)->get();

        // Membuat entri TugasSiswa untuk setiap tugas yang belum ada untuk siswa ini
        foreach ($tugas_kelas as $tugas) {
            TugasSiswa::firstOrCreate(
                ['kode' => $tugas->kode, 'siswa_id' => $siswa->id],
                [
                    'teks' => null,
                    'file' => null,
                    'date_send' => null,
                    'is_telat' => null,
                    'nilai' => null,
                    'catatan_guru' => null,
                ]
            );
        }

        // Mengambil notifikasi tugas yang belum dikirim
        $notif_tugas = TugasSiswa::where('siswa_id', $siswa->id)
            ->where('date_send', null)
            ->get();

        // Mengambil notifikasi ujian yang belum selesai
        $notif_ujian = WaktuUjian::where('siswa_id', $siswa->id)
            ->where('selesai', null)
            ->get();

        // Mengambil notifikasi materi
        $notif_materi = Notifikasi::where('siswa_id', $siswa->id)->get();

        // Mengambil semua tugas untuk kelas siswa
        $tugas = Tugas::where('kelas_id', $kelas_id)->get();

        // Mengembalikan view dengan data yang diperlukan
        return view('siswa.tugas.index', [
            'title' => 'Data Tugas',
            'plugin' => '
            <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
            <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
            <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
            <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
        ',
            'menu' => [
                'menu' => 'tugas',
                'expanded' => 'tugas'
            ],
            'siswa' => $siswa,
            'tugas' => $tugas,
            'notif_tugas' => $notif_tugas,
            'notif_materi' => $notif_materi,
            'notif_ujian' => $notif_ujian
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function show(Tugas $tuga)
    {
        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();

        $tugas_siswa = TugasSiswa::where('kode', $tuga->kode)
            ->where('siswa_id', session()->get('id'))
            ->first();


        // **Tambahkan blok kode ini di sini**
        if (!$tugas_siswa) {
            $tugas_siswa = TugasSiswa::create([
                'kode' => $tuga->kode,
                'siswa_id' => session()->get('id'),
                'teks' => null,
                'file' => null,
                'date_send' => null,
                'is_telat' => null,
                'nilai' => null,
                'catatan_guru' => null,
                // 'created_at' dan 'updated_at' biasanya diisi otomatis oleh Laravel jika menggunakan timestamps
                // Jadi, jika model Anda menggunakan timestamps, Anda tidak perlu menyertakan ini secara manual
            ]);
        }
        // **Akhir blok kode**

        if ($tugas_siswa) {
            $file_siswa = FileModel::where('kode', $tugas_siswa->file)->get();
        } else {
            $file_siswa = null;
        }

        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        return view('siswa.tugas.show', [
            'title' => 'Lihat Tugas',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/assets/css/components/custom-list-group.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/components/custom-media_object.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
            ',
            'menu' => [
                'menu' => 'tugas',
                'expanded' => 'tugas'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'tugas' => $tuga,
            'tugas_siswa' => $tugas_siswa,
            'files' => FileModel::where('kode', $tuga->kode)->get(),
            'file_siswa' => $file_siswa,
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tugas $tuga)
    {
        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();

        $tugas_siswa = TugasSiswa::where('kode', $tuga->kode)
            ->where('siswa_id', session()->get('id'))
            ->first();

        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        return view('siswa.tugas.edit', [
            'title' => 'Kerjakan Tugas',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/assets/css/components/custom-list-group.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/components/custom-media_object.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
            ',
            'menu' => [
                'menu' => 'tugas',
                'expanded' => 'tugas'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'tugas_siswa' => $tugas_siswa,
            'file_siswa' => FileModel::where('kode', $tugas_siswa->file)->get(),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tugas $tuga)
    {
        $tugas_siswa = TugasSiswa::where('kode', $tuga->kode)
            ->where('siswa_id', session()->get('id'))
            ->first();
        if ($tugas_siswa->file == null) {
            $kode_file = Str::random(20);
        } else {
            $kode_file = $tugas_siswa->file;
        }

        if ($tugas_siswa->date_send == null) {
            $time = Carbon::now();
            $date_send = $time->toDateTimeString();
        } else {
            $date_send = $tugas_siswa->date_send;
        }

        if ($tugas_siswa->is_telat == null) {

            if (strtotime($date_send) > strtotime($tuga->due_date)) {
                $is_telat = 1;
            } else {
                $is_telat = 0;
            }
        } else {
            $is_telat = $tugas_siswa->is_telat;
        }

        $tugas = [
            'teks' => $request->teks,
            'file' => $kode_file,
            'date_send' => $date_send,
            'is_telat' => $is_telat,
        ];

        if ($request->file('files')) {
            $files = [];
            foreach ($request->file('files') as $file) {
                array_push($files, [
                    'kode' => $tugas['file'],
                    'nama' => Str::replace('assets/files/', '', $file->store('assets/files'))
                ]);
            }
            FileModel::insert($files);
        }
        TugasSiswa::where('id', $tugas_siswa->id)
            ->update($tugas);


        return redirect('/siswa/tugas/' . $tuga->kode)->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'tugas sudah dikerjakan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugas $tugas)
    {
        //
    }

    public function kerjakan(TugasSiswa $tugas_siswa)
    {
        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();

        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        return view('siswa.tugas.kerjakan', [
            'title' => 'Kerjakan Tugas',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/assets/css/components/custom-list-group.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/components/custom-media_object.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
            ',
            'menu' => [
                'menu' => 'tugas',
                'expanded' => 'tugas'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'tugas_siswa' => $tugas_siswa,
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian
        ]);
    }
}
