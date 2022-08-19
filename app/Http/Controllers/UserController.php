<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModelUser;
use App\lib\ConsumeLibrary;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
        $this->consumeLibrary = new ConsumeLibrary;
    }

    public function getAllUser(){
        $data = DB::table('users')
            ->join('db_divisi', 'id_divisi', '=', 'users.divisi')
            ->select('users.*', 'db_divisi.nama_divisi')
            ->orderBy('id','desc')
            ->paginate(10);

        return $this->consumeLibrary->response($data,'read');
    }

    public function getUser($id){
        $data = DB::table('users')
            ->join('db_divisi', 'id_divisi', '=', 'users.divisi')
            ->select('users.*', 'db_divisi.nama_divisi')
            ->where('id',$id)->get();

        return $this->consumeLibrary->response($data,'read');
    }

    public function checkEmail(Request $request){
        $user = DB::table('users')->where('email',$request->input('email'))->count();
        if ($user == 1){
            return response()->json(['message' => "Email Sudah Digunakan",'status' => false]);
        }else{
            return response()->json(['message' => "Email Bisa Digunakan", 'status' => true]);
        }
    }

    public function addUser(Request $request){
        $this->validate($request, [
            'nama' => 'required|string', 
            'email' => 'required|email|unique:users', 
            'divisi' => 'required|string', 
            'password' => 'required|string|min:3', 
        ]);

        $data = new ModelUser();
        $data->nama = $request->input('nama');
        $data->email = $request->input('email');
        $data->divisi = $request->input('divisi');
        $data->password = Hash::make($request->input('password'));

        try{
            $data->save();
            return $this->consumeLibrary->response([],'create');
        }
        catch(Exception $e){
            return response()->json(['message' => "Data Gagal Diinput", ], 500);
        }
    }

    

    public function editUser(Request $request, $id)
    {
        $data = ModelUser::find($id);

        $this->validate($request, [
            'nama' => 'required|string',
            'divisi' => 'required|string', 
            'password' => 'string|min:3', 
        ]);

        if($request->input('password') == null || empty($request->input('password'))){
            ModelUser::where('id',$id)->update([
                'nama' => $request->input('nama'),
                'divisi' => $request->input('divisi'),
            ]);
        }else{
            ModelUser::where('id',$id)->update([
                'nama' => $request->input('nama'),
                'divisi' => $request->input('divisi'),
                'password' => Hash::make($request->input('password')),
            ]);
        }
    
        return $this->consumeLibrary->response('','update');
    }

    public function deleteUser($id)
    {
        $data = ModelUser::where('id',$id)->first();
        $data->delete();
    
        return $this->consumeLibrary->response('','delete');
    }

    public function search(Request $request){
        $nama = $request->input('nama');
        $email = $request->input('email');
        $divisi = $request->input('divisi');

        $data = DB::table('users')
            ->join('db_divisi', 'id_divisi', '=', 'users.divisi')
            ->select('users.*', 'db_divisi.nama_divisi')
            ->where('users.nama', 'like',"%".$nama."%")
            ->where('users.email', 'like',"%".$email."%")
            ->where('users.divisi', 'like',"%".$divisi."%")
            ->orderBy('users.id','desc')
            ->paginate(10);

        return $this->consumeLibrary->response($data,'read');
    }

    public function filterUser(Request $request){
        $data = ModelUser::whereRaw('divisi like "%'.$request->input('divisi').'%"')->paginate(10);
        return $this->consumeLibrary->response($data,'read');
    }

    public function getUserDivisi(Request $request){
        $data = ModelUser::where('divisi','like',"%".$request->input('divisi')."%")->get();
        return $this->consumeLibrary->response($data,'read');
    }
}

