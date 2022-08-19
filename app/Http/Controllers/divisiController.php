<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModelDivisi;
use App\lib\ConsumeLibrary;
use App\lib\RequestLibrary;

class divisiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
        $this->requestLibrary = new RequestLibrary;
        $this->consumeLibrary = new ConsumeLibrary;
    }

    public function getAllDivisi(){
        $data = DB::table('db_divisi')->orderBy('id_divisi','desc')->paginate(10);
        return $this->consumeLibrary->response($data,'read');

    }

    public function getAllDivisiSelected(){
        $data = DB::table('db_divisi')->orderBy('id_divisi','desc')->get();
        return $this->consumeLibrary->response($data,'read');
    }

    public function getDivisi($idDivisi){
        $data = DB::table('db_divisi')->where('id_divisi',$idDivisi)->get();

        return $this->consumeLibrary->response($data,'read');
    }

    public function addDivisi(Request $request){
        $this->validate($request, [
            'nama_divisi' => 'required',
        ]);

        ModelDivisi::create([
            'id_divisi' => $this->requestLibrary->createId("Divisi"),
            'nama_divisi' => $request->input('nama_divisi')
        ]);

        return $this->consumeLibrary->response([],'create');
    }

    

    public function updateDivisi(Request $request, $idDivisi)
    {
        $this->validate($request, [
            'nama_divisi' => 'required|string',
        ]);

        ModelDivisi::where('id_divisi',$idDivisi)->update([
            'nama_divisi' => $request->input('nama_divisi')
        ]);
    
        return $this->consumeLibrary->response('','update');
    }

    public function deleteDivisi($idDivisi)
    {
        $data = DB::table("db_divisi")->where('id_divisi',$idDivisi)->delete();
    
        return $this->consumeLibrary->response('','delete');
    }

    public function searchDivisi(Request $request){
        $namaDivisi = $request->input('namaDivisi');
        $idDivisi = $request->input('id_Divisi');

        $data = ModelUser::where('nama_divisi', $namaDivisi)
            ->where('id_divisi', 'like',"%".$idivisi."%")
            ->orderBy('id_divisi','desc')
            ->paginate(10);

        return $this->consumeLibrary->response($data,'read');
    }
}

