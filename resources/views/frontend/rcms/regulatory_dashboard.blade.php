@extends('frontend.rcms.Regulatorylayout.main_regulatory')

<script>
    // Function to update the options of the second dropdown based on the selection in the first dropdown
    function updateQueryOptions() {
        var scopeSelect = document.getElementById('scope');
        var querySelect = document.getElementById('query');
        var scopeValue = scopeSelect.value;

        // Clear existing options in the query dropdown
        querySelect.innerHTML = '';

        // Add options based on the selected scope
        if (scopeValue === 'Regulatory Inspection') {
            querySelect.options.add(new Option('Opened', '1'));
            querySelect.options.add(new Option('Audit Preparation', '2'));
            querySelect.options.add(new Option('Pending Audit', '3'));
            querySelect.options.add(new Option('Pending Response', '4'));
            querySelect.options.add(new Option('CAPA Execution in Progress', '5'));
            querySelect.options.add(new Option('Closed - Done', '6'));


        } 

    }
</script>
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
                                        <th>ID</th>
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
                                <tbody id="searchTable">
                                    @php
                                        $table = json_encode($datag);
                                        $tables = json_decode($table);
                                        $total_count = count($datag);

                                    @endphp
                                    @foreach (collect($tables->data)->sortByDesc('date_open') as $datas)
                                        <tr>
                                            <td>
                                                @if ($datas->type == 'Regulatory Inspection')
                                                    <a href="{{ route('showregulatory', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <a href="{{ url('rcms/qms-dashboard', $datas->id) }}/CC">
                                                        <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                            title="Related Records">
                                                        </div>
                                                    </a>
                                                @endif
                                                @if ($datas->type == 'Regulatory Change')
                                                    <a href="{{ url('rcms/regulatory-action-view', $datas->id) }}" style="color: blue">
                                                        {{ str_pad(($total_count - $loop->index), 4, '0', STR_PAD_LEFT) }}
                                                    </a>
                                                    <a href="{{ url('rcms/regulatory_dashboard', $datas->id) }}/CC">
                                                        <div class="icon" onclick="showChild()" data-bs-toggle="tooltip"
                                                            title="Related Records">
                                                        </div>
                                                    </a>
                                                    
                                                @endif
                                            </td>
                                            @if ($datas->parent_id != null)
                                                        <td>
                                                            {{ str_pad($datas->parent_id, 4, '0', STR_PAD_LEFT) }}
                                                        </td>
                                                    @else
                                                        <td>
                                                            -
                                                        </td>
                                            @endif
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                @if ($datas->division_id)
                                                    {{ Helpers::getDivisionName($datas->division_id) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal" style="{{ $datas->type == 'Capa' ? 'text-transform: uppercase' : '' }}">
                                                {{ $datas->type }}
                                            </td>

                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ ucwords(str_replace('_', ' ', $datas->initiated_through)) }}
                                            </td>

                                            <td id="short_width" class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $datas->short_description }}
                                            </td>
                                            @php
                                                $date = new \DateTime($datas->date_open);
                                                $formattedDate = $date->format('d-M-Y H:i:s');
                                            @endphp

                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $formattedDate }}
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ Helpers::getInitiatorName($datas->initiator_id) }}
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                @if (property_exists($datas, 'due_date'))
                                                    {{ $datas->type !== 'Extension' ? Helpers::getdateFormat($datas->due_date) : ''  }}
                                                @endif
                                            </td>
                                            <td class="viewdetails" data-id="{{ $datas->id }}"
                                                data-type="{{ $datas->type }}" data-bs-toggle="modal"
                                                data-bs-target="#record-modal">
                                                {{ $datas->stage }}
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="scope-pagination">
                            {{ $datag->links() }}
                        </div> 
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
