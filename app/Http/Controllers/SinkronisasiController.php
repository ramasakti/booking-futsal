<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use App\Models\{
    InstitusiModel,
    User,
    KelasModel,
    UserRoleModel,
};

class SinkronisasiController extends Controller
{
    public function index()
    {
        return view('sync.index', [
            'title' => 'Sinkronisasi Data'
        ]);
    }

    public function sync(Request $request)
    {
        $client = new Client();

        $filter = json_encode(['tahun' => $request->query('tahun')]);

        // Inisiasi token
        $payload = [
            'nip' => '000000',
            'iss' => "RaudlLatul Jannah",
            'iat' => time(),
            'exp' => time() + 60 * 60, // 1 hour
            'data' => [
                'type' => 'internal',
                'nip' => '000000',
            ]
        ];
        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        // Get data SD1
        $kelasSD1 = $client->request('GET', env('RAPORT_SD1_URL') . "/api/data/kelas?sort=asc&filter=$filter");
        $kelasSD1Data = $kelasSD1->getBody()->getContents();
        $kelasSD1Data = json_decode($kelasSD1Data)->data;

        // Get data SD2
        $kelasSD2 = $client->request('GET', env('RAPORT_SD2_URL') . "/api/data/kelas?sort=asc&filter=$filter");
        $kelasSD2Data = $kelasSD2->getBody()->getContents();
        $kelasSD2Data = json_decode($kelasSD2Data)->data;

        // Get data tahun ajaran PS
        $taPS = DB::connection("ps")->table('tahun_ajaran')
            ->where('mulai', $request->query('tahun'))
            ->first();

        // Ambil data jenjang
        $jenjangPS = DB::connection("ps")->table('master_jenjang')->get();

        // Tampung data kelas disini
        $kelasPSMergeData = [];

        // Get data kelas 
        DB::transaction(
            function () use (
                $client,
                $token,
                $taPS,
                $jenjangPS,
                &$kelasPSMergeData,
                $request,
                $kelasSD1Data,
                $kelasSD2Data
            ) {
                foreach ($jenjangPS as $jenjang) {
                    $kelasPS = $client->request('GET',  env('RAPORT_PS_URL') . "/Data/Walikelas/data_awal?id_tahunajaran=$taPS->id&id_jenjang=$jenjang->id");
                    $kelasPSData = $kelasPS->getBody()->getContents();

                    // Institusi
                    $dataInstitusiPS = InstitusiModel::where('institusi', 'PS')->first();

                    // Konversi ke object
                    $data = json_decode($kelasPSData)->data;

                    foreach ($data as $walas) {
                        // Get user dari SDM
                        $userSDM = $client->request('GET', env('SDM_URL') . "/api/v1/getPegawaiByNip?nip=$walas->nip", [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $token,
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ]
                        ]);
                        $userDetail = $userSDM->getBody()->getContents();
                        $userDetail = json_decode($userDetail)->data;

                        if ($userDetail) {
                            // Jika ada di sdm
                            $user = User::where('nip', $userDetail->nip)
                                ->orWhere('email', $userDetail->email_k)
                                ->first();

                            if ($user) {
                                // update
                                $user->update([
                                    'name' => $userDetail->nama,
                                    'username' => $userDetail->nip,
                                    'email' => $userDetail->email_k,
                                ]);
                            } else {
                                // create
                                $user = User::create([
                                    'name' => $userDetail->nama,
                                    'username' => $userDetail->nip,
                                    'email' => $userDetail->email_k,
                                    'nip' => $userDetail->nip,
                                    'password' => bcrypt('luhurbudi')
                                ]);
                            }

                            // Masukkan data kelas
                            KelasModel::create([
                                'institusi_id' => $dataInstitusiPS->id,
                                'jenjang' => $walas->jenjang,
                                'nama_kelas' => $walas->kelas,
                                'walas_id' => $user->id
                            ]);

                            // Tambahkan user role walas
                            UserRoleModel::create([
                                'user_id' => $user->id,
                                'role_id' => 3
                            ]);
                        }
                    }

                    // Simpan ke array untuk return
                    array_push($kelasPSMergeData, $data);
                }

                // Get data tahun ajaran smp
                $taSMP = DB::connection("smp")->table('master_tahunajaran')
                    ->where('mulai', $request->query('tahun'))
                    ->first();

                // Ambil data jenjang
                $jenjangSMP = DB::connection("ps")->table('master_jenjang')->where('id', '!=', 1)->get();

                // Tampung data kelas disini
                $kelasSMPMergeData = [];

                // Get data kelas 
                foreach ($jenjangSMP as $jenjang) {
                    $kelasSMP = $client->request('GET',  env('RAPORT_SMP_URL') . "/Data/Walikelas/data_awal?id_tahunajaran=$taSMP->id&id_jenjang=$jenjang->id");
                    $kelasSMPData = $kelasSMP->getBody()->getContents();

                    // Institusi
                    $dataInstitusiSMP = InstitusiModel::where('institusi', 'SMP')->first();

                    // Konversi ke object
                    $data = json_decode($kelasSMPData)->data;

                    foreach ($data as $walas) {
                        // Get user dari SDM
                        $userSDM = $client->request('GET', env('SDM_URL') . "/api/v1/getPegawaiByNip?nip=$walas->nip", [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $token,
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ]
                        ]);
                        $userDetail = $userSDM->getBody()->getContents();
                        $userDetail = json_decode($userDetail)->data;

                        if ($userDetail) {
                            // Jika ada di sdm
                            $user = User::where('nip', $userDetail->nip)
                                ->orWhere('email', $userDetail->email_k)
                                ->first();

                            if ($user) {
                                // update
                                $user->update([
                                    'name' => $userDetail->nama,
                                    'username' => $userDetail->nip,
                                    'email' => $userDetail->email_k,
                                ]);
                            } else {
                                // create
                                $user = User::create([
                                    'name' => $userDetail->nama,
                                    'username' => $userDetail->nip,
                                    'email' => $userDetail->email_k,
                                    'nip' => $userDetail->nip,
                                    'password' => bcrypt('luhurbudi')
                                ]);
                            }

                            // Masukkan data kelas
                            KelasModel::create([
                                'institusi_id' => $dataInstitusiSMP->id,
                                'jenjang' => $walas->jenjang,
                                'nama_kelas' => $walas->kelas,
                                'walas_id' => $user->id
                            ]);

                            // Tambahkan user role walas
                            UserRoleModel::create([
                                'user_id' => $user->id,
                                'role_id' => 3
                            ]);
                        }
                    }

                    // Simpan ke array untuk return
                    array_push($kelasSMPMergeData, json_decode($kelasSMPData)->data);
                }

                // Get data tahun ajaran SMA
                $taSMA = DB::connection("sma")->table('master_tahunpelajaran')
                    ->where('mulai', $request->query('tahun'))
                    ->first();

                // Ambil data jenjang
                $jenjangSMA = DB::connection("ps")->table('master_jenjang')->get();

                // Tampung data kelas disini
                $kelasSMAMergeData = [];

                // Get data kelas 
                foreach ($jenjangSMA as $jenjang) {
                    $kelasSMA = $client->request('GET',  env('RAPORT_SMA_URL') . "/Data/Walikelas/data_awal?id_tahunajaran=$taSMA->id&id_jenjang=$jenjang->id");
                    $kelasSMAData = $kelasSMA->getBody()->getContents();

                    // Institusi
                    $dataInstitusiSMA = InstitusiModel::where('institusi', 'SMA')->first();

                    // Konversi ke object
                    $data = json_decode($kelasSMAData)->data;

                    foreach ($data as $walas) {
                        // Get user dari SDM
                        $userSDM = $client->request('GET', env('SDM_URL') . "/api/v1/getPegawaiByNip?nip=$walas->nip", [
                            'headers' => [
                                'Authorization' => 'Bearer ' . $token,
                                'Content-Type' => 'application/json',
                                'Accept' => 'application/json',
                            ]
                        ]);
                        $userDetail = $userSDM->getBody()->getContents();
                        $userDetail = json_decode($userDetail)->data;

                        if ($userDetail) {
                            // Jika ada di sdm
                            $user = User::where('nip', $userDetail->nip)
                                ->orWhere('email', $userDetail->email_k)
                                ->first();

                            if ($user) {
                                // update
                                $user->update([
                                    'name' => $userDetail->nama,
                                    'username' => $userDetail->nip,
                                    'email' => $userDetail->email_k,
                                ]);
                            } else {
                                // create
                                $user = User::create([
                                    'name' => $userDetail->nama,
                                    'username' => $userDetail->nip,
                                    'email' => $userDetail->email_k,
                                    'nip' => $userDetail->nip,
                                    'password' => bcrypt('luhurbudi')
                                ]);
                            }

                            // Masukkan data kelas
                            KelasModel::create([
                                'institusi_id' => $dataInstitusiSMA->id,
                                'jenjang' => $walas->jenjang,
                                'nama_kelas' => $walas->nama_kelas,
                                'walas_id' => $user->id
                            ]);

                            // Tambahkan user role walas
                            UserRoleModel::create([
                                'user_id' => $user->id,
                                'role_id' => 3
                            ]);
                        }
                    }

                    // Simpan ke array untuk return
                    array_push($kelasSMAMergeData, json_decode($kelasSMAData)->data);
                }
            }
        );

        return response()->json([
            'message' => 'Berhasil sinkronisasi data!'
        ], 200);
    }

    public function siswa() {}
}
