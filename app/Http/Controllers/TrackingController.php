<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModelTracking;
use App\Models\ModelTicket;
use App\lib\ConsumeLibrary;
use App\lib\RequestLibrary;

class TrackingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
        $this->requestLibrary = new RequestLibrary;
        $this->consumeLibrary = new ConsumeLibrary;
    }

    public function readAllTracking($idTicket){
        $query = DB::table('db_tracking')
        ->select('db_tracking.*', 'db_ticket.id_ticket')
        ->leftJoin('db_ticket', 'db_ticket.id_ticket', '=', 'db_tracking.id_ticket')
        ->where('db_ticket.id_ticket',$idTicket)
        ->orderBy('id','ASC')
        ->get();
        return $this->consumeLibrary->response($query,'read');
    }

    public function confirmTrackingProgress(Request $request){
        $idTicket = $request->input('id_ticket');
        ModelTracking::create([
            'id_ticket' => $idTicket,
            'tanggal' => $this->requestLibrary->timeNow(),
            'status' => 'Progress'
        ]);

        $this->changeProgressTicket($idTicket);

        return $this->consumeLibrary->response([],'create');
    }

    private function changeProgressTicket($idTicket){
        ModelTicket::where('id_ticket',$idTicket)->update([
                'status' => "Progress",
            ]);
    }

    public function doneTracking(Request $request){
        ModelTracking::create([
            'id_tracking' => $request->input('id_tracking'),
            'id_ticket' => $request->input('id_ticket'),
            'tanggal' => $this->requestLibrary->timeNow(),
            'status' => 'Done',
            'deskripsi' => $request->input('deskripsi')
        ]);

        return $this->consumeLibrary->response([],'create');
    }
}

