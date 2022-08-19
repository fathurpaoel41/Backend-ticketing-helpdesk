<?php

namespace App\lib;

class ConsumeLibrary 
{
   public function response($data,$type){
       $funcType = $this->statusResponse($type);

       if($type === "update"){
           return response()->json([
               'status' => $funcType,
               'message' => "Data Berhasil DiUpdate",
            ],200);
       }else if($type === "delete"){
           return response()->json([
               'status' => $funcType,
               'message' => "Data Berhasil Dihapus",
            ],200);
       }else{
           if(count($data) != 0){
               return response()->json([
                   'status' => $funcType,
                   'message' => "Data Berhasil Diambil",
                   'data' => $data
                ],200);
           }else{
                return response()->json([
                   'status' => $funcType,
                   'message' => "Data Berhasil Dinput",
                   'data' => null
                ],200);
           }
       }

   }

   private function statusResponse($type){
       switch ($type) {
        case "read":
            return true;
            break;
        case "create":
            return true;
            break;
        case "update":
            return true;
            break;
        case "delete":
            return true;
            break;
        default:
            return true;
        }
   }
}