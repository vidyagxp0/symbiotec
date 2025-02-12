<?php
// namespace App;
use App\Models\ActionItem;
use App\Models\Division;
use App\Models\QMSDivision;
use App\Models\User;
use App\Models\OOS_micro;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Mistralys\Diff\Diff;

use Jfcherng\Diff\Differ;
use Jfcherng\Diff\DiffHelper;
use Jfcherng\Diff\Factory\RendererFactory;
use Jfcherng\Diff\Renderer\RendererConstant;

class Helpers
{
    public static function getArrayKey(array $array, $key)
    {
        return $array && is_array($array) && array_key_exists($key, $array) ? $array[$key] : '';
    }

    public static function getDefaultResponse()
    {
        $res = [
            'status' => 'ok',
            'message' => 'success',
            'body' => []
        ];

        return $res;
    }

    public static function getDueDate($days = 30, $formatDate = true)
    {
        try {

            $date = Carbon::now()->addDays($days);
            $formatted_date = $formatDate ? $date->format("d-F-Y") : $date->format('Y-m-d');
            return $formatted_date;

        } catch (\Exception $e) {
            return "01-Jan-1999";
        }
    }
    // public static function getdateFormat($date)
    // {
    //     $date = Carbon::parse($date);
    //     $formatted_date = $date->format("d-M-Y");
    //     return $formatted_date;
    // }
    public static function getdateFormat($date)
    {
        if(empty($date)) {
            return ''; // or any default value you prefer
        }
        // else{
        else{
            $date = Carbon::parse($date);
            $formatted_date = $date->format("d-M-Y");
            return $formatted_date;
        }

    }

    public static function getdateFormat1($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-M-Y');
    }

    public static function isRevised($data)
    {
    {
        if($data  >= 8){
            return 'disabled';
        }else{
            return  '';
        }


    }}

    public static function isRiskAssessment($data)
    {   
        if($data == 0 || $data  >= 7){
            return 'disabled';
        }else{
            return  '';
        }
         
    }
    // public static function getHodUserList(){

    //     return $hodUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'4'])->get();
    // }
    // public static function getQAUserList(){

    //     return $QAUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'7'])->get();
    // }
    // public static function getInitiatorUserList(){


    //     return $InitiatorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'3'])->get();
    // }
    // public static function getApproverUserList(){


    //     return $ApproverUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'1'])->get();
    // }
    // public static function getReviewerUserList(){


    //     return $ReviewerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'2'])->get();
    // }
    // public static function getCFTUserList(){


    //     return $CFTUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'5'])->get();
    // }
    // public static function getTrainerUserList(){


    //     return $TrainerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'6'])->get();
    // }
    // public static function getActionOwnerUserList(){


    //     return $ActionOwnerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'8'])->get();
    // }
    // public static function getQAHeadUserList(){


    //     return $QAHeadUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'9'])->get();
    // }
    public static function getQCHeadUserList(){

        return $QCHeadUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'10'])->get();
    }
    // public static function getLeadAuditeeUserList(){


    //     return $LeadAuditeeUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'11'])->get();
    // }
    // public static function getLeadAuditorUserList(){


    //     return $LeadAuditorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'12'])->get();
    // }
    // public static function getAuditManagerUserList(){


    //     return $AuditManagerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'13'])->get();
    // }
    // public static function getSupervisorUserList(){


    //     return $SupervisorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'14'])->get();
    // }
    // public static function getResponsibleUserList(){


    //     return $ResponsibleUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'15'])->get();
    // }
    // public static function getWorkGroupUserList(){


    //     return $WorkGroupUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'16'])->get();
    // }
    // public static function getViewUserList(){


    //     return $ViewUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'17'])->get();
    // }
    // public static function getFPUserList(){


    //     return $FPUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'18'])->get();
    // }

    public static function checkRoles($role)
    {

        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
        if(in_array($role, $userRoleIds)){
            return true;
        }else{
            return false;
        }
        // if (strpos(Auth::user()->role, $role) !== false) {
        //    return true;
        // }else{
        //     return false;
        // }
        // }
    }

    public static function checkTMSRoles($role)
    {

        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id])->get();
        $userRoleIds = $userRoles->pluck('role_id')->toArray();
        if(in_array($role, $userRoleIds)){
            return true;
        }else{
            return false;
        }
        // if (strpos(Auth::user()->role, $role) !== false) {
        //    return true;
        // }else{
        //     return false;
        // }
    }


    public static function checkRoles_check_reviewers($document)
    {


        if ($document->reviewers) {
            $datauser = explode(',', $document->reviewers);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == Auth::user()->id) {
                    return true;
                }
            }
        } else {
            return false;
        }
        }


    public static function checkRoles_check_approvers($document)
    {
        if ($document->approvers) {
            $datauser = explode(',', $document->approvers);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == Auth::user()->id) {
                    if($document->stage >= 4){
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        } else {
            return false;
        }
    }


    public static function checkRoles_check_hods($document)
    {
        if ($document->hods) {
            $datauser = explode(',', $document->hods);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == Auth::user()->id) {
                    if($document->stage >= 2){
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        }
        return false;
    }

    public static function checkUserRolesApprovers($data)
    {
        $user = User::find($data->id);
        return $user->userRoles()->where('q_m_s_roles_id', 1)->exists();
    }

    public static function checkUserRolesreviewer($data)
    {
        $user = User::find($data->id);
        return $user->userRoles()->where('q_m_s_roles_id', 2)->exists();
    }

    public static function checkUserRolestrainer($data)
    {
        $user = User::find($data->id);
        return $user->userRoles()->where('q_m_s_roles_id', 6)->exists();
    }

    public static function checkUserRolesassign_to($data)
    {
        if ($data->role) {
            $datauser = explode(',', $data->role);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == 4) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public static function checkUserRolesMicrobiology_Person($data)
    {
        if ($data->role) {
            $datauser = explode(',', $data->role);
            for ($i = 0; $i < count($datauser); $i++) {
                if ($datauser[$i] == 5) {
                    return true;
                }
            }
        } else {
            return false;
        }
    }

    public static function divisionNameForQMS($id)
    {
        return QMSDivision::where('id', $id)->value('name');
    }

    public static function year($createdAt)
    {
        return Carbon::parse($createdAt)->format('y');
    }

    public static function getDivisionName($id)
    {
        $name = DB::table('q_m_s_divisions')->where('id', $id)->where('status', 1)->value('name');
        return $name;
    }
    public static function recordFormat($number)
    {
        return   str_pad($number, 4, '0', STR_PAD_LEFT);
    }
    public static function getInitiatorName($id)
    {
        return   User::where('id',$id)->value('name');
    }
    public static function record($id)
    {
        return   str_pad($id, 5, '0', STR_PAD_LEFT);
    }

    public static function getHodUserList(){

        return $hodUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'4'])->get();
    }
    public static function getQAUserList(){

        return $QAUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'7'])->get();
    }
    public static function getInitiatorUserList(){

        return $InitiatorUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'3'])->get();
    }
    public static function getApproverUserList(){

        return $ApproverUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'1'])->get();
    }
    public static function getReviewerUserList(){

        return $ReviewerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'2'])->get();
    }
    public static function getCFTUserList(){

        return $CFTUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'5'])->get();
    }
    public static function getTrainerUserList(){

        return $TrainerUserList = DB::table('user_roles')->where(['q_m_s_roles_id' =>'6'])->get();
    }

    static function getFullDepartmentName($code)
    {
        $full_department_name = '';

        switch ($code) {
            case 'CQA':
                $full_department_name = "Corporate Quality Assurance";
                break;
            case 'QA':
                $full_department_name = "Quality Assurance";
                break;
            case 'QC':
                $full_department_name = "Quality Control";
                break;
            case 'QM':
                $full_department_name = "Quality Control (Microbiology department)";
                break;
            case 'PG':
                $full_department_name = "Production General";
                break;
            case 'PL':
                $full_department_name = "Production Liquid Orals";
                break;
            case 'PT':
                $full_department_name = "Production Tablet and Powder";
                break;
            case 'PE':
                $full_department_name = "Production External (Ointment, Gels, Creams and Liquid)";
                break;
            case 'PC':
                $full_department_name = "Production Capsules";
                break;
            case 'PI':
                $full_department_name = "Production Injectable";
                break;
            case 'EN':
                $full_department_name = "Engineering";
                break;
            case 'HR':
                $full_department_name = "Human Resource";
                break;
            case 'ST':
                $full_department_name = "Store";
                break;
            case 'IT':
                $full_department_name = "Electronic Data Processing";
                break;
            case 'FD':
                $full_department_name = "Formulation  Development";
                break;
            case 'AL':
                $full_department_name = "Analytical research and Development Laboratory";
                break;
            case 'PD':
                $full_department_name = "Packaging Development";
                break;
            case 'PU':
                $full_department_name = "Purchase Department";
                break;
            case 'DC':
                $full_department_name = "Document Cell";
                break;
            case 'RA':
                $full_department_name = "Regulatory Affairs";
                break; 
            case 'PV':
                $full_department_name = "Pharmacovigilance";
                break;         

            default:
                break;
        }

        return $full_department_name;

    }

    static function getDepartments()
    {
        $departments = [
            'CQA' => 'Corporate Quality Assurance',
            'QA' => 'Quality Assurance',
            'QC' => 'Quality Control',
            'QM' => 'Quality Control (Microbiology department)',
            'PG' => 'Production General',
            'PL' => 'Production Liquid Orals',
            'PT' => 'Production Tablet and Powder',
            'PE' => 'Production External (Ointment, Gels, Creams and Liquid)',
            'PC' => 'Production Capsules',
            'PI' => 'Production Injectable',
            'EN' => 'Engineering',
            'HR' => 'Human Resource',
            'ST' => 'Store',
            'IT' => 'Electronic Data Processing',
            'FD' => 'Formulation Development',
            'AL' => 'Analytical research and Development Laboratory',
            'PD' => 'Packaging Development',
            'PU' => 'Purchase Department',
            'DC' => 'Document Cell',
            'RA' => 'Regulatory Affairs',
            'PV' => 'Pharmacovigilance',
        ];
        
        return $departments;
    }


    static function getDocumentTypes()
    {
        $document_types = [
            'SOP' => 'SOP’s (All types)',
            'BOM' => 'Bill of Material',
            'BMR' => 'Batch Manufacturing Record',
            'BPR' => 'Batch Packing Record',
            'SPEC' => 'Specification (All types)',
            'STP' => 'Standard Testing Procedure (All types)',
            'TDS' => 'Test Data Sheet',
            'GTP' => 'General Testing Procedure',
            'PROTO' => 'Protocols (All types)',
            'REPORT' => 'Reports (All types)',
            'SMF' => 'Site Master File',
            'VMP' => 'Validation Master Plan',
            'QM' => 'Quality Manual',
        ];
        
        return $document_types;
    }


     public static function getDueDate123($date, $addDays = false, $format = null)
        {
            try {
                if ($date) {
                    $format = $format ? $format : 'd M Y';
                    $dateInstance = Carbon::parse($date);
                    if ($addDays) {
                        $dateInstance->addDays(30);
                    }
                    return $dateInstance->format($format);
            }
            } catch (\Exception $e) {
                return 'NA';
            }
        }


    public static function getDepartmentWithString($id)
    {
        $response = [];
        if(!empty($id)){
            $response = explode(',',$id);
        }
        return $response;
    }
    public static function getInitiatorEmail($id)
    {


        return   DB::table('users')->where('id',$id)->value('email');
    }

    // Helpers::formatNumberWithLeadingZeros(0)
    public static function formatNumberWithLeadingZeros($number)
    {
        return sprintf('%04d', $number);
    }

    public static function getDepartmentNameWithString($id)
    {
        $response = [];
        $resp = [];
        if(!empty($id)){
            $result = explode(',',$id);
            if(in_array(1,$result)){
                array_push($response, 'QA');
            }
            if(in_array(2,$result)){
                array_push($response, 'QC');
            }
            if(in_array(3,$result)){
                array_push($response, 'R&D');
            }
            if(in_array(4,$result)){
                array_push($response, 'Manufacturing');
            }
            if(in_array(5,$result)){
                array_push($response, 'Warehouse');
            }
            $resp = implode(',',$response);
        }
        return $resp;
    }

    // static function getInitiatorGroups()

    static function getInitiatorGroups()
    {
        $initiator_groups = [
            'CQA' => 'Corporate Quality Assurance',
            'QAB' => 'Quality Assurance Biopharma',
            'CQC' => 'Central Quality Control',
            'MANU' => 'Manufacturing',
            'PSG' => 'Plasma Sourcing Group',
            'CS' => 'Central Stores',
            'ITG' => 'Information Technology Group',
            'MM' => 'Molecular Medicine',
            'CL' => 'Central Laboratory',
            'TT' => 'Tech team',
            'QA' => 'Quality Assurance',
            'QM' => 'Quality Management',
            'IA' => 'IT Administration',
            'ACC' => 'Accounting',
            'LOG' => 'Logistics',
            'SM' => 'Senior Management',
            'BA' => 'Business Administration'
        ];

        return $initiator_groups;


    }

    public static function getInitiatorGroupFullName($shortName)
    {
    {

        switch ($shortName) {
            case 'Corporate Quality Assurance':
                return 'Corporate Quality Assurance';
                break;
            case 'QAB':
                return 'Quality Assurance Biopharma';
                break;
            case 'CQC':
                return 'Central Quality Control';
                break;
            case 'MANU':
                return 'Manufacturing';
                break;
            case 'PSG':
                return 'Plasma Sourcing Group';
                break;
            case 'CS':
                return 'Central Stores';
                break;
            case 'ITG':
                return 'Information Technology Group';
                break;
            case 'MM':
                return 'Molecular Medicine';
                break;
            case 'CL':
                return 'Central Laboratory';
                break;
            case 'TT':
                return 'Tech Team';
                break;
            case 'QA':
                return 'Quality Assurance';
                break;
            case 'QM':
                return 'Quality Management';
                break;
            case 'IA':
                return 'IT Administration';
                break;
            case 'ACC':
                return 'Accounting';
                break;
            case 'LOG':
                return 'Logistics';
                break;
            case 'SM':
                return 'Senior Management';
                break;
            case 'BA':
                return 'Business Administration';
                break;
            default:
                return '';
                break;
        }
    }
}

    static public function userIsQA()
    {
        $isQA = false;

        try {

            $auth_user = auth()->user();

            if ($auth_user && $auth_user->department && $auth_user->department->dc == 'QA') {
                return true;
            }

        } catch (\Exception $e) {
            info('Error in Helpers::userIsQA', [ 'message' => $e->getMessage(), 'obj' => $e ]);
        }

        return $isQA;
    }

    // Helpers::getMicroGridData($micro, 'analyst_training', true, 'response', true, 0)
    public static function getMicroGridData(OOS_micro $micro, $identifier, $getKey = false, $keyName = null, $byIndex = false, $index = 0)
    {
        $res = $getKey ? '' : [];
            try {
                $grid = $micro->grids()->where('identifier', $identifier)->first();

                if($grid && is_array($grid->data)){

                    $res = $grid->data;

                    if ($getKey && !$byIndex) {
                        $res = array_key_exists($keyName, $grid->data) ? $grid->data[$keyName] : '';
                    }

                    if ($getKey && $byIndex && is_array($grid->data[$index])) {
                        $res = array_key_exists($keyName, $grid->data[$index]) ? $grid->data[$index][$keyName] : '';
                    }
                }

            } catch(\Exception $e){

            }
        return $res;
    }

    public static function disabledErrataFields($data)
    {
        if($data == 0 || $data > 5){
            return 'disabled';
        }else{
            return  '';
        }

    }

    public static function disabledMarketComplaintFields($marketcomplaint)
    {
        if($marketcomplaint == 0 || $marketcomplaint > 8){
            return 'disabled';
        }else{
            return  '';
        }

    }

    public static function getDocStatusByStage($stage, $document_training = 'no')
    {
        $status = '';
        $training_required = $document_training == 'yes' ? true : false;
        switch ($stage) {
            case '1':
                $status = 'Draft';
                break;
            case '2':
                $status = 'In Review';
                break;
            case '3':
                $status = 'Reviewer Cycle-I';
                break;
            case '4':
                $status = 'Final Review';
                break;
            case '5':
                $status = 'Initiator Update';
                break;
            case '6':
                $status = 'In Approval';
                break;
            case '7':
                $status = 'Approval Cycle-I';
                break;
            case '8':
                $status = 'Final Approval';
                break;
            case '9':
                $status = $training_required ? 'Pending-Traning' : 'Effective';
                break;
            case '10':
                $status = $training_required ? 'Traning-Complete' : 'Obsolete';
                break;
            case '11':
                $status = $training_required ? 'Effective' : 'Obsolete';
                break;
            case '12':
                $status = 'Obsolete';
                break;
            case '13':
                $status = 'Closed/Cancel';
                break;
            default:
                # code...
                break;
        }

        return $status;
    }

    public static function compareValues($val1, $val2)
    {
        $html = '-';

        try {

            $val1 = $val1 ? strip_tags($val1) : 'NULL';
            $val2 = $val2 ? strip_tags($val2) : 'NULL';
            
            $diff = Diff::compareStrings($val1, $val2);
            
            
            // $diff->setCompareCharacters(true);

            $html = $diff->toHTML();

            $html = str_replace('<span> </span>', '&nbsp;', $html);
            $html = str_replace('<ins> </ins>', '&nbsp;', $html);
            $html = str_replace('<del> </del>', '&nbsp;', $html);

        } catch (\Exception $e) {

        }

        return $html;
    }
    
    public static function compareValues2($old, $new)
    {
        $html = '-';

        try {

            $old = $old ? $old : '';
            $new = $new ? $new : '';

            $rendererName = 'SideBySide';

            $differOptions = [
                'context' => 3,
                'ignoreCase' => false,
                'ignoreLineEnding' => false,
                'ignoreWhitespace' => false,
                'lengthLimit' => 2000,
                'fullContextIfIdentical' => false,
            ];

            $rendererOptions = [
                'detailLevel' => 'word',
                'language' => 'eng',
                'lineNumbers' => false,
                'separateBlock' => true,
                'showHeader' => true,
                'spacesToNbsp' => false,
                'tabSize' => 4,
                'mergeThreshold' => 0.8,
                'cliColorization' => RendererConstant::CLI_COLOR_AUTO,
                'outputTagAsString' => false,
                'jsonEncodeFlags' => \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE,
                'wordGlues' => [' ', '-'],
                'resultForIdenticals' => null,
                'wrapperClasses' => ['diff-wrapper'],
            ];

            $html = DiffHelper::calculate($old, $new, $rendererName, $differOptions, $rendererOptions);

        } catch (\Exception $e) {

        }

        return $html;
    }

}
