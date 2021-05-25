<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GolonganController extends Controller
{
    public function index()
    {
        $query = DB::table('golongans')->get();
        $no=0;
        $sentTo['data']=[];
        foreach ($query as $key => $qry) {
            $no++;
            $qry->link = '
                <button class="btn btn-danger btnDelGol" gId="'.$qry->id.'"><i class="bx bx-trash"></i></button>
                <button class="btn btn-default btnUpdGol" gId="'.$qry->id.'"><i class="bx bx-pencil"></i></button>
            ';
            $qry->num = '
                <input type="checkbox" name="chkDeleteMultiGol" class="chkDeleteMultiGol" gId="'.$qry->id.'">
            '.$no;
            $data[] = $qry;
            $sentTo['data'] = $data;
        }
        return json_encode($sentTo);
    }


    public function store(Request $request)
    {
        $nama = $request->input('nama');
        $golongan = $request->input('golongan');
        $updated_at = now();
        DB::table('golongans')->insert([
            'nama' => $nama,
            'golongan' => $golongan,
            'created_at' => now(),
        ]);
    }

    public function show($id)
    {
        $query = DB::table('golongans')->where('id', $id)->get();
        return $query;
    }

    public function update(Request $request, $id)
    {
        $nama = $request->input('nama');
        $golongan = $request->input('golongan');
        $updated_at = now();
        DB::table('golongans')->where('id', $id)->update([
            'nama' => $nama,
            'golongan' => $golongan,
            'updated_at' => $updated_at,
        ]);
    }

    public function destroy($id)
    {
        DB::table('golongans')->where('id', $id)->delete();
    }

    //Custom query
    public function deletebanyak(Request $request)
    {
        $mltId = explode(',',$request->input('ids'));
        $dat = DB::table('golongans')->whereIn('id', $mltId)->delete();
        return $dat;
    }
}
