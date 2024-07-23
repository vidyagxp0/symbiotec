<?php

namespace App\Http\Controllers\rcms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\RecordNumber;
use App\Models\EvaluationGrid;
use App\Models\Evaluation;
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
        $evaluation = new Evaluation();
        $evaluation->type = "Evaluation";
        $evaluation->record_number = ((RecordNumber::first()->value('counter')) + 1);
        $evaluation->initiator_id = Auth::user()->id;
        $evaluation->division_id = $request->division_id;
        $evaluation->parent_id = $request->parent_id;
        $evaluation->parent_type = $request->parent_type;
        $evaluation->initiation_date = $request->initiation_date;
        $evaluation->due_date = $request->due_date;
        $evaluation->short_description = $request->short_description;
        $evaluation->description = $request->description;
        $evaluation->reference_document = $request->reference_document;
        $evaluation->site = $request->site;
        $evaluation->department_name = $request->department_name;
        $evaluation->sop_title = $request->sop_title;
        $evaluation->sop_review_date = $request->sop_review_date;
        $evaluation->reviewer = $request->reviewer;
        $evaluation->approver = $request->approver;
        $evaluation->initiated_by = $request->initiated_by;
        $evaluation->initiated_on = $request->initiated_on;

        $evaluation->approver_feedback = $request->approver_feedback;
        $evaluation->approver_comment = $request->approver_comment;
        $evaluation->approved_by = $request->approved_by;
        $evaluation->approved_on = $request->approved_on;

        $evaluation->reviewer_feedback = $request->reviewer_feedback;
        $evaluation->reviewer_comment = $request->reviewer_comment;
        $evaluation->reviewed_by = $request->reviewed_by;
        $evaluation->reviewed_on = $request->reviewed_on;

        if (!empty($request->initial_attachment)) {
            $files = [];
            if ($request->hasfile('initial_attachment')) {
                foreach ($request->file('initial_attachment') as $file) {
                    $name = $request->name . 'initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $evaluation->initial_attachment = json_encode($files);
        }

        if (!empty($request->approver_attachment)) {
            $files = [];
            if ($request->hasfile('approver_attachment')) {
                foreach ($request->file('approver_attachment') as $file) {
                    $name = $request->name . 'approver_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $evaluation->approver_attachment = json_encode($files); 
        }

        if (!empty($request->reviewer_attachment)) {
            $files = [];
            if ($request->hasfile('reviewer_attachment')) {
                foreach ($request->file('reviewer_attachment') as $file) {
                    $name = $request->name . 'reviewer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $evaluation->reviewer_attachment = json_encode($files); 
        }

        $evaluation->status = 'Opened';
        $evaluation->stage = 1;

        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update();

        $evaluation->checkbox_1 = $request->checkbox_1;
        
        $evaluation->initiatorRemark_1 = $request->initiatorRemark_1;
        $evaluation->reviewerRemark_1 = $request->reviewerRemark_1;
        $evaluation->approverRemark_1 = $request->approverRemark_1;

        $evaluation->checkbox_2 = $request->checkbox_2;
        $evaluation->initiatorRemark_2 = $request->initiatorRemark_2;
        $evaluation->reviewerRemark_2 = $request->reviewerRemark_2;
        $evaluation->approverRemark_2 = $request->approverRemark_2;

        $evaluation->checkbox_3 = $request->checkbox_3;
        $evaluation->initiatorRemark_3 = $request->initiatorRemark_3;
        $evaluation->reviewerRemark_3 = $request->reviewerRemark_3;
        $evaluation->approverRemark_3 = $request->approverRemark_3;

        $evaluation->checkbox_4 = $request->checkbox_4;
        $evaluation->initiatorRemark_4 = $request->initiatorRemark_4;
        $evaluation->reviewerRemark_4 = $request->reviewerRemark_4;
        $evaluation->approverRemark_4 = $request->approverRemark_4;

        $evaluation->checkbox_5 = $request->checkbox_5;
        $evaluation->initiatorRemark_5 = $request->initiatorRemark_5;
        $evaluation->reviewerRemark_5 = $request->reviewerRemark_5;
        $evaluation->approverRemark_5 = $request->approverRemark_5;

        $evaluation->checkbox_6 = $request->checkbox_6;
        $evaluation->initiatorRemark_6 = $request->initiatorRemark_6;
        $evaluation->reviewerRemark_6 = $request->reviewerRemark_6;
        $evaluation->approverRemark_6 = $request->approverRemark_6;

        $evaluation->checkbox_7 = $request->checkbox_7;
        $evaluation->initiatorRemark_7 = $request->initiatorRemark_7;
        $evaluation->reviewerRemark_7 = $request->approverRemark_7;
        $evaluation->approverRemark_7 = $request->approverRemark_7;

        $evaluation->checkbox_8 = $request->checkbox_8;
        $evaluation->initiatorRemark_8 = $request->initiatorRemark_8;
        $evaluation->reviewerRemark_8 = $request->reviewerRemark_8;
        $evaluation->approverRemark_8 = $request->approverRemark_8;
        
        $evaluation->evaluation_comment = $request->evaluation_comment;
        $evaluation->save();

        toastr()->success('Record is created Successfully');
        return redirect('rcms/qms-dashboard');
    }

    public function show(Request $request, $id){
        $data = Evaluation::find($id);
        $document = Document::all();
        return view('frontend.evaluation.evaluation_view', compact("data", "document"));
    }


    public function update(Request $request, $id){
        $lastDocument = Evaluation::find($id);
        $evaluation = Evaluation::find($id);

        $evaluation->short_description = $request->short_description;
        $evaluation->description = $request->description;
        $evaluation->reference_document = $request->reference_document;
        $evaluation->site = $request->site;
        $evaluation->department_name = $request->department_name;
        $evaluation->sop_title = $request->sop_title;
        $evaluation->sop_review_date = $request->sop_review_date;
        $evaluation->reviewer = $request->reviewer;
        $evaluation->approver = $request->approver;
        $evaluation->initiated_by = $request->initiated_by;
        $evaluation->initiated_on = $request->initiated_on;

        $evaluation->approver_feedback = $request->approver_feedback;
        $evaluation->approver_comment = $request->approver_comment;
        $evaluation->approved_by = $request->approved_by;
        $evaluation->approved_on = $request->approved_on;

        $evaluation->reviewer_feedback = $request->reviewer_feedback;
        $evaluation->reviewer_comment = $request->reviewer_comment;
        $evaluation->reviewed_by = $request->reviewed_by;
        $evaluation->reviewed_on = $request->reviewed_on;

        if (!empty($request->initial_attachment)) {
            $files = [];
            if ($request->hasfile('initial_attachment')) {
                foreach ($request->file('initial_attachment') as $file) {
                    $name = $request->name . 'initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $evaluation->initial_attachment = json_encode($files);
        }

        if (!empty($request->approver_attachment)) {
            $files = [];
            if ($request->hasfile('approver_attachment')) {
                foreach ($request->file('approver_attachment') as $file) {
                    $name = $request->name . 'approver_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $evaluation->approver_attachment = json_encode($files); 
        }

        if (!empty($request->reviewer_attachment)) {
            $files = [];
            if ($request->hasfile('reviewer_attachment')) {
                foreach ($request->file('reviewer_attachment') as $file) {
                    $name = $request->name . 'reviewer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $evaluation->reviewer_attachment = json_encode($files); 
        }

        $evaluation->checkbox_1 = $request->checkbox_1;
        // dd($request->checkbox_1);
        $evaluation->initiatorRemark_1 = $request->initiatorRemark_1;
        $evaluation->reviewerRemark_1 = $request->reviewerRemark_1;
        $evaluation->approverRemark_1 = $request->approverRemark_1;

        $evaluation->checkbox_2 = $request->checkbox_2;
        $evaluation->initiatorRemark_2 = $request->initiatorRemark_2;
        $evaluation->reviewerRemark_2 = $request->reviewerRemark_2;
        $evaluation->approverRemark_2 = $request->approverRemark_2;

        $evaluation->checkbox_3 = $request->checkbox_3;
        $evaluation->initiatorRemark_3 = $request->initiatorRemark_3;
        $evaluation->reviewerRemark_3 = $request->reviewerRemark_3;
        $evaluation->approverRemark_3 = $request->approverRemark_3;

        $evaluation->checkbox_4 = $request->checkbox_4;
        $evaluation->initiatorRemark_4 = $request->initiatorRemark_4;
        $evaluation->reviewerRemark_4 = $request->reviewerRemark_4;
        $evaluation->approverRemark_4 = $request->approverRemark_4;

        $evaluation->checkbox_5 = $request->checkbox_5;
        $evaluation->initiatorRemark_5 = $request->initiatorRemark_5;
        $evaluation->reviewerRemark_5 = $request->reviewerRemark_5;
        $evaluation->approverRemark_5 = $request->approverRemark_5;

        $evaluation->checkbox_6 = $request->checkbox_6;
        $evaluation->initiatorRemark_6 = $request->initiatorRemark_6;
        $evaluation->reviewerRemark_6 = $request->reviewerRemark_6;
        $evaluation->approverRemark_6 = $request->approverRemark_6;

        $evaluation->checkbox_7 = $request->checkbox_7;
        $evaluation->initiatorRemark_7 = $request->initiatorRemark_7;
        $evaluation->reviewerRemark_7 = $request->approverRemark_7;
        $evaluation->approverRemark_7 = $request->approverRemark_7;

        $evaluation->checkbox_8 = $request->checkbox_8;
        $evaluation->initiatorRemark_8 = $request->initiatorRemark_8;
        $evaluation->reviewerRemark_8 = $request->reviewerRemark_8;
        $evaluation->approverRemark_8 = $request->approverRemark_8;
        
        $evaluation->evaluation_comment = $request->evaluation_comment;

        $evaluation->update();

        toastr()->success('Record is Upddated Successfully');
        return back();
    }

    public function getDocDetail($id)
    {
        $doc = Document::find($id);
        return response()->json($doc);
    }
}
