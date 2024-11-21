<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\TugasSiswa;
use App\Models\PgSiswa;
use App\Models\EssaySiswa;
use App\Models\DetailUjian;
use App\Models\WaktuUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa_id = session()->get('id');
        $siswa = Siswa::firstWhere('id', $siswa_id);
        
        // Mengambil notifikasi tugas dan ujian
        $notif_tugas = TugasSiswa::where('siswa_id', $siswa_id)
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', $siswa_id)
            ->where('selesai', null)
            ->get();
        
        // Mengambil materi berdasarkan kelas siswa
        $materi = Materi::where('kelas_id', $siswa->kelas_id)->get();

        // Mengambil semua hasil ujian pilihan ganda untuk siswa
        $maxID = PgSiswa::max('id');
        $hasil_pg = PgSiswa::where('id', $maxID)->first();
        $count = PgSiswa::where('kode', $hasil_pg->kode)->count();

        // Inisialisasi variabel untuk menghitung jawaban
        $benar = 0;
        $salah = 0;
        $tidakDijawab = 0;

        $soal_pg = PgSiswa::where('kode', $hasil_pg->kode)->get();
        // Menghitung jumlah jawaban benar, salah, dan tidak dijawab
        foreach ($soal_pg as $soal) {
            if ($soal->benar === 1) {
                $benar++;
            } elseif ($soal->benar === 0) {
                $salah++;
            } else {
                // Anggap sebagai tidak dijawab jika bukan 0 atau 1
                $tidakDijawab++;
            }
        }
 
        // Menghitung nilai ujian
        $total_soal_pg = $soal_pg->count();
        $nilai = $total_soal_pg > 0 ? ($benar / $total_soal_pg) * 100 : 0;

        // Mengambil hasil ujian esai
        $hasil_essay = EssaySiswa::where('siswa_id', $siswa_id)->get();

        // Mengambil detail tipe soal
        $tipe_soal = [];
        foreach ($soal_pg as $pg) {
            $detail = DetailUjian::find($pg->detail_ujian_id);
            if ($detail) {
                $tipe_soal[$detail->tipe_soal][] = $pg->benar;
            }
        }
        // Menghitung tipe soal yang perlu ditingkatkan
        $needs_improvement = [];
        foreach ($tipe_soal as $tipe => $results) {
            $correct_count = count(array_filter($results, function($value) {
                return $value === 1; // Menghitung jawaban benar
            }));
            $total_count = count($results);
            if ($total_count > 0 && ($correct_count / $total_count < 0.5)) {
                $needs_improvement[] = $tipe;
            }
        }
        


        return view('siswa.dashboard', [
            'title' => 'Dashboard Siswa',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/dashboard/dash_2.css" rel="stylesheet" type="text/css" />
                <link href="' . url("/assets/cbt-malela") . '/assets/css/elements/infobox.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/assets/js/dashboard/dash_1.js"></script>
            ',
            'menu' => [
                'menu' => 'dashboard',
                'expanded' => 'dashboard'
            ],
            'siswa' => $siswa,
            'materi' => $materi,
            'tugas' => TugasSiswa::where('siswa_id', $siswa_id)->get(),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', $siswa_id)->get(),
            'notif_ujian' => $notif_ujian,
            'hasil_pg' => $hasil_pg,
            'benar' => $benar,
            'salah' => $salah,
            'tidakDijawab' => $tidakDijawab,
            'nilai' => round($nilai),
            'hasil_essay' => $hasil_essay,
            'needs_improvement' => $needs_improvement,
        ]);
    }
    public function profile()
    {
        $notif_tugas = TugasSiswa::where('siswa_id', session()->get('id'))
            ->where('date_send', null)
            ->get();
        $notif_ujian = WaktuUjian::where('siswa_id', session()->get('id'))
            ->where('selesai', null)
            ->get();

        return view('siswa.profile', [
            'title' => 'My Profile',
            'plugin' => '
                <link href="' . url("assets/cbt-malela") . '/assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
            ',
            'menu' => [
                'menu' => 'profile',
                'expanded' => 'profile'
            ],
            'siswa' => Siswa::firstWhere('id', session()->get('id')),
            'notif_tugas' => $notif_tugas,
            'notif_materi' => Notifikasi::where('siswa_id', session()->get('id'))->get(),
            'notif_ujian' => $notif_ujian
        ]);
    }
    public function edit_profile(Siswa $siswa, Request $request)
    {
        $rules = [
            'nama_siswa' => 'required|max:255',
            'avatar' => 'image|file|max:1024',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('avatar')) {
            if ($request->gambar_lama) {
                if ($request->gambar_lama != 'default.png') {
                    Storage::delete('assetsuser-profile/' . $request->gambar_lama);
                }
            }
            $validatedData['avatar'] = str_replace('assets/user-profile/', '', $request->file('avatar')->store('assets/user-profile'));
        }
        Siswa::where('id', $siswa->id)
            ->update($validatedData);

        return redirect('/siswa/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'profile updated!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function edit_password(Request $request, Siswa $siswa)
    {
        if (Hash::check($request->current_password, $siswa->password)) {
            $data = [
                'password' => bcrypt($request->password)
            ];
            siswa::where('id', $siswa->id)
                ->update($data);

            return redirect('/siswa/profile')->with('pesan', "
                <script>
                    swal({
                        title: 'Success!',
                        text: 'password updated!',
                        type: 'success',
                        padding: '2em'
                    })
                </script>
            ");
        }

        return redirect('/siswa/profile')->with('pesan', "
            <script>
                swal({
                    title: 'Error!',
                    text: 'current password salah!',
                    type: 'error',
                    padding: '2em'
                })
            </script> 
        ");
    }
}
