<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuTamuController extends Controller
{
    public function index()
    {
        $query = DB::table('buku_tamu')->get();
        $no=0;
        $sentTo['data']=[];
        foreach ($query as $key => $qry) {
            $no++;
            $btnTamuSelesai='<div class="btn-group" role="group" aria-label="Action">';
            if (!$qry->waktu_keluar) {
                $btnTamuSelesai='<div class="btn-group" role="group" aria-label="Action"><button class="btn btn-sm btn-info btnTamuSelesai" btId="'.$qry->id.'" title="Tamu Selesai"><i class="bx bxs-time bx-xs"></i></button>';
            }
            $qry->link = $btnTamuSelesai.'
                <button class="btn btn-sm btn-success btnUpdBkTm" btId="'.$qry->id.'" title="Edit Data"><i class="bx bxs-pencil bx-xs"></i></button>
                <button class="btn btn-sm btn-danger btnDelBkTm" btId="'.$qry->id.'" title="Delete Data"><i class="bx bxs-trash bx-xs"></i></button>
            </div>';
            $qry->num = '
                <input type="checkbox" class="chkDeleteMultiBkTm" btId="'.$qry->id.'">
            '.$no;
            $data[] = $qry;
            $sentTo['data'] = $data;
        }
        return json_encode($sentTo);
    }

    public function store(Request $request)
    {
        $nama = $request->input('nama');
        $keperluan = $request->input('keperluan');
        $updated_at = now();
        DB::table('buku_tamu')->insert([
            'nama_tamu' => $nama,
            'keperluan' => $keperluan,
        ]);
    }

    public function show($id)
    {
        $query = DB::table('buku_tamu')->where('id', $id)->get();
        return $query;
    }

    public function update(Request $request, $id)
    {
        $nama = $request->input('nama');
        $keperluan = $request->input('keperluan');
        $updated_at = now();
        DB::table('buku_tamu')->where('id', $id)->update([
            'nama_tamu' => $nama,
            'keperluan' => $keperluan
        ]);
    }

    public function destroy($id)
    {
        DB::table('buku_tamu')->where('id', $id)->delete();
    }

    //Custom query
    public function tamuSelesai($id)
    {
        $diformat='%d %h:%i:%s';
        $query = DB::table('buku_tamu')->select('waktu_masuk', DB::raw('NOW()::timestamp sekarang'))->where('id', $id)->get();
        $timeIn = new \DateTime($query[0]->waktu_masuk);
        $timeOut = new \DateTime($query[0]->sekarang);
        $interval = date_diff($timeOut,$timeIn)->format($diformat);
        
        DB::table('buku_tamu')->where('id', $id)->update([
            'waktu_keluar' => $timeOut,
            'lama_kunjungan' => $interval
        ]);
    }

    public function deletebanyak(Request $request)
    {
        $mltId = explode(',',$request->input('ids'));
        $dat = DB::table('buku_tamu')->whereIn('id', $mltId)->delete();
        return $dat;
    }
}
