<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ModelTicket;
use App\Models\ModelFeedback;
use App\lib\ConsumeLibrary;
use App\lib\RequestLibrary;

class FeedbackController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout']]);
        $this->requestLibrary = new RequestLibrary;
        $this->consumeLibrary = new ConsumeLibrary;
    }

    public function getFeedback($idFeedback){
        $data = ModelFeedback::where('id_feedback',$idDivisi)->get();

        return $this->consumeLibrary->response($data,'read');
    }

    public function addFeedback(Request $request){
            $this->validate($request, [
                'id_ticket' => 'required',
                'feedback' => 'required|string'
            ]);
    
            ModelFeedback::create([
                'id_feedback' => $this->requestLibrary->createId("Feedback"),
                'id_ticket' => $request->input('id_ticket'),
                'feedback' => $request->input('feedback')
            ]);
    
            return $this->consumeLibrary->response([],'create');
    }
}

