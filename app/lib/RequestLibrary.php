<?php

namespace App\lib;
use DB;

class RequestLibrary {
    public function createId($type){
        $idTerakhir;
        $idTerakhir = null;

        if($type === "Ticket"){
            $ambilIdTerakhir = DB::table('db_ticket')->orderBy('id_ticket', 'desc')->limit(1)->get();
            foreach($ambilIdTerakhir as $key=>$value){
                $idTerakhir = $value->id_ticket;
            }
        }else if($type === "Tracking"){
            $ambilIdTerakhir = DB::table('db_tracking')->orderBy('id_tracking', 'desc')->limit(1)->get();
            foreach($ambilIdTerakhir as $key=>$value){
                $idTerakhir = $value->id_tracking;
            }
        }else if($type === "Category"){
            $ambilIdTerakhir = DB::table('db_kategori')->orderBy('id_kategori', 'desc')->limit(1)->get();
            foreach($ambilIdTerakhir as $key=>$value){
                $idTerakhir = $value->id_kategori;
            }
        }else if($type === "Divisi"){
            $ambilIdTerakhir = DB::table('db_divisi')->orderBy('id_divisi', 'desc')->limit(1)->get();
            foreach($ambilIdTerakhir as $key=>$value){
                $idTerakhir = $value->id_divisi;
            }
        }else if($type === "Feedback"){
            $ambilIdTerakhir = DB::table('db_feedback')->orderBy('id_feedback', 'desc')->limit(1)->get();
            foreach($ambilIdTerakhir as $key=>$value){
                $idTerakhir = $value->id_feedback;
            }
        }else if($type === "Rejected"){
            $ambilIdTerakhir = DB::table('db_rejected')->orderBy('id_rejected', 'desc')->limit(1)->get();
            echo $ambilIdTerakhir;
            foreach($ambilIdTerakhir as $key=>$value){
                $idTerakhir = $value->id_rejected;
            }
        }
        if($idTerakhir==null){
            $idTerakhir=0;
        }
        $id = (int)substr($idTerakhir, 3);
        $kodeId = $this->kodeUser($type);
        $num = strval($id+1);
        if(strlen($num)==1){
            return $idUser = $kodeId . "00" . $num;
        }else if(strlen($num)==2){
            return $idUser = $kodeId . "0" . $num;
        }
        else{
            return $idUser = $kodeId . $num;
        }
    }

    private function kodeUser($type){
        switch ($type) {
        case "Ticket":
            return "TKT";
            break;
        case "Tracking":
            return "TRC";
            break;
        case "Category":
            return "CTG";
            break;
        case "Divisi":
            return "DVS";
            break;
        case "Feedback":
            return "FBC";
            break;
        case "Rejected":
            return "RJT";
            break;
        default:
            return "IDS";
        }
    }

    public function timeNow(){
        $timeNow=time();
        return date("Y-m-d",$timeNow);
    }
}