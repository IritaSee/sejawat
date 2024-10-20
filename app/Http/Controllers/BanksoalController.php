<?php

namespace App\Http\Controllers;

use App\Models\BanksoalModel;
use App\Models\DetailbankpgModel;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BankpgImport;
use App\Models\DetailbankessayModel;

class BanksoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('guru.bank-soal.index', [
            'title' => 'Data Bank Soal',
            'plugin' => '
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.css">
                <link rel="stylesheet" type="text/css" href="' . url("/assets/cbt-malela") . '/plugins/table/datatable/dt-global_style.css">
                <script src="' . url("/assets/cbt-malela") . '/plugins/table/datatable/datatables.js"></script>
                <script src="https://cdn.datatables.net/fixedcolumns/4.1.0/js/dataTables.fixedColumns.min.js"></script>
            ',
            'menu' => [
                'menu' => 'bank_soal',
                'expanded' => 'bank_soal'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'bank_soal' => BanksoalModel::where('guru_id', session()->get('id'))->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guru.bank-soal.create', [
            'title' => 'Tambah Bank Soal Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'bank_soal',
                'expanded' => 'bank_soal'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id'))
        ]);
    }
    public function bank_soal_essay()
    {
        return view('guru.bank-soal.create-essay', [
            'title' => 'Tambah Bank Soal Essay',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'bank_soal',
                'expanded' => 'bank_soal'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id'))
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kode = Str::random(30);

        $detail_bank_soal = [];
        $index = 0;
        $nama_soal =  $request->soal;
        foreach ($nama_soal as $soal) {
            array_push($detail_bank_soal, [
                'kode' => $kode,
                'soal' => $soal,
                'pg_1' => 'A. ' . $request->pg_1[$index],
                'pg_2' => 'B. ' . $request->pg_2[$index],
                'pg_3' => 'C. ' . $request->pg_3[$index],
                'pg_4' => 'D. ' . $request->pg_4[$index],
                'pg_5' => 'E. ' . $request->pg_5[$index],
                'jawaban' => $request->jawaban[$index]
            ]);

            $index++;
        }

        $bank_soal = [
            'kode' => $kode,
            'guru_id' => session()->get('id'),
            'nama' => $request->nama,
            'jenis' => 0,
            'total_soal' => $index
        ];

        BanksoalModel::create($bank_soal);
        DetailbankpgModel::insert($detail_bank_soal);

        return redirect('/guru/bank_soal')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Bank Soal di simpan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function bank_pg_excel(Request $request) {
        $kode = Str::random(30);
        $detail_bank_soal = Excel::toArray(new BankpgImport($kode), $request->excel);
        
        if (count($detail_bank_soal) < 0) {
            return redirect('/guru/bank_soal/create')->with('pesan', "
                <script>
                    swal({
                        title: 'Info!',
                        text: 'tidak ada data di dalam file yang di upload',
                        type: 'info',
                        padding: '2em'
                    })
                </script>
            ");
        }
        
        $bank_soal = [
            'kode' => $kode,
            'guru_id' => session()->get('id'),
            'nama' => $request->e_nama,
            'jenis' => 0,
            'total_soal' => count($detail_bank_soal[0])
        ];

        BanksoalModel::create($bank_soal);
        Excel::import(new BankpgImport($kode), $request->excel);

        return redirect('/guru/bank_soal')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Bank Soal di simpan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function bank_soal_essay_(Request $request)
    {
        $kode = Str::random(30);

        $detail_bank_soal = [];
        $index = 0;
        $nama_soal =  $request->soal;
        foreach ($nama_soal as $soal) {
            array_push($detail_bank_soal, [
                'kode' => $kode,
                'soal' => $soal
            ]);

            $index++;
        }

        $bank_soal = [
            'kode' => $kode,
            'guru_id' => session()->get('id'),
            'nama' => $request->nama,
            'jenis' => 1,
            'total_soal' => $index
        ];

        BanksoalModel::create($bank_soal);
        DetailbankessayModel::insert($detail_bank_soal);

        return redirect('/guru/bank_soal')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Bank Soal di simpan!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BanksoalModel  $banksoalModel
     * @return \Illuminate\Http\Response
     */
    public function show(BanksoalModel $bank_soal)
    {
        $detail_bank_soal = DetailbankpgModel::where('kode', $bank_soal->kode)->get();
        return view('guru.bank-soal.show', [
            'title' => 'Detail Bank Soal Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'bank_soal',
                'expanded' => 'bank_soal'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'bank_soal' => $bank_soal,
            'detail_bank_soal' => $detail_bank_soal
        ]);
    }
    public function show_essay(BanksoalModel $bank_soal)
    {
        $detail_bank_soal = DetailbankessayModel::where('kode', $bank_soal->kode)->get();
        return view('guru.bank-soal.show-essay', [
            'title' => 'Detail Bank Soal Essay',
            'plugin' => '
                <link href="' . url("/assets") . '/ew/css/style.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets") . '/ew/js/examwizard.js"></script>
            ',
            'menu' => [
                'menu' => 'bank_soal',
                'expanded' => 'bank_soal'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'bank_soal' => $bank_soal,
            'detail_bank_soal' => $detail_bank_soal
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BanksoalModel  $banksoalModel
     * @return \Illuminate\Http\Response
     */
    public function edit(BanksoalModel $bank_soal)
    {
        $detail_bank_soal = DetailbankpgModel::where('kode', $bank_soal->kode)->get();
        return view('guru.bank-soal.edit', [
            'title' => 'Edit Bank Soal Pilihan Ganda',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'bank_soal',
                'expanded' => 'bank_soal'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'bank_soal' => $bank_soal,
            'detail_bank_soal' => $detail_bank_soal
        ]);
    }
    public function edit_essay(BanksoalModel $bank_soal)
    {
        $detail_bank_soal = DetailbankessayModel::where('kode', $bank_soal->kode)->get();
        return view('guru.bank-soal.edit-essay', [
            'title' => 'Edit Bank Soal Essay',
            'plugin' => '
                <link href="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.css" rel="stylesheet" type="text/css" />
                <script src="' . url("/assets/cbt-malela") . '/plugins/file-upload/file-upload-with-preview.min.js"></script>
                <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
            ',
            'menu' => [
                'menu' => 'bank_soal',
                'expanded' => 'bank_soal'
            ],
            'guru' => Guru::firstWhere('id', session()->get('id')),
            'bank_soal' => $bank_soal,
            'detail_bank_soal' => $detail_bank_soal
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BanksoalModel  $banksoalModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BanksoalModel $bank_soal)
    {
        $detail_bank_soal = [];
        $index = 0;
        $nama_soal =  $request->soal;
        foreach ($nama_soal as $soal) {
            array_push($detail_bank_soal, [
                'kode' => $bank_soal->kode,
                'soal' => $soal,
                'pg_1' => 'A. ' . $request->pg_1[$index],
                'pg_2' => 'B. ' . $request->pg_2[$index],
                'pg_3' => 'C. ' . $request->pg_3[$index],
                'pg_4' => 'D. ' . $request->pg_4[$index],
                'pg_5' => 'E. ' . $request->pg_5[$index],
                'jawaban' => $request->jawaban[$index]
            ]);

            $index++;
        }

        $data_bank_soal = [
            'nama' => $request->nama,
            'total_soal' => $index
        ];

        DetailbankpgModel::where('kode', $bank_soal->kode)
                        ->delete();

        BanksoalModel::where('kode', $bank_soal->kode)
                    ->update($data_bank_soal);

        DetailbankpgModel::insert($detail_bank_soal);

        return redirect('/guru/bank_soal')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Bank Soal di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
    public function update_essay(Request $request, BanksoalModel $bank_soal)
    {
        $detail_bank_soal = [];
        $index = 0;
        $nama_soal =  $request->soal;
        foreach ($nama_soal as $soal) {
            array_push($detail_bank_soal, [
                'kode' => $bank_soal->kode,
                'soal' => $soal,
            ]);

            $index++;
        }

        $data_bank_soal = [
            'nama' => $request->nama,
            'total_soal' => $index
        ];

        DetailbankessayModel::where('kode', $bank_soal->kode)
                        ->delete();

        BanksoalModel::where('kode', $bank_soal->kode)
                    ->update($data_bank_soal);

        DetailbankessayModel::insert($detail_bank_soal);

        return redirect('/guru/bank_soal')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Bank Soal di edit!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BanksoalModel  $banksoalModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(BanksoalModel $bank_soal)
    {
        if ($bank_soal->jenis == 0) {
            DetailbankpgModel::where('kode', $bank_soal->kode)
                ->delete();
            BanksoalModel::destroy($bank_soal->id);
        }
        if ($bank_soal->jenis == 1) {
            DetailbankessayModel::where('kode', $bank_soal->kode)
                ->delete();
            BanksoalModel::destroy($bank_soal->id);
        }
                        
        return redirect('/guru/bank_soal')->with('pesan', "
            <script>
                swal({
                    title: 'Success!',
                    text: 'Bank Soal di hapus!',
                    type: 'success',
                    padding: '2em'
                })
            </script>
        ");
    }
}
