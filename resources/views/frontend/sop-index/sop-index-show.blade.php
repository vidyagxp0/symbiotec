@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
 @php
 $documentMain = DB::table('documents')->get();
// dd($documents);
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

        {{-- <div class="process-groups">
            <div class="active" onclick="openTab('internal-audit', this)">OOC Log </div>
        </div> --}}
        <div class="main-content">
            <div class="container-fluid">
                <div class="process-tables-list">
                    <div class="process-table active" id="internal-audit">
                      
                               
                        <div class="table-block" style="padding: 20px;">
                            <div class="table-responsive" style="height: 450px">
                                <div class="main-head">
                                    {{-- <div class="sub-head fw-bold">
                                     Ref.SOP No. :
                                    </div> --}}
                                    <div class="sub-head ">
                                        <span class="fw-bold fs-6">Format No. : </span><span>CQA-F-001E-R2</span>
                                    </div>
                                </div>
                                <div class="main-head-new p-1">
                                    Department :
                                   
                                </div>
                                <table class="table table-bordered" style="width: 100%; border: 1px solid black;">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">Sr.No.</th>
                                            <th>Name of SOP</th>
                                            <th>SOP No.</th>
                                            <th>Effective Date</th>
                                            <th>Review Date</th>
                                            
                                        </tr>
                                    </thead>
                                <tbody>
                                    @foreach ($documentMain as $index => $doc)  
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $doc->document_name }}</td>
                                            <td>{{ $doc->document_number ?  $doc->document_number : '-' }}</td>
                                            <td>{{ $doc->effective_date ? $doc->effective_date : '-' }}</td>
                                            <td>{{ $doc->next_review_date ? $doc->next_review_date : '-' }}</td>
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
   
@endsection
