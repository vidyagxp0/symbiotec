@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
 @php
 $cc_cft = DB::table('c_c_s')->get();
 @endphp
    <style>
        header .header_rcms_bottom {
            display: none;
        }

        .filter-sub {
            display: flex;
            gap: 16px;
            margin-left: 13px
        }
    </style>
    <style>
        .filter-bar {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }

        .filter-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
        }

        .table-responsive {
            height: 100vh;
            /* overflow-x: scroll; */

        }

        .filter-item label {
            margin-right: 10px;
        }

        table {
            overflow: scroll
        }
        .main-head{
            display: flex;
            
            margin-bottom: 10px;
           
        }
        .main-head-new{
            display: flex;
            
            font-size: 20px;
            border: 1px solid #302e2e;
        }
    </style>
    <div id="rcms-desktop">

        <div class="main-content">
            <div class="container-fluid">
                <div class="process-tables-list">
                    <div class="process-table active" id="internal-audit">
                      
                               
                        <div class="table-block" style="padding: 20px;">
                            <div class="table-responsive" style="height: 450px">
                            <div class="table-block" style="padding: 20px;">
                                     <div class="sub-head " >
                                    <span class="fw-bold fs-6">Format No. : </span><span>CQA-F-001E-R2</span>
                                </div>
                        <div class="main-head" style="justify-content: flex-end;">

                                
                                <!-- <div class="sub-head " >
                                    <span class="fw-bold fs-6">Format No. : </span><span>CQA-F-001E-R2</span>
                                </div> -->
                            <button class="btn btn-primary"   onclick="printTable()">Print Table</button>
                            <div class="sub-head ml-3">
                                <!-- <span class="fw-bold fs-6">Format No. : </span><span>CQA-F-001E-R2</span> -->
                            </div>
                        </div>
                                <div class="main-head-new p-1">
                                    Department :
                                   
                                </div>
                                <table class="table table-bordered" style="width: 100%; border: 1px solid black;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Sr.No.</th>
                                            <th>ID</th>
                                            <th>Parent ID</th>
                                            <th>Division</th>
                                            <th>Process</th>
                                            <th>Initiated Through</th>
                                            <th>Short Description</th>
                                            <th>Date Opened</th>
                                            <th>Originator</th>
                                            <th>Due Date</th>
                                            <th>Status</th>

                                        </tr>
                                    </thead>
                                <tbody>
                                    @foreach ($cc_cft as $index => $doc)  
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $doc->record }}</td>
                                            <td>{{ $doc->parent_id ?  $doc->parent_id : '-' }}</td>
                                            <td>{{ Helpers::getDivisionName($doc->division_id) ? Helpers::getDivisionName($doc->division_id): "-"}}</td>
                                            <td>{{ $doc->initiated_through ? $doc->initiated_through : '-' }}</td>
                                            <td>{{ $doc->initiated_through ? $doc->initiated_through : '-' }}</td>
                                            <td>{{ $doc->short_description ? $doc->short_description : '-' }}</td>
                                            <td>{{ $doc->intiation_date ? $doc->intiation_date : '-' }}</td>
                                            <td>{{ Helpers::getInitiatorName($doc->initiator_id) ? Helpers::getInitiatorName($doc->initiator_id) : '-' }}</td>
                                            <td>{{ $doc->due_date ? $doc->due_date : '-' }}</td>
                                            <td>{{ $doc->status ? $doc->status : '-' }}</td>

                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                                   
                               
                                </table>
                                {{-- <div class="d-flex justify-content-center" style="margin-top: 10px;">
                                    <div class="spinner-border text-primary" role="status" id="spinner">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
   
    <script>
        function printTable() {
            var printContents = document.querySelector('.table-block').innerHTML;
            var originalContents = document.body.innerHTML;

            // Replace body content with table for printing
            document.body.innerHTML = printContents;
            window.print();

            // Restore original content after printing
            document.body.innerHTML = originalContents;
        }
    </script>
@endsection
