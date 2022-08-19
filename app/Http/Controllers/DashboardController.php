<?php
namespace App\Http\Controllers;
use App\Models\ModelTicket;
use App\Models\ModelCategory;
use App\lib\ConsumeLibrary;

class DashboardController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
        $this->consumeCategory = new ConsumeLibrary;
    }

    public function readAllTicket(){
        $data = ModelTicket::orderBy('id_ticket','desc')->paginate(10);
        return $this->consumeCategory->response($data,'read');
    }

    public function categoryChart(){
        $category = [];
        $idCategory = [];
        $countCategory = [];
        $dataCategory = ModelCategory::get();

        foreach ($dataCategory as $ktg){
            array_push($category,$ktg->id_kategori);
        }

        foreach ($category as $k){
            $dataCategory = ModelTicket::where('kategori',$k)->count();
            $namaCategory = ModelCategory::where('id_kategori',$k)->get();
            if($dataCategory !== 0){
                array_push($countCategory, (object)[
                        'category' => $namaCategory[0]->nama_kategori,
                        'count' => $dataCategory,
                ]);
            }
        }

        return $this->consumeCategory->response($countCategory,'read');
    }

    public function getTicketWithoutDone(){
        $data = ModelTicket::WhereNotIn('status',['Done'])->paginate(10);
        return $this->consumeCategory->response($data,'read');
    }
}

