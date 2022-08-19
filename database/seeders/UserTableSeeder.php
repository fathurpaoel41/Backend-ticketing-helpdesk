<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ModelTicket;
use App\Models\ModelKategori;
use App\Models\ModelTracking;
use App\Models\ModelDivisi;
use Illuminate\Support\Facades\Hash;
use DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $user = User::create([
            'nama' => 'Administrator', 
            'email' => 'administrator@gmail.com',
            'password' => Hash::make('123456'),
            'divisi' => 'DVS001'
        ]);

        $user = ModelDivisi::create([
            'id_divisi' => 'DVS001', 
            'nama_divisi' => 'Administrator',
        ]);

        $user = ModelDivisi::create([
            'id_divisi' => 'DVS002', 
            'nama_divisi' => 'IT Support',
        ]);

        $user = ModelDivisi::create([
            'id_divisi' => 'DVS003', 
            'nama_divisi' => 'IT Operator',
        ]);

        // ModelTicket::create([
        //     'id_ticket' => 'TKT030',
        //     'tanggal_dibuat' => date("Y-m-d",time()),
        //     'tanggal_solved' => date("Y-m-d",time()),
        //     'id_user' => 4,
        //     'kategori' => "Wifi",
        //     'problem_detail' => 'blablababla',
        //     'status' => 'Progress',
        //     'id_tracking' => 'TRC001',
        // ]);

        // ModelTracking::create([
            // 'id_tracking' => 'TRC008',
            // 'id_ticket' => 'TKT008',
            // 'tanggal' => date("Y-m-d",time()),
            // 'status' => 'Confirmation',
            // 'deskripsi' => "blablabla",
            // 'id_tracking' => 'TRC004',
            // 'id_ticket' => 'TKT004',
            // 'tanggal' => date("Y-m-d",time()),
            // 'status' => 'Confirmation',
            // 'deskripsi' => "blablabla",
            // 'id_tracking' => 'TRC005',
            // 'id_ticket' => 'TKT005',
            // 'tanggal' => date("Y-m-d",time()),
            // 'status' => 'Confirmation',
            // 'deskripsi' => "blablabla",
            // 'id_tracking' => 'TRC006',
            // 'id_ticket' => 'TKT006',
            // 'tanggal' => date("Y-m-d",time()),
            // 'status' => 'Confirmation',
            // 'deskripsi' => "blablabla",
            // 'id_tracking' => 'TRC003',
            // 'id_ticket' => 'TKT003',
            // 'tanggal' => date("Y-m-d",time()),
            // 'status' => 'Confirmation',
            // 'deskripsi' => "blablabla",
        // ]);

        // ModelKategori::create([
        //     'id_kategori' => 'KTG003',
        //     'nama_kategori' => 'Keyboard'
        // ]);

        
    }
}
