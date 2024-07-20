@extends('frontend.rcms.Regulatorylayout.main_regulatory')


<style>
    #short_width{
        display: inline-block;
    width: 320px !important;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
    }
    .table-container {
  overflow: auto;
  /* max-height: 350px;
  max-height: 350px; */
}

.table-header11 {
  position: sticky;
  top: 0;
  background-color: white;
  z-index: 1;
}

.table-body-new {
  margin-top: 30px;
}
.td_c{
    width: 100px !important;
}
.td_desc{
    width: 10px;
}
</style>
@section('rcms_container')
    <div id="rcms-dashboard">
        <div class="container-fluid">
            <div class="dash-grid">


                <div>
                    <div class="inner-block scope-table" style="height: calc(100vh - 170px); padding: 0;">
                       <div class="grid-block">
                            <div class="group-input">
                                <label for="scope">Process</label>
                                <select id="scope" name="form">
                                    <option value="">All Records</option>
                                    {{-- @foreach ($uniqueProcessNames as $ultraprocess)
                                        <option value={{ $ultraprocess }}>{{ $ultraprocess }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="group-input">
                                <label for="query">Criteria</label>
                                <select id="query" name="stage">
                                    <option value="">All Records</option>
                                    <option value="Closed">Closed Records</option>
                                    <option value="Opened">Opened Records</option>
                                    <option value="Cancelled">Cancelled Records</option>
                                    <option value="">Initial Deviation Category= Minor</option>
                                    <option value="">Initial Deviation Category= Major</option>
                                    <option value="">Initial Deviation Category= Critical</option>
                                     <option value="">Post Categorization Of Deviation= Minor</option>
                                    <option value="">Post Categorization Of Deviation= Major</option>
                                    <option value="">Post Categorization Of Deviation= Critical</option>
                                </select>
                            </div>
                            <div class="item-btn" onclick="window.print()">Print</div>
                        </div>



                        <div class="main-scope-table table-container">
                        <div class="main-scope-table table-container">
                            <table class="table table-bordered" id="auditTable">
                                <thead class="table-header11">
                                    <tr>
                                        <th>IDnnnnnnnnnnn</th>
                                        <th>Parent ID</th>
                                        <th>Division</th>
                                        <th>Process</th>
                                        <th>Initiated Through</th>
                                        <th class="td_desc">Short Description</th>
                                        <th>Date Opened</th>
                                        <th>Originator</th>
                                        <th> Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                               <tbody>
                                
                               </tbody>
                            </table>
                        </div>
                        {{-- <div class="scope-pagination">
                            {{ $datag->links() }}
                        </div>  --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-sm" id="record-modal">
        <div class="modal-contain">
            <div class="modal-dialog m-0">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body " id="auditTableinfo">
                        Please wait...
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function showChild() {
            $(".child-row").toggle();
        }

        $(".view-list").hide();

        function toggleview() {
            $(".view-list").toggle();
        }

        $("#record-modal .drop-list").hide();

        function showAction() {
            $("#record-modal .drop-list").toggle();
        }
    </script>
    <script type='text/javascript'>
        $(document).ready(function() {
            $('#auditTable').on('click', '.viewdetails', function() {
                var auditid = $(this).attr('data-id');
                var formType = $(this).attr('data-type');
                if (auditid > 0) {
                    // AJAX request
                    var url = "{{ route('ccView', ['id' => ':auditid', 'type' => ':formType']) }}";
                    url = url.replace(':auditid', auditid).replace(':formType', formType);

                    // Empty modal data
                    $('#auditTableinfo').empty();
                    $.ajax({
                        url: url,
                        dataType: 'json',
                        success: function(response) {
                            // Add employee details
                            $('#auditTableinfo').append(response.html);
                            // Display Modal
                            $('#record-modal').modal('show');
                        }
                    });
                }
            });
        });
    </script>
@endsection
