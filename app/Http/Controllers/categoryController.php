<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModelCategory;
use App\lib\ConsumeLibrary;
use App\lib\RequestLibrary;


class categoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
        $this->consumeLibrary = new ConsumeLibrary;
        $this->requestLibrary = new RequestLibrary;
    }

    public function getAllCategory(){
        $data = DB::table('db_kategori')->orderBy('id_kategori','desc')->paginate(10);
        return $this->consumeLibrary->response($data,'read');
    }

    public function getCategory($idKategori){
        $data = DB::table('db_kategori')->where('id_kategori',$idKategori)->get();

        return $this->consumeLibrary->response($data,'read');
    }

    public function addCategory(Request $request){
        $this->validate($request, [
            'nama_kategori' => 'required|string',
        ]);

        ModelCategory::create([
            'id_kategori' => $this->requestLibrary->createId("Category"),
            'nama_kategori' => $request->input('nama_kategori')
        ]);

        return $this->consumeLibrary->response([],'create');
    }

    

    public function updateCategory(Request $request, $idCategory)
    {
        $this->validate($request, [
            'nama_kategori' => 'required|string',
        ]);

        ModelCategory::where('id_kategori',$idCategory)->update([
            'nama_kategori' => $request->input('nama_kategori')
        ]);
    
        return $this->consumeLibrary->response('','update');
    }

    public function deleteCategory($idCategory)
    {
        $data = DB::table("db_kategori")->where('id_kategori',$idCategory)->delete();
    
        return $this->consumeLibrary->response('','delete');
    }

    public function searchCategory(Request $request){
        $namaKategori = $request->input('nama_kategori');
        $idKategori = $request->input('id_kategori');

        $data = ModelCategory::where('nama_kategori', 'like',"%".$namaKategori."%")
            ->where('id_kategori', 'like',"%".$idKategori."%")
            ->orderBy('id_kategori','desc')
            ->paginate(10);

        return $this->consumeLibrary->response($data,'read');
    }
}

