<?php

namespace App\Http\Controllers;

use App\Models\RegulatoryInspection;
use Illuminate\Http\Request;
use App\Models\RecordNumber;
use Helpers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use App\Models\QMSProcess;
use App\Models\QMSDivision;
use Illuminate\Pagination\LengthAwarePaginator;



class RegulatoryDashboardController extends Controller
{
    public function index(Request $request)
    {
        $table = [];

        $datas = RegulatoryInspection::orderByDesc('id')->get();
        foreach ($datas as $data) {
            $data->create = Carbon::parse($data->created_at)->format('d-M-Y h:i A');
            
            array_push($table, [
                "id" => $data->id,
                "parent" => $data->cc_id ? $data->cc_id : "-",
                "record" => $data->record,
                "due_date" => $data->due_date,
                "type" => "Regulatory Inspection",
                "parent_id" => $data->parent_id,
                "parent_type" => $data->parent_type,
                "division_id" => $data->division_id,
                "short_description" => $data->short_description ? $data->short_description : "-",
                "initiator_id" => $data->initiator_id,
                "initiated_through" => $data->initiated_through,
                "intiation_date" => $data->intiation_date,
                "stage" => $data->status,
                "date_open" => $data->created_at,
                "date_close" => $data->updated_at,
            ]);
        }
        $table  = collect($table)->sortBy('record')->reverse()->toArray();
        $datag = $this->paginate($table);
        $uniqueProcessNames = QMSProcess::select('process_name')->distinct()->pluck('process_name');
        return view('frontend.rcms.regulatory_dashboard', compact('datag', 'uniqueProcessNames'));
    }
    public function paginate($items, $perPage = 100000, $page = null, $options = ['path' => 'mytaskdata'])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
