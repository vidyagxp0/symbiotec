<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\RecordNumber;
use App\Models\Document;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Helpers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PDF;

class EvaluationController extends Controller
{
    public function index(Request $request){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $document = Document::all();
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        return view('frontend.evaluation.evaluation_new', compact("record_number", "document", "currentDate", "formattedDate"));
    }

    public function store(Request $request){
        
    }

    public function show(Request $request, $id){
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $document = Document::all();
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        return view('frontend.evaluation.evaluation_view', compact("record_number", "document", "currentDate", "formattedDate"));
    }


    public function update(Request $request, $id){
        
    }

    public function getDocDetail($id)
    {
        $doc = Document::find($id);
        return response()->json($doc);
    }
}
