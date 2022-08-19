<?php

namespace App\Http\Controllers;
use DB;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function tes(){
        $ambilIdTerakhir = DB::table('db_tracking')->orderBy('id_tracking', 'desc')->limit(1)->get();
        return $ambilIdTerakhir;
    }

    public function migrate(){
        DB::table("db_divisi")->insert([
            "id_divisi" => "DVS001",
            "nama_divisi" => "Administrator"
        ]);

        DB::table("db_divisi")->insert([
            "id_divisi" => "DVS002",
            "nama_divisi" => "IT Support"
        ]);

        DB::table("db_divisi")->insert([
            "id_divisi" => "DVS003",
            "nama_divisi" => "IT Operator"
        ]);

        return response()->json([
            "status" => true,
            "message" => "berhasil dibuat"
        ],200);
    }
}
