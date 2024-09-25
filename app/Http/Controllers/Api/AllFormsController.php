<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActionItem;
use App\Models\Capa;
use App\Models\CC;
use App\Models\Deviation;

use App\Models\LabIncident;
use App\Models\MarketComplaint;
use App\Models\OOS;
use App\Models\OOT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Column;
use SebastianBergmann\LinesOfCode\Counter;

class AllFormsController extends Controller
{
    public function AllForms(Request $request){
        
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        try {

        $deviations = Deviation::all();
        $ChangeControl = CC::all();
        $capa = Capa::all();
        $labincident = LabIncident::all();
        $oos = OOS::all();
        $oot = OOT::all();
        $marketcomplaint = MarketComplaint::all();
        
        $res['body'] = [
            'deviations' => $deviations,
            'changecontrol' => $ChangeControl,
            'capa' => $capa,
            'labincident' => $labincident,
            'oos' => $oos,
            'oot' => $oot,
            'marketcomplaint' => $marketcomplaint
        ];


        } catch (\Exception $e) {
            $res['status'] = 'error';
            $res['message'] = $e->getMessage();
        }

        return response()->json($res);
    }
}
