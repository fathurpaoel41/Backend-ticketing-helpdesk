<?php
namespace App\Http\Controllers;
use App\Models\ModelTicket;
use App\Models\ModelTracking;
use App\Models\ModelRejected;
use App\lib\ConsumeLibrary;
use App\lib\RequestLibrary;
use Illuminate\Http\Request;
use DB;


class TicketController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
        $this->consumeLibrary = new ConsumeLibrary;
        $this->requestLibrary = new RequestLibrary;
    }

    public function readTicket($idTicket){
        $data = DB::table('db_ticket')
            ->select('db_ticket.*', 'db_kategori.nama_kategori','u1.nama AS nama_user','u2.nama AS nama_assigned','db_feedback.feedback','db_solusi.solusi','db_rejected.reason')
            ->leftJoin('db_kategori', 'id_kategori', '=', 'db_ticket.kategori')
            ->leftJoin('users AS u1', 'u1.id', '=', 'db_ticket.id_user')
            ->leftJoin('users AS u2', 'u2.id', '=', 'db_ticket.assigned')
            ->leftJoin('db_feedback', 'db_feedback.id_ticket', '=', 'db_ticket.id_ticket')
            ->leftJoin('db_solusi', 'db_solusi.id_ticket', '=', 'db_ticket.id_ticket')
            ->leftJoin('db_rejected', 'db_rejected.id_ticket', '=', 'db_ticket.id_ticket')
            ->where("db_ticket.id_ticket",$idTicket)
            ->get();
        return $this->consumeLibrary->response($data,'read');
    }

    public function inputTicket(Request $request){
        $this->validate($request, [
            'kategori' => 'required|string|min:3',
            'problem_detail' => 'required|string|min:5',
            'id_user' => 'required'
        ]);

        $idTicket = $this->requestLibrary->createId("Ticket");

        $query = new ModelTicket();
        $query->id_ticket = $idTicket;
        $query->tanggal_dibuat = $this->requestLibrary->timeNow();
        $query->id_user = $request->input('id_user');
        $query->kategori = $request->input('kategori');
        $query->problem_detail = $request->input('problem_detail');
        $query->status = "Waiting Confirmation";
        $query->save();
        $this->createIdTracking($idTicket);

        return $this->consumeLibrary->response([],'create');
    }

    public function readTicketIdClient(Request $request){
        $data = DB::table('db_ticket')
        ->select('db_ticket.*', 'db_kategori.nama_kategori','u1.nama AS nama_user','u2.nama AS nama_assigned','db_feedback.feedback','db_rejected.reason')
        ->leftJoin('db_kategori', 'id_kategori', '=', 'db_ticket.kategori')
        ->leftJoin('users AS u1', 'u1.id', '=', 'db_ticket.id_user')
        ->leftJoin('users AS u2', 'u2.id', '=', 'db_ticket.assigned')
        ->leftJoin('db_feedback', 'db_feedback.id_ticket', '=', 'db_ticket.id_ticket')
        ->leftJoin('db_rejected', 'db_rejected.id_ticket', '=', 'db_ticket.id_ticket');
        if ($request->has('id_user')){
            $data->where('db_ticket.id_user',$request->input('id_user'));
        }
        else if ($request->has('assigned')){
            $data->where('db_ticket.assigned',$request->input('assigned'));
        }
        $data->orderBy('db_ticket.id_ticket','DESC');
        $result= $data->paginate(10);

        return $this->consumeLibrary->response($result,'read');
    }

    public function readTicketIT(){
        $data = DB::table('db_ticket')
        ->select('db_ticket.*', 'db_kategori.nama_kategori','u1.nama AS nama_user','u2.nama AS nama_assigned','db_feedback.feedback')
        ->leftJoin('db_kategori', 'id_kategori', '=', 'db_ticket.kategori')
        ->leftJoin('users AS u1', 'u1.id', '=', 'db_ticket.id_user')
        ->leftJoin('users AS u2', 'u2.id', '=', 'db_ticket.assigned')
        ->leftJoin('db_feedback', 'db_feedback.id_ticket', '=', 'db_ticket.id_ticket')
        ->orderBy('db_ticket.id_ticket','DESC')
        ->paginate(10);
        return $this->consumeLibrary->response($data,'read');
    }

    public function searchTicket(Request $request){
        $idTicket = $request->input('id_ticket');
        $tanggalDibuatAwal = $request->input('tanggal_dibuat_awal');
        $tanggalDibuatAkhir = $request->input('tanggal_dibuat_akhir');
        $tanggalSolvedAwal = $request->input('tanggal_solved_awal');
        $tanggalSolvedAkhir = $request->input('tanggal_solved_akhir');
        $kategori = $request->input('kategori');
        $status = $request->input('status');
        $idUser = $request->input('id_user');

        $data = \DB::table('db_ticket')
            ->select('db_ticket.*', 'db_kategori.nama_kategori','u1.nama AS nama_user','u2.nama AS nama_assigned','db_feedback.feedback')
            ->leftJoin('db_kategori', 'id_kategori', '=', 'db_ticket.kategori')
            ->leftJoin('users AS u1', 'u1.id', '=', 'db_ticket.id_user')
            ->leftJoin('users AS u2', 'u2.id', '=', 'db_ticket.assigned')
            ->leftJoin('db_feedback', 'db_feedback.id_ticket', '=', 'db_ticket.id_ticket')
            ->whereRaw('db_ticket.kategori like "%'.$kategori.'%"')
            ->whereRaw('db_ticket.status like "%'.$status.'%"')
            ->when(request()->tanggal_dibuat_awal, function ($query, $tanggalDibuatAwal) {
                $query->where('db_ticket.tanggal_dibuat', '>=', $tanggalDibuatAwal);})
            ->when(request()->tanggal_dibuat_akhir, function ($query, $tanggalDibuatAkhir) {
                $query->where('db_ticket.tanggal_dibuat', '<=', $tanggalDibuatAkhir);})
            ->when(request()->tanggal_solved_awal, function ($query, $tanggalSolvedAwal) {
                $query->where('db_ticket.tanggal_solved', '>=', $tanggalSolvedAwal);})
            ->when(request()->tanggal_solved_akhir, function ($query, $tanggalSolvedAkhir) {
            $query->where('db_ticket.tanggal_solved', '<=', $tanggalSolvedAkhir);});
            if ($request->has('id_user')){
                $data->where('db_ticket.id_user',$request->input('id_user'));
            }
            else if ($request->has('assigned')){
                $data->where('db_ticket.assigned',$request->input('assigned'));
            }
            $data->orderBy('db_ticket.id_ticket','DESC');
            $result= $data->paginate(10);

            // return response()->json(["data"=>$data]);
            return $this->consumeLibrary->response($result,'read');
    }

    private function createIdTracking($idTicket){
        $query = new ModelTracking();
        $query->id_ticket = $idTicket;
        $query->tanggal = $this->requestLibrary->timeNow();
        $query->status = "Waiting Confirmation";
        $query->save();
    }

    public function doneTicket(Request $request){
        $idTicket = $request->input('id_ticket');
        
        DB::table('db_solusi')->insert(
            ['id_ticket' => $idTicket, 'solusi' => $request->input('solusi')]
        );

        ModelTicket::where('id_ticket',$idTicket)->update(['status' => "Done","tanggal_solved" => $this->requestLibrary->timeNow()]);
        $this->doneTracking($idTicket);

        return $this->consumeLibrary->response([],'create');
    }

    public function approvalTicket(Request $request){
        $idTicket = $request->input('id_ticket');
        $status = $request->input('status');
        if ($status == "Confirmed"){
            try{
                ModelTicket::where('id_ticket',$idTicket)->update([
                        'assigned' => $request->input('assigned'),
                        'status' => $status,
                    ]);
        
                $this->approvalIdTracking($idTicket, $status);
        
                return $this->consumeLibrary->response('','update');
            }catch(Exception $e){
                return response()->json([
                    "status" => false,
                    "error" => $e
                ],401);
            }
        }else{
            try{
                ModelTicket::where('id_ticket',$idTicket)->update([
                        'assigned' => $request->input('assigned'),
                        'status' => $status,
                    ]);
        
                ModelRejected::create([
                    "id_rejected"=> $this->requestLibrary->createId("Rejected"),
                    "id_ticket"=>$idTicket,
                    "reason"=>$request->input("reason")
                ]);

                $this->approvalIdTracking($idTicket, $status);
        
                return $this->consumeLibrary->response('','update');
            }catch(Exception $e){
                return response()->json([
                    "status" => false,
                    "message" => $e
                ],401);
            }
        }
    }
    
    private function approvalIdTracking($idTicket, $status){
        $query = new ModelTracking();
        $query->id_ticket = $idTicket;
        $query->tanggal = $this->requestLibrary->timeNow();
        $query->status = $status;
        $query->save();
    }

    private function doneTracking($idTicket){
        $query = new ModelTracking();
        $query->id_ticket = $idTicket;
        $query->tanggal = $this->requestLibrary->timeNow();
        $query->status = "Done";
        $query->save();
    }

    //Untuk Dashboard ITOperator
    public function getTicketInProgress(){
        $data = DB::table("db_ticket")
        ->select('db_ticket.*', 'db_kategori.nama_kategori','u1.nama AS nama_user','u2.nama AS nama_assigned','db_feedback.feedback')
        ->leftJoin('db_kategori', 'id_kategori', '=', 'db_ticket.kategori')
        ->leftJoin('users AS u1', 'u1.id', '=', 'db_ticket.id_user')
        ->leftJoin('users AS u2', 'u2.id', '=', 'db_ticket.assigned')
        ->leftJoin('db_feedback', 'db_feedback.id_ticket', '=', 'db_ticket.id_ticket')
        ->whereNotIn('status',['Done'])
        ->orderBy('id_ticket','desc')
        ->limit(10)
        ->get();
        return response()->json([
                   'status' => true,
                   'message' => "Data Berhasil Diambil",
                   'data' => $data
                ],200);
    }

}

