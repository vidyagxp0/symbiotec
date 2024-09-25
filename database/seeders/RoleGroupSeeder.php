<?php

namespace Database\Seeders;

use App\Models\RoleGroup;
use App\Models\QMSDivision;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = [
            'Corporate Quality Assurance (CQA)',
            'Plant 1',
            'Plant 2',
            'Plant 3',
            'Plant 4',
            'C1'
        ];

      $processes_roles = [
            'Effectiveness Check' => ['Initiator', 'Supervisor', 'QA', 'HOD/Designee', 'CQA', 'View Only', 'FP', 'Closed Record'],
            'Root Cause Analysis' => ['Initiator', 'HOD/Designee', 'QA', 'CQA', 'View Only', 'FP', 'Closed Record'],
            'Change Control' => ['Initiator', 'HOD/Designee', 'QA', 'CQA', 'CFT', 'Head QA', 'Head QA/Designee', 'View Only', 'FP', 'Closed Record'],
            'CAPA' => ['Initiator', 'HOD/Designee', 'CQA Reviewer', 'QA Approver', 'CQA Approver', 'QA', 'CQA Head', 'Head QA', 'QA Head/Designee', 'View Only', 'FP', 'Closed Record'],
            'Action Item' => ['Initiator', 'Action Owner', 'QA', 'CQA', 'View Only', 'FP', 'Closed Record'],
            'Extension' => ['Initiator', 'Head QA/Designee', 'QA Approver', 'CQA Approver', 'View Only', 'FP', 'Closed Record', 'HOD/Designee'],
            'Regulatory Inspection' => ['Initiator',  'Approver', 'Reviewer', 'Drafter', 'View Only', 'FP'],
            'Regulatory Change' => ['Initiator',  'Approver', 'Reviewer', 'Drafter', 'View Only', 'FP'],
            'Critical Action' => ['Initiator',  'Approver', 'Reviewer', 'Drafter', 'View Only', 'FP'],
            'Deviation' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP', 'Closed Record'],
            'Lab Incident' => ['Initiator', 'HOD/Supervisor/Designee', 'Head QA', 'Initiator', 'Head QA', 'View Only', 'FP', 'Closed Record'],
            'OOT' => ['Initiator', 'HOD/Supervisor/Designee', 'Head QA', 'Initiator', 'Head QA/Designee', 'View Only', 'FP', 'Closed Record'],
            'Market Complaint' => ['Initiator', 'Supervisor', 'QA', 'Responsible Person', 'Supervisor', 'QA Head/Designee', 'Initiator', 'View Only', 'FP', 'Closed Record'],
            'OOS Chemical' => ['Initiator', 'Lab Supervisor', 'QC Head/Designee', 'Lab Supervisor', 'QA', 'Lab Supervisor', 'QA', 'Head QA/Designee', 'View Only', 'FP', 'Closed Record'],
            'New Document' => ['Initiator', 'Author', 'HOD/Designee', 'Approver', 'Reviewer', 'View Only', 'FP', 'Trainer', 'Closed Record'],

            
            // 'Audit Program' => ['Initiator', 'Audit Manager', 'View Only', 'FP', 'Closed Record'],
            // 'Internal Audit' => ['Initiator', 'Audit Manager', 'Lead Auditor', 'Lead Auditee', 'View Only', 'FP', 'Closed Record'],
            // 'External Audit' => ['Initiator', 'Audit Manager', 'Lead Auditor', 'Lead Auditee', 'View Only', 'FP', 'Closed Record'],
            // 'Management Review' => ['Initiator', 'Responsible Person', 'View Only', 'FP', 'Closed Record'],
            // 'Risk Assessment' => ['Initiator', 'HOD/Designee', 'Work Group (Risk Management Head)', 'HOD/Designee', 'QA', 'View Only', 'FP', 'Closed Record'],
            // 'Resampling' => ['Initiator', 'Action Owner', 'QA', 'View Only', 'FP', 'Closed Record'],
            // 'Observation' => ['Initiator', 'Lead Auditor', 'Lead Auditee', 'QA', 'View Only', 'FP', 'Closed Record'],
            // 'OOC' => ['Initiator', 'HOD/Designee', 'QC Head', 'QA', 'QC Supervisor', 'Manufacturing QA', 'QA', 'QA Head/Designee', 'View Only', 'FP', 'Closed Record'],
            // 'Non Conformance' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP', 'Closed Record'],
            // 'Incident' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP', 'Closed Record'],
            // 'Failure Investigation' => ['Initiator', 'HOD/Designee', 'QA', 'CFT', 'QA', 'QA Head/Designee', 'Initiator', 'QA', 'View Only', 'FP', 'Closed Record'],
            // 'ERRATA' => ['Initiator', 'QA Reviewer', 'Initiator', 'Supervisor', 'HOD/Designee', 'QA Head/Designee', 'View Only', 'FP', 'Closed Record'],
            // 'OOS Microbiology' => ['Initiator','HOD/Designee', 'Lab Supervisor', 'QC Head/Designee', 'Lab Supervisor', 'QA', 'Lab Supervisor','Production','Production Head', 'Head QA/Designee', 'View Only', 'FP', 'Closed Record'],
        ];

        $start_from_id = 1; // Initialize your starting ID

        foreach ($sites as $site) {
            foreach ($processes_roles as $process => $roles) {
                foreach ($roles as $role) {
                    $group = new RoleGroup();
                    $group->id = $start_from_id;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                    $start_from_id++;
                }
            }
        }

        $cft_roles = [
            "Production",
            "Warehouse",
            "Quality Control",
            "Quality Assurance",
            "Engineering",
            "Analytical Development Laboratory",
            "Process Development Laboratory / Kilo Lab",
            "Technology Transfer / Design",
            "Environment, Health & Safety",
            "Human Resource & Administration",
            "Information Technology",
            "Project Management"
        ];

        $processes = [
            'Change Control',
            'Deviation',
            // 'Non Conformance',
            // 'Incident',
        ];

        $incrementCount = $start_from_id;

        foreach ($processes as $process) {
            foreach ($sites as $site) {
                foreach ($cft_roles as $role) {
                    $group = new RoleGroup();
                    $group->id = $incrementCount++;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                }
            }
        }

        //failure
        $cft_roles1 = [
            "RA Review",
            "Production Tablet",
            "Production Liquid",
            "Production Injection",
            "Stores",
            "Research & Development",
            "Microbiology",
            "Regulatory Affair",
            "Corporate Quality Assurance",
            "Safety",
            "Contract Giver",
            "Quality Control",
            "Quality Assurance",
            "Engineering",
            "Human Resource & Administration",
            "Information Technology",
        ];

        $processes2 = [
            'Change Control',
            // 'Failure Investigation',
        ];

        $incrementCount1 = $incrementCount;

        foreach ($processes2 as $process) 
        {
            foreach ($sites as $site) {
                foreach ($cft_roles1 as $role) {
                    $group = new RoleGroup();
                    $group->id = $incrementCount++;
                    $group->name = "$site-$process-$role";
                    $group->description = "$site-$process-$role";
                    $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
                    $group->save();
                }
            }
        }



        // $processes_roles3 = [
        //     'Effectiveness Check' => ['HOD/Designee', 'QA', 'CQA'],
        //     'Root Cause Analysis' => ['HOD/Designee', 'QA', 'CQA', 'CQA Head', 'Head QA'],
        //     'Change Control' => ['QA', 'CQA', 'CFT', 'Head QA'],
        //     'CAPA' => ['QA', 'CQA Reviewer', 'QA Approver', 'CQA Approver', 'QA', 'CQA Head', 'Head QA'],  
        //     'Action Item' => ['Initiator', 'QA', 'CQA'],
        //     'Extension' => ['HOD/Designee', 'QA Approver', 'CQA Approver'],
        // ];

        // $start_from_idNew = $incrementCount1;

        // foreach ($sites as $site) {
        //     foreach ($processes_roles3 as $process => $roles) {
        //         foreach ($roles as $role) {
        //             $group = new RoleGroup();
        //             $group->id = $start_from_idNew;
        //             $group->name = "$site-$process-$role";
        //             $group->description = "$site-$process-$role";
        //             $group->permission = json_encode(['read' => true, 'create' => true, 'edit' => true, 'delete' => true]);
        //             $group->save();
        //             $start_from_idNew++;
        //         }
        //     }
        // }
    }
}
