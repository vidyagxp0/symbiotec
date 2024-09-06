@extends('frontend.layout.main')
@section('container')
@php
 
$users = DB::table('users')
    ->select('id', 'name')
    ->get();

@endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
        .remove-file  {
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }

        .remove-file :hover {
            color: white;
        }
    </style>
    <script>
        $(document).ready(function () {
    let multipleCancelButton = new Choices("#choices-multiple-remove-button", {
        removeItemButton: true,
    });
});

function addMultipleFiles(input, block_id) {
    let block = document.getElementById(block_id);
    block.innerHTML = "";
    let files = input.files;
    for (let i = 0; i < files.length; i++) {
        let div = document.createElement('div');
        div.innerHTML += files[i].name;
        let viewLink = document.createElement("a");
        viewLink.href = URL.createObjectURL(files[i]);
        viewLink.textContent = "View";
        div.appendChild(viewLink);
        block.appendChild(div);
    }
}
    </script>
  <script>
    $(document).ready(function() {
        $('#ObservationAdd').click(function(e) {
            let index = 0;
            function generateTableRow(serialNumber) {
                var users = @json($users);
                index++;
                var html =
                    '<tr>' +
                        '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber + '"></td>' +
                        '<td><input type="text" name="divisionCode['+index+']"></td>' +
                        '<td><input type="text" name="siteId['+index+']"></td>' +
                        '<td><input type="text" name="referenceNo['+index+']"></td>' +
                        '<td><input type="text" name="observationShortDesc['+index+']"></td>' +
                        '<td><input type="text" name="observation_detail['+index+']"></td>' +
                        '<td><input type="text" name="observationCategory['+index+']"></td>' +
                        '<td><input type="text" name="observationSubCat['+index+']"></td>' +
                        '<td><input type="text" name="frequency['+index+']"></td>' +
                        '<td><input type="text" name="auditingAgency['+index+']"></td>' +
                        '<td><input type="text" name="audittype['+index+']"></td>' +
                        '<td><input type="text" name="auditStartDate['+index+']"></td>' +
                        '<td><input type="text" name="auditEndDate['+index+']"></td>' +
                        '<td><input type="text" name="auditor['+index+']"></td>' +
                        '<td><input type="text" name="observation_category['+index+']"></td>' +
                        '<td><input type="text" name="observationType['+index+']"></td>' +
                        '<td><input type="text" name="observationArea['+index+']"></td>' +
                        '<td><input type="text" name="observationAreaSubCat['+index+']"></td>' +
                        '<td><input type="text" name="capaRequired['+index+']"></td>' +
                        '<td><input type="text" name="capaOwner['+index+']"></td>' +
                        '<td><input type="text" name="capaDescription['+index+']"></td>' +
                        '<td><input type="text" name="capaDueDate['+index+']"></td>' +
                        '<td><input type="text" name="capaSatus['+index+']"></td>' +
                        '<td><input type="text" name="delayJustification['+index+']"></td>' +
                        '<td><input type="text" name="delayCategory['+index+']"></td>' +
                        '<td><input type="text" name="remarks['+index+']"></td>' +
                        '<td><input type="text" name="Action[]" readonly></td>' +
                        '</tr>';

                return html;
            }

            var tableBody = $('#onservation-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });

    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    });
</script>
    <script>
        function otherController(value, checkValue, blockID) {
            let block = document.getElementById(blockID)
            let blockTextarea = block.getElementsByTagName('textarea')[0];
            let blockLabel = block.querySelector('label span.text-danger');
            if (value === checkValue) {
                blockLabel.classList.remove('d-none');
                blockTextarea.setAttribute('required', 'required');
            } else {
                blockLabel.classList.add('d-none');
                blockTextarea.removeAttribute('required');
            }
        }
    </script>

<script>
    function addAuditAgenda(tableId) {
        var users = @json($users);
        var table = document.getElementById(tableId);
        var currentRowCount = table.rows.length;
        var newRow = table.insertRow(currentRowCount);
        newRow.setAttribute("id", "row" + currentRowCount);
        var cell1 = newRow.insertCell(0);
        cell1.innerHTML = currentRowCount;

        var cell2 = newRow.insertCell(1);
        cell2.innerHTML = "<input type='text' name='audit[]'>";

        var cell3 = newRow.insertCell(2);
        cell3.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_start_date' + currentRowCount +'" readonly placeholder="DD-MM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' + currentRowCount +'_checkdate"  class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' + currentRowCount +'`);checkDate(`scheduled_start_date' + currentRowCount +'_checkdate`,`scheduled_end_date' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

        var cell4 = newRow.insertCell(3);
        cell4.innerHTML = "<input type='time' name='scheduled_start_time[]' >";

        var cell5 = newRow.insertCell(4);
        cell5.innerHTML = '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_end_date' + currentRowCount +'" readonly placeholder="DD-MM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date'+ currentRowCount +'_checkdate" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' + currentRowCount +'`);checkDate(`scheduled_start_date' + currentRowCount +'_checkdate`,`scheduled_end_date' + currentRowCount +'_checkdate`)" /></div></div></div></td>';

        var cell6 = newRow.insertCell(5);
        cell6.innerHTML = "<input type='time' name='scheduled_end_time[]' >";

        var cell7 = newRow.insertCell(6);
        var userHtml = '<select name="auditor[]"><option value="">-- Select --</option>';
                for (var i = 0; i < users.length; i++) {
                    userHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }
                userHtml +='</select>';
        
                cell7.innerHTML = userHtml;

        var cell8 = newRow.insertCell(7);
        
        var userHtml = '<select name="auditee[]"><option value="">-- Select --</option>';
            for (var i = 0; i < users.length; i++) {
                userHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
            }
            userHtml +='</select>';
    
            cell8.innerHTML = userHtml;

        var cell9 = newRow.insertCell(8);
        cell9.innerHTML = "<input type='text'name='remark[]'>";
        var cell10 = newRow.insertCell(9);
        cell10.innerHTML = '<button type="button" class="removeRowBtn" onclick="removeRow(this)">Remove</button>';

        // Update row numbering
        for (var i = 1; i < currentRowCount; i++) {
            var row = table.rows[i];
            row.cells[0].innerHTML = i;
        }
    }

    function removeRow(button) {
        var row = button.closest('tr');
        row.parentNode.removeChild(row);
        
        // Update row numbering
        var table = document.getElementById('audit-agenda-grid');
        for (var i = 1; i < table.rows.length; i++) {
            var row = table.rows[i];
            row.cells[0].innerHTML = i;
        }
    }
</script>
<script>
    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
    })
</script>

    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName($data->division_id) }} / Regulatory Inspection
        </div>
    </div>

    {{-- ---------------------- --}}
    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="main-head">Record Workflow  </div>

                    <div class="d-flex" style="gap:20px;">
                      
                    <?php
                        $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                        // dd($userRoles);
                    ?>
                        <!-- {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}} -->
                        <button class="button_theme1"> <a class="text-white"
                                href="{{ route('ShowexternalAuditTrials', $data->id) }}"> Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(13, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Schedule Audit
                            </button>
                            <!-- {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button> --}} -->
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(12, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Complete Audit Preparation
                            </button>
                           
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                Reject
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 3 && (in_array(12, $userRoleIds) || in_array(18, $userRoleIds)))
                            </button> <button class="button_theme1" data-bs-toggle="modal"
                                data-bs-target="#rejection-modal">
                                Reject
                            </button>
                            <!-- {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal1">
                                Child
                            </button> --}} -->
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Issue Report</button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 4 && (in_array(11, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                CAPA Plan Proposed
                            </button>

                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#rejection-modal">
                                No CAPAs Required
                            </button>
                           
                        @elseif($data->stage == 5 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds) || in_array(11, $userRoleIds) ))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                All CAPA Closed
                            </button>
                        @endif
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>


                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    {{-- ------------------------------By Pankaj-------------------------------- --}}
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">Audit Preparation </div>
                            @else
                                <div class="">Audit Preparation</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">Pending Audit</div>
                            @else
                                <div class="">Pending Audit</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">Pending Response</div>
                            @else
                                <div class="">Pending Response</div>
                            @endif
                            @if ($data->stage >= 5)
                                <div class="active">CAPA Execution in Progress</div>
                            @else
                                <div class="">CAPA Execution in Progress</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif





                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <div class="control-list">
            {{-- ------------------------------- --}}

            {{-- ======================================
                    DATA FIELDS
    ======================================= --}}

            @php
                $users = DB::table('users')->get();
            @endphp

            <div id="change-control-fields">
                <div class="container-fluid">

                    <!-- Tab links -->
                    <div class="cctab">
                        <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Audit Planning</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Audit Preparation</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Audit Execution</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Audit Response & Closure</button>
                        <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
                    </div>

                    <form action="{{ route('regulatoryUpdate', $data->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div id="step-form">

                            <!-- General information content -->
                            <div id="CCForm1" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="RLS Record Number"><b>Record Number</b></label>
                                                <input type="hidden" name="record_number">
                                                {{-- <div class="static">QMS-EMEA/IA/{{ Helpers::year($data->created_at) }}/{{ $data->record }}</div> --}}
                                                <input disabled type="text"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}/RI/{{ date('Y') }}/{{ $data->record }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Division Code"><b>Site/Location Code</b></label>
                                                <input disabled type="text" name="division_code"
                                                    value="{{ Helpers::getDivisionName($data->division_id) }}">
                                                {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator"><b>Initiator</b></label>
                                                <input type="hidden" name="initiator_id">
                                                {{-- <div class="static">{{ $data->initiator_name }} </div> --}}
                                                <input disabled type="text" value="{{ $data->initiator_name }} ">
                                            </div>
                                        </div>
                                       <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Date Due">Date of Initiation</label>
                                                <input readonly type="text"
                                                    value="{{Helpers::getdateFormat($data->intiation_date) }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>

                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Assigned to">Assigned to</label>
                                                <select name="assign_to"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->assign_to == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @php
                                        $initiationDate = date('Y-m-d');
                                        $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days'));
                                    @endphp
        
                                    <div class="col-md-6 new-date-data-field">
                                        <div class="group-input input-date">
                                            <label for="due-date">Date Due</label>
                                            <div><small class="text-primary">Please mention expected date of completion</small></div>
                                            <div class="calenderauditee">
                                                <input readonly type="text" value="{{ Helpers::getdateFormat($data->due_date) }}" name="due_date" />
                                                <input readonly type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                            </div>
                                        </div>
                                    </div>
        
                                    <script>
                                            // Format the due date to DD-MM-YYYY
                                            // Your input date
                                            var dueDate = "{{ $dueDate }}"; // Replace {{ $dueDate }} with your actual date variable
        
                                            // Create a Date object
                                            var date = new Date(dueDate);
        
                                            // Array of month names
                                            var monthNames = [
                                                "Jan", "Feb", "Mar", "Apr", "May", "Jun",
                                                "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
                                            ];
        
                                            // Extracting day, month, and year from the date
                                            var day = date.getDate().toString().padStart(2, '0'); // Ensuring two digits
                                            var monthIndex = date.getMonth();
                                            var year = date.getFullYear();
        
                                            // Formatting the date in "DD-MM-YYYY" format
                                            var dueDateFormatted = `${day}-${monthNames[monthIndex]}-${year}`;
        
                                            // Set the formatted due date value to the input field
                                            document.getElementById('due_date').value = dueDateFormatted;
                                        </script>

<div class="col-lg-6">
    <div class="group-input">
        <label for="Initiator Group"><b>Initiator Group</b></label>
        <select name="Initiator_Group" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} id="initiator_group">
            <option value="">Select Department</option>
            <option value="CQA" @if ($data->Initiator_Group == 'CQA') selected @endif>Corporate Quality Assurance</option>
            <option value="QAB" @if ($data->Initiator_Group == 'QAB') selected @endif>Quality Assurance Biopharma</option>
            <option value="CQC" @if ($data->Initiator_Group == 'CQC') selected @endif>Central Quality Control</option>
            <option value="MANU" @if ($data->Initiator_Group == 'MANU') selected @endif>Manufacturing</option>
            <option value="PSG" @if ($data->Initiator_Group == 'PSG') selected @endif>Plasma Sourcing Group</option>
            <option value="CS" @if ($data->Initiator_Group == 'CS') selected @endif>Central Stores</option>
            <option value="ITG" @if ($data->Initiator_Group == 'ITG') selected @endif>Information Technology Group</option>
            <option value="MM" @if ($data->Initiator_Group == 'MM') selected @endif>Molecular Medicine</option>
            <option value="CL" @if ($data->Initiator_Group == 'CL') selected @endif>Central Laboratory</option>
            <option value="TT" @if ($data->Initiator_Group == 'TT') selected @endif>Tech team</option>
            <option value="QA" @if ($data->Initiator_Group == 'QA') selected @endif>Quality Assurance</option>
            <option value="QM" @if ($data->Initiator_Group == 'QM') selected @endif>Quality Management</option>
            <option value="IA" @if ($data->Initiator_Group == 'IA') selected @endif>IT Administration</option>
            <option value="ACC" @if ($data->Initiator_Group == 'ACC') selected @endif>Accounting</option>
            <option value="LOG" @if ($data->Initiator_Group == 'LOG') selected @endif>Logistics</option>
            <option value="SM" @if ($data->Initiator_Group == 'SM') selected @endif>Senior Management</option>
            <option value="BA" @if ($data->Initiator_Group == 'BA') selected @endif>Business Administration</option>
        </select>
    </div>
</div>


                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Initiator Group Code</label>
                                        <input type="text" id="initiator_group_code"  name="initiator_group_code" {{ $data->stage == 0 || $data->stage == 10 ? "disabled" : "" }} value="{{$data->initiator_group_code}}" readonly>
                                    </div>

                                </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description <span
                                                        class="text-danger">*</span></label>
                                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                                <textarea name="short_description" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->short_description }}</textarea>
                                            </div>
                                        </div> --}}
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Short Description">Short Description<span
                                                        class="text-danger">*</span></label><span id="rchars">255</span>
                                                characters remaining
                                                
                                                <input name="short_description" id="docname" {{ $data->stage == 0 || $data->stage == 8 ? "disabled" : "" }} value="{{ $data->short_description }}" required type="text">
                                            </div>
                                            <p id="docnameError" style="color:red">**Short Description is required</p>
        
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="severity-level">Severity Level</label>
                                                <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="severity_level">
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->severity_level == 'minor') selected @endif
                                                     value="minor">Minor</option>
                                                    <option  @if ($data->severity_level == 'major') selected @endif 
                                                    value="major">Major</option>
                                                    <option @if ($data->severity_level == 'critical') selected @endif
                                                    value="critical">Critical</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Initiator Group">Initiated Through</label>
                                                <div><small class="text-primary">Please select related information</small></div>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="initiated_through"
                                                    onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                                    <option value="">-- select --</option>
                                                    <option @if ($data->initiated_through == 'recall') selected @endif
                                                        value="recall">Recall</option>
                                                    <option @if ($data->initiated_through == 'return') selected @endif
                                                        value="return">Return</option>
                                                    <option @if ($data->initiated_through == 'deviation') selected @endif
                                                        value="deviation">Deviation</option>
                                                    <option @if ($data->initiated_through == 'complaint') selected @endif
                                                        value="complaint">Complaint</option>
                                                    <option @if ($data->initiated_through == 'regulatory') selected @endif
                                                        value="regulatory">Regulatory</option>
                                                    <option @if ($data->initiated_through == 'lab-incident') selected @endif
                                                        value="lab-incident">Lab Incident</option>
                                                    <option @if ($data->initiated_through == 'improvement') selected @endif
                                                        value="improvement">Improvement</option>
                                                    <option @if ($data->initiated_through == 'others') selected @endif
                                                        value="others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
        
                                                $('#initiatedThroughBlock').hide();
        
                                                $('select[name="initiated_through"]').change(function() {
                                                    const selectedVal = $(this).val();
        
                                                    if (selectedVal == 'others' ) {
                                                        $('#initiatedThroughBlock').show();
                                                    } else {
                                                        $('#initiatedThroughBlock').hide();
                                                    }
        
                                                })
                                            })
                                        </script>
                                        <div class="col-lg-6" id="initiatedThroughBlock">
                                            <div class="group-input" id="initiated_through_req">
                                                <label for="If Other">Others<span
                                                        class="text-danger d-none">*</span></label>
                                                <textarea {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="initiated_if_other">{{$data->initiated_if_other}}</textarea>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="repeat">Repeat</label>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="repeat"
                                                    onchange="otherController(this.value, 'yes', 'repeat_nature')">
                                                    <option value="">Enter Your Selection Here</option>
                                                    <option  @if ($data->repeat == 'Yes') selected @endif value="Yes">Yes</option>
                                                    <option  @if ($data->repeat == 'No') selected @endif value="No">No</option>
                                                    <option  @if ($data->repeat == 'NA') selected @endif value="NA">NA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input" id="repeat_nature">
                                                <label for="repeat_nature">Repeat Nature<span
                                                        class="text-danger d-none">*</span></label>
                                                <textarea {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="repeat_nature">{{$data->repeat_nature}}</textarea>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6">
    <div class="group-input">
        <label for="audit_type">Type of Audit</label>
        <select name="audit_type" id="audit_type"
                onchange="otherController(this.value, 'others', 'if_other')"
                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
            <option value="">Enter Your Selection Here</option>
            <option value="R&D" {{ old('audit_type', $data->audit_type) == 'R&D' ? 'selected' : '' }}>R&D</option>
            <option value="GLP" {{ old('audit_type', $data->audit_type) == 'GLP' ? 'selected' : '' }}>GLP</option>
            <option value="GCP" {{ old('audit_type', $data->audit_type) == 'GCP' ? 'selected' : '' }}>GCP</option>
            <option value="GDP" {{ old('audit_type', $data->audit_type) == 'GDP' ? 'selected' : '' }}>GDP</option>
            <option value="GEP" {{ old('audit_type', $data->audit_type) == 'GEP' ? 'selected' : '' }}>GEP</option>
            <option value="ISO 17025" {{ old('audit_type', $data->audit_type) == 'ISO 17025' ? 'selected' : '' }}>ISO 17025</option>
            <option value="others" {{ old('audit_type', $data->audit_type) == 'others' ? 'selected' : '' }}>Others</option>
        </select>
    </div>
</div>

                                        <div class="col-lg-6" id="IfOthers">
                                            <div class="group-input" id="if_other">
                                                <label for="If Other">If Other<span
                                                        class="text-danger d-none">*</span></label>
                                                <textarea name="if_other" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->if_other }}</textarea>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
        
                                                $('#IfOthers').hide();
        
                                                $('select[name="audit_type"]').change(function() {
                                                    const selectedVal = $(this).val();
        
                                                    if (selectedVal == 'others' ) {
                                                        $('#IfOthers').show();
                                                    } else {
                                                        $('#IfOthers').hide();
                                                    }
        
                                                })
                                            })
                                        </script>
                                        <div class="col-lg-6">
    <div class="group-input">
        <label for="external_agencies">Supplier Agencies</label>
        <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="external_agencies" id="external_agencies">
            <option value="">-- Select --</option>
            <option @if ($data->external_agencies == 'jordan_fda') selected @endif value="jordan_fda">Jordan FDA</option>
            <option @if ($data->external_agencies == 'us_fda') selected @endif value="us_fda">USFDA</option>
            <option @if ($data->external_agencies == 'mhra') selected @endif value="mhra">MHRA</option>
            <option @if ($data->external_agencies == 'anvisa') selected @endif value="anvisa">ANVISA</option>
            <option @if ($data->external_agencies == 'iso') selected @endif value="iso">ISO</option>
            <option @if ($data->external_agencies == 'who') selected @endif value="who">WHO</option>
            <option @if ($data->external_agencies == 'local_fda') selected @endif value="local_fda">Local FDA</option>
            <option @if ($data->external_agencies == 'tga') selected @endif value="tga">TGA</option>
            <option value="others" @if ($data->external_agencies == 'others') selected @endif>Others</option>
        </select>
    </div>
</div>
      
<div class="col-lg-6" id="others_group">
    <div class="group-input">
        <label for="others">Others<span class="text-danger d-none">*</span></label>
        <textarea name="others" id="others" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->others }}</textarea>
    </div>
</div>

                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Initial Comments">Description</label>
                                                <textarea class="tiny" name="initial_comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->initial_comments }}</textarea>
                                            </div>
                                        </div>
                                        
                                    
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="File Attachments">Initial Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div disabled  class="file-attachment-list" id="inv_attachment">
                                                        @if ($data->inv_attachment)
                                                            @foreach(json_decode($data->inv_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <div  class="add-btn">
                                                        <div>Add</div>
                                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="inv_attachment[]"
                                                         oninput="addMultipleFiles(this, 'inv_attachment')"
                                                            multiple>
                                                    </div>
                                                </div>
                                                {{-- <input type="file" id="myfile" name="file_attachment"
                                                    value="{{ $data->file_attachment }}" --}}
                                                    {{-- {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Planning content -->
                            <div id="CCForm2" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Audit Schedule Start Date">Audit Schedule Start Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="start_date"  readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data->start_date) }}"
                                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}/>
                                                    <input type="date" id="start_date_checkdate" name="start_date"min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->start_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input  input-date">
                                                <label for="Audit Schedule End Date">Audit Schedule End Date</label>
                                                <div class="calenderauditee">                                     
                                                    <input type="text"  id="end_date"  readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data->end_date) }}"
                                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}/>
                                                    <input type="date" id="end_date_checkdate" name="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->end_date }}" class="hide-input"
                                                    oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
    <div class="group-input">
        <label for="audit-agenda-grid">
            Audit Agenda
            <button type="button" name="audit-agenda-grid" onclick="addAuditAgenda('audit-agenda-grid')" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>+</button>
        </label>
        <table class="table table-bordered" id="audit-agenda-grid">
            <thead>
                <tr>
                    <th>Row #</th>
                    <th>Area of Audit</th>
                    <th>Scheduled Start Date</th>
                    <th>Scheduled Start Time</th>
                    <th>Scheduled End Date</th>
                    <th>Scheduled End Time</th>
                    <th>Auditor</th>
                    <th>Auditee</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($sgrid->start_date)
                    @foreach (unserialize($sgrid->start_date) as $key => $temps)
                        <tr>
                            <td><input disabled type="text" name="serial_number[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $key + 1 }}"></td>
                            <td><input type="text" name="audit[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($sgrid->area_of_audit)[$key] ?? '' }}"></td>
                            <td>
                                <div class="group-input new-date-data-field mb-0">
                                    <div class="input-date ">
                                        <div class="calenderauditee">
                                            <input type="text" class="test" id="scheduled_start_date{{$key}}" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat(unserialize($sgrid->start_date)[$key]) }}" />
                                            <input type="date" id="schedule_start_date{{$key}}_checkdate" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="scheduled_start_date[]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ unserialize($sgrid->start_date)[$key] }}" class="hide-input" oninput="handleDateInput(this, `scheduled_start_date{{$key}}`);checkDate('schedule_start_date{{$key}}_checkdate','schedule_end_date{{$key}}_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><input type="time" name="scheduled_start_time[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($sgrid->start_time)[$key] ?? '' }}"></td>
                            <td>
                                <div class="group-input new-date-data-field mb-0">
                                    <div class="input-date ">
                                        <div class="calenderauditee">
                                            <input type="text" class="test" id="scheduled_end_date{{$key}}" readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat(unserialize($sgrid->end_date)[$key]) }}" />
                                            <input type="date" id="schedule_end_date{{$key}}_checkdate" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} name="scheduled_end_date[]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ unserialize($sgrid->end_date)[$key] }}" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date{{$key}}`);checkDate('schedule_start_date{{$key}}_checkdate','schedule_end_date{{$key}}_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><input type="time" name="scheduled_end_time[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($sgrid->end_time)[$key] ?? '' }}"></td>
                            <td>
                                <select id="select-state" placeholder="Select..." name="auditor[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                    <option value="">-Select-</option>
                                    @foreach ($users as $value)
                                        <option {{ unserialize($sgrid->auditor)[$key] == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select id="select-state" placeholder="Select..." name="auditee[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                    <option value="">-Select-</option>
                                    @foreach ($users as $value)
                                        <option {{ unserialize($sgrid->auditee)[$key] == $value->id ? 'selected' : '' }} value="{{ $value->id }}">{{ $value->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" name="remark[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ unserialize($sgrid->remark)[$key] ?? '' }}"></td>
                            <td><button type="button" class="removeRowBtn" onclick="removeRow(this)">Remove</button></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
                                       
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Product/Material Name">Product/Material Name</label>
                                                <input type="text" name="material_name"
                                                    value="{{ $data->material_name }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments(If Any)">Comments(If Any)</label>
                                                <textarea  class="tiny" name="if_comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->if_comments }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Preparation content -->
                            <div id="CCForm3" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Lead Auditor">Lead Auditor</label>
                                                <select name="lead_auditor"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($users as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            @if ($data->lead_auditor == $value->id) selected @endif>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="File Attachments">File Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div disabled  class="file-attachment-list" id="file_attachment">
                                                        @if ($data->file_attachment)
                                                            @foreach(json_decode($data->file_attachment) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <div  class="add-btn">
                                                        <div>Add</div>
                                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="file_attachment[]"
                                                         oninput="addMultipleFiles(this, 'file_attachment')"
                                                            multiple>
                                                    </div>
                                                </div>
                                                {{-- <input type="file" id="myfile" name="file_attachment"
                                                    value="{{ $data->file_attachment }}" --}}
                                                    {{-- {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                            </div>
                                        </div>
                                        {{-- <div class="col-12">
                                            <div class="group-input">
                                                <label for="audit-agenda-grid">
                                                    Observation Details
                                                    <button type="button" name="audit-agenda-grid"
                                                      id="ObservationAdd">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal"
                                                        data-bs-target="#observation-field-instruction-modal"
                                                        style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="onservation-field-table"
                                                        style="width: 150%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Row#</th>
                                                                <th>Observation ID</th>
                                                                <th>Date</th>
                                                                <th>Auditor</th>
                                                                <th>Auditee</th>
                                                                <th>Observation Description</th>
                                                                <th>Severity Level</th>
                                                                <th>Area/process</th>
                                                                <th>Observation Category</th>
                                                                <th>CAPA Required</th>
                                                                <th>Auditee Response</th>
                                                                <th>Auditor Review on Response</th>
                                                                <th>QA Comments</th>
                                                                <th>CAPA Details</th>
                                                                <th>CAPA Due Date</th>
                                                                <th>CAPA Owner</th>
                                                                <th>Action Taken</th>
                                                                <th>CAPA Completion Date</th>
                                                                <th>Status</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="observationDetail">
                                                            @if ($grid_data1->observation_id)
                                                            @foreach (unserialize($grid_data1->observation_id) as $key => $tempData)
                                                            <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input type="text" name="observation_id[]" value="{{ $tempData ? $tempData : "" }}"></td>
                                                                    <td><input type="date" name="date[]" value="{{unserialize($grid_data1->date)[$key] ? unserialize($grid_data1->date)[$key]: "" }}"></td>
                                                                <td>
                                                                    <select placeholder="Select..." name="auditorG[]">
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $datas)
                                                                            <option value="{{ $datas->id }}">

                                                                                {{ $datas->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <select placeholder="Select..." name="auditeeG[]">
                                                                        <option value="">Select a value</option>
                                                                        @foreach ($users as $datas)
                                                                            <option value="{{ $datas->id }}">

                                                                                {{ $datas->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </td>                                                            <td><input type="text" name="observation_description[]" value="{{unserialize($grid_data1->observation_description)[$key] ? unserialize($grid_data1->observation_description)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="severity_level[]" value="{{unserialize($grid_data1->severity_level)[$key] ? unserialize($grid_data1->severity_level)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="area[]" value="{{unserialize($grid_data1->area)[$key] ? unserialize($grid_data1->area)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observation_category[]" value="{{unserialize($grid_data1->observation_category)[$key] ? unserialize($grid_data1->observation_category)[$key]: "" }}"></td>
                                                                    <td>
                                                                        <select name="capa_required[]">
                                                                            <option value="0">-- Select --</option>
                                                                            <option value="yes">Yes</option>
                                                                            <option value="no">No</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" name="auditee_response[]" value="{{unserialize($grid_data1->auditee_response)[$key] ? unserialize($grid_data1->auditee_response)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="auditor_review_on_response[]" value="{{unserialize($grid_data1->auditor_review_on_response)[$key] ? unserialize($grid_data1->auditor_review_on_response)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="qa_comment[]" value="{{unserialize($grid_data1->qa_comment)[$key] ? unserialize($grid_data1->qa_comment)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capa_details[]" value="{{unserialize($grid_data1->capa_details)[$key] ? unserialize($grid_data1->capa_details)[$key]: "" }}"></td>
                                                                    <td><input type="date" name="capa_due_date[]" value="{{unserialize($grid_data1->capa_due_date)[$key] ? unserialize($grid_data1->capa_due_date)[$key]: "" }}"></td>
                                                                    <td>
                                                                        <select placeholder="Select..." name="capa_owner[]">
                                                                            <option value="">Select a value</option>
                                                                            @foreach ($users as $datas)
                                                                                <option value="{{ $datas->id }}">
                                                                                    {{ $datas->name }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" name="action_taken[]" value="{{unserialize($grid_data1->action_taken)[$key] ? unserialize($grid_data1->action_taken)[$key]: "" }}"></td>
                                                                    <td><input type="date" name="capa_completion_date[]" value="{{unserialize($grid_data1->capa_completion_date)[$key] ? unserialize($grid_data1->capa_completion_date)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="status_Observation[]" value="{{unserialize($grid_data1->status)[$key] ? unserialize($grid_data1->status)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="remark_observation[]" value="{{unserialize($grid_data1->remark)[$key] ? unserialize($grid_data1->remark)[$key]: "" }}"></td>
                                                                </tr>
                                                            @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Audit Team">Audit Team</label>
                                                <select multiple name="Audit_team[]" placeholder="Select Audit Team"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="Audit"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ in_array($user->id, explode(',', $data->Audit_team)) ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="group-input">
                                                <label for="Auditee">Auditee</label>
                                                <select multiple name="Auditee[]" placeholder="Select Auditee"
                                                    data-search="false" data-silent-initial-value-set="true"
                                                    id="Auditee"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}"
                                                            {{ in_array($user->id, explode(',', $data->Auditee)) ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="External Auditor Details">Suppliers Auditor Details</label>
                                                <textarea  class="tiny" name="Auditor_Details" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Auditor_Details }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="External Auditing Agency">Supplier Auditing Agency</label>
                                                <textarea class="tiny" name="External_Auditing_Agency" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->External_Auditing_Agency }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Relevant Guidelines / Industry Standards">Relevant Guidelines / Industry Standards</label>
                                                <textarea class="tiny" name="Relevant_Guidelines" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Relevant_Guidelines}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="QA Comments">QA Comments</label>
                                                <textarea class="tiny" name="QA_Comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->QA_Comments}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Guideline Attachment">Guideline Attachment</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting
                                                        documents</small></div>
                                                <div class="file-attachment-field">
                                                    <div disabled  class="file-attachment-list" id="file_attachment_guideline">
                                                        @if ($data->file_attachment_guideline)
                                                            @foreach(json_decode($data->file_attachment_guideline) as $file)
                                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                    <b>{{ $file }}</b>
                                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                                </h6>
                                                            @endforeach
                                                        @endif

                                                    </div>
                                                    <div  class="add-btn">
                                                        <div>Add</div>
                                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="file_attachment_guideline[]"
                                                            oninput="addMultipleFiles(this, 'file_attachment_guideline')"
                                                            multiple>
                                                    </div>
                                                </div>

                                                
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Category">Audit Category</label>
                                                <select name="Audit_Category" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->Audit_Category == '1') selected @endif
                                                         value="1">Internal Audit/Self Inspection</option>
                                                    <option  @if ($data->Audit_Category == '2') selected @endif
                                                         value="2">Supplier Audit</option>
                                                    <option @if ($data->Audit_Category == '3') selected @endif
                                                         value="3">Regulatory Audit</option>
                                                    <option @if ($data->Audit_Category == '4') selected @endif
                                                         value="4">Consultant Audit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Supplier/Vendor/Manufacturer Details">Supplier/Vendor/Manufacturer Details</label>
                                                <textarea class="tiny" type="text" name="Supplier_Details" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Supplier_Details}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Supplier/Vendor/Manufacturer Site">Supplier/Vendor/Manufacturer Site</label>
                                                <textarea class="tiny" type="text" name="Supplier_Site" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Supplier_Site}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Comments">Comments</label>
                                                <textarea class="tiny" name="Comments" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Comments }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Execution content -->
                            <div id="CCForm4" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        {{-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Due Date">Due Date</label>
                                                <input type="hidden" name="due_date" value="{{ $data->due_date }}">
                                                <div class="static">{{ $data->due_date }}</div>
                                            </div>
                                        </div> --}}
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Audit Start Date">Audit Start Date</label>
                                                    <div class="calenderauditee">                                     
                                                        <input type="text"  id="audit_start_date"  readonly placeholder="DD-MM-YYYY"  value="{{ Helpers::getdateFormat($data->audit_start_date) }}"
                                                        {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} />
                                                        <input type="date" id="audit_start_date_checkdate" name="audit_start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->audit_start_date }}"
                                                        class="hide-input"
                                                        oninput="handleDateInput(this, 'audit_start_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')"/>
                                                    </div>    
                                            </div>
                                        </div>
                                        <div class="col-lg-6 new-date-data-field">
                                            <div class="group-input input-date">
                                                <label for="Audit End Date">Audit End Date</label>
                                                    <div class="calenderauditee">                                     
                                                    <input type="text"  id="audit_end_date"  readonly placeholder="DD-MM-YYYY" value="{{ Helpers::getdateFormat($data->audit_end_date) }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} />
                                                    <input type="date" id="audit_end_date_checkdate" name="audit_end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $data->audit_end_date }}"
                                                    class="hide-input"
                                                    oninput="handleDateInput(this, 'audit_end_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')"/>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="file" id="file-input" />
                                            <button type="button" onclick="importExcel()">Import Observations</button>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="audit-agenda-grid">
                                                    Observation Details
                                                    <button type="button" name="audit-agenda-grid" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} id="ObservationAdd">+</button>
                                                    <span class="text-primary" data-bs-toggle="modal" data-bs-target="#observation-field-instruction-modal" style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                        (Launch Instruction)
                                                    </span>
                                                </label>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="onservation-field-table" style="width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Row#</th>
                                                                <th>Site/Location</th>                                                 
                                                                <th>Site ID</th> 
                                                                <th>Reference No.</th>
                                                                <th>Observation Short Description</th> 
                                                                <th>Observation Detail Description</th>
                                                                <th>Observation Category</th>
                                                                <th>Observation Sub Category</th> 
                                                                <th>Frequency</th> 
                                                                <th>Auditing Agency</th>
                                                                <th>Audit Type</th>
                                                                <th>Audit Start Date</th>
                                                                <th>Audit End Date</th>
                                                                <th>Auditor</th>
                                                                <th>Observation Category</th> 
                                                                <th>Observation Type</th>
                                                                <th>Observation Area</th>
                                                                <th>Observation Area SubCategory</th>
                                                                <th>CAPA Required</th>
                                                                <th>CAPA Owner</th>
                                                                <th>CAPA Short Description</th>
                                                                <th>CAPA Due Date</th>
                                                                <th>CAPA Status</th>
                                                                <th>Delay Justification</th>
                                                                <th>Delay Category</th>
                                                                <th>Remarks</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="observationDetail">
                                                            @if ($sgrid->observation_detail)
                                                                @foreach (unserialize($sgrid->observation_detail) as $key => $tempData)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td><input type="text" name="divisionCode[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->divisionCode)[$key] ? unserialize($sgrid->divisionCode)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="siteId[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->siteId)[$key] ? unserialize($sgrid->siteId)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="referenceNo[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->referenceNo)[$key] ? unserialize($sgrid->referenceNo)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observationShortDesc[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observationShortDesc)[$key] ? unserialize($sgrid->observationShortDesc)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observation_detail[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observation_detail)[$key] ? unserialize($sgrid->observation_detail)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observationCategory[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observationCategory)[$key] ? unserialize($sgrid->observationCategory)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observationSubCat[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observationSubCat)[$key] ? unserialize($sgrid->observationSubCat)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="frequency[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->frequency)[$key] ? unserialize($sgrid->frequency)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="auditingAgency[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->auditingAgency)[$key] ? unserialize($sgrid->auditingAgency)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="audittype[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->audittype)[$key] ? unserialize($sgrid->audittype)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="auditStartDate[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->auditStartDate)[$key] ? unserialize($sgrid->auditStartDate)[$key]: "" }}"></td> 
                                                                    <td><input type="text" name="auditEndDate[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->auditEndDate)[$key] ? unserialize($sgrid->auditEndDate)[$key]: "" }}"></td>                       
                                                                    <td><input type="text" name="auditor[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->auditor)[$key] ? unserialize($sgrid->auditor)[$key]: "" }}"></td>                    
                                                                    <td><input type="text" name="observation_category[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observation_category)[$key] ? unserialize($sgrid->observation_category)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observationType[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observationType)[$key] ? unserialize($sgrid->observationType)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observationArea[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observationArea)[$key] ? unserialize($sgrid->observationArea)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="observationAreaSubCat[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->observationAreaSubCat)[$key] ? unserialize($sgrid->observationAreaSubCat)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capaRequired[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->capaRequired)[$key] ? unserialize($sgrid->capaRequired)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capaOwner[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->capaOwner)[$key] ? unserialize($sgrid->capaOwner)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capaDescription[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->capaDescription)[$key] ? unserialize($sgrid->capaDescription)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capaDueDate[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->capaDueDate)[$key] ? unserialize($sgrid->capaDueDate)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="capaSatus[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->capaSatus)[$key] ? unserialize($sgrid->capaSatus)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="delayJustification[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->delayJustification)[$key] ? unserialize($sgrid->delayJustification)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="delayCategory[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->delayCategory)[$key] ? unserialize($sgrid->delayCategory)[$key]: "" }}"></td>
                                                                    <td><input type="text" name="remarks[]" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{unserialize($sgrid->remarks)[$key] ? unserialize($sgrid->remarks)[$key]: "" }}"></td>
                                                                    <td><input type="text" readonly name="Action[]" >

                                                                </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Audit Attachments">Audit Attachments</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="Audit_file"
                                                    value="{{ $data->Audit_file }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="Audit_file">
                                                            @if ($data->Audit_file)
                                                            @foreach(json_decode($data->Audit_file) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                       @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input type="file" id="myfile" name="Audit_file[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}
                                                                oninput="addMultipleFiles(this, 'Audit_file')" multiple>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Comments">Audit Comments</label>
                                                <textarea class="tiny" name="Audit_Comments1" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Audit_Comments1 }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Audit Response & Closure content -->
                            <div id="CCForm5" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="sub-head">
                                            Audit Response
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Remarks">Remarks</label>
                                                <textarea class="tiny" name="Remarks" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Remarks }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Reference Recores">Reference Record</label>
                                                <select {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} multiple id="reference_record" name="refrence_record[]" id="">
                                                    {{-- <option value="">--Select---</option> --}}
                                                    @foreach ($old_record as $new)
                                                        <option value="{{ $new->id }}"  {{ in_array($new->id, explode(',', $data->Reference_Recores1)) ? 'selected' : '' }}>
                                                            {{ Helpers::getDivisionName($new->division_id) }}/IA/{{date('Y')}}/{{ Helpers::recordFormat($new->record) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="group-input">
                                                <label for="Report Attachments">Report Attachments</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="report_file"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="report_attachment">
                                                            @if ($data->report_file)
                                                            @foreach(json_decode($data->report_file) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                       @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input  {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="report_file[]"
                                                                oninput="addMultipleFiles(this, 'report_attachment')" multiple>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Attachments">Audit Attachments</label>
                                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                                {{-- <input type="file" id="myfile" name="myfile"
                                                    value="{{ $data->myfile }}"
                                                    {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}> --}}
                                                    <div class="file-attachment-field">
                                                        <div class="file-attachment-list" id="audit_attachment">
                                                            @if ($data->myfile)
                                                            @foreach(json_decode($data->myfile) as $file)
                                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                       @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="add-btn">
                                                            <div>Add</div>
                                                            <input  {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="myfile[]"
                                                                oninput="addMultipleFiles(this, 'audit_attachment')" multiple>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="Audit Comments">Audit Comments</label>
                                                <textarea class="tiny" name="Audit_Comments2" {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{ $data->Audit_Comments2 }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="group-input">
                                                <label for="due_date_extension">Due Date Extension Justification</label>
                                                <div><small class="text-primary">Please Mention justification if due date is crossed</small></div>
                                            <textarea class="tiny" name="due_date_extension"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>{{$data->due_date_extension}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-block">
                                        @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Log content -->
                            <div id="CCForm6" class="inner-block cctabcontent">
                                <div class="inner-block-content">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Schedule Audit By</label>
                                                <div class="static">{{ $data->audit_schedule_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Schedule Audit On</label>
                                                <div class="static">{{ $data->audit_schedule_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Comment</label>
                                                <div class="static">{{ $data->comment }}</div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Preparation Completed On">Completed Audit Preparation
                                                    By</label>
                                                <div class="static">{{ $data->audit_preparation_completed_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Preparation Completed On">Completed Audit Preparation
                                                    On</label>
                                                <div class="static">{{ $data->audit_preparation_completed_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Comment</label>
                                                <div class="static">{{ $data->audit_preparation_comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Response Feedback Verified By"> Rejected By
                                                    </label> 
                                                <div class="static">{{ $data->rejected_by}}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Response Feedback Verified On"> Rejected On
                                                    </label>
                                                <div class="static">{{ $data->rejected_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Comment</label>
                                                <div class="static">{{$data->comment_rejected_comment}}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancelled By">Cancelled By</label>
                                                <div class="static">{{ $data->cancelled_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Cancelled On">Cancelled On</label>
                                                <div class="static">{{ $data->cancelled_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On"> Comment</label>
                                                <div class="static">{{$data->comment_cancelled_comment}}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Mgr.more Info Reqd By">Issue  Report
                                                    By</label>
                                                <div class="static">{{ $data->audit_mgr_more_info_reqd_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Mgr.more Info Reqd On">Issue  Report
                                                    On</label>
                                                <div class="static">{{ $data->audit_mgr_more_info_reqd_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Comment</label>
                                                <div class="static">{{ $data->pending_response_comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Observation Submitted By">CAPA Plan Proposed
                                                    By</label>
                                                <div class="static">{{ $data->audit_observation_submitted_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Observation Submitted On">CAPA Plan Proposed
                                                    On</label>
                                                <div class="static">{{ $data->audit_observation_submitted_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Comment</label>
                                                <div class="static">{{ $data->capa_execution_in_progress_comment }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Lead More Info Reqd By">All CAPA Closed By</label>
                                                <div class="static">{{ $data->audit_lead_more_info_reqd_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Lead More Info Reqd On">All CAPA Closed On</label>
                                                <div class="static">{{ $data->audit_lead_more_info_reqd_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="group-input">
                                                <label for="Audit Schedule On">Comment</label>
                                                <div class="static">{{ $data->comment_closed_done_by_comment }}</div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Audit Response Completed By">Audit Response Completed
                                                    By</label>
                                                <div class="static">{{ $data->audit_response_completed_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Audit Response Completed On">Audit Response Completed
                                                    On</label>
                                                <div class="static">{{ $data->audit_response_completed_on }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Response Feedback Verified By">Response Feedback Verified
                                                    By</label>
                                                <div class="static">{{ $data->response_feedback_verified_by }}</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="group-input">
                                                <label for="Response Feedback Verified On">Response Feedback Verified
                                                    On</label>
                                                <div class="static">{{ $data->response_feedback_verified_on }}</div>
                                            </div>
                                        </div> -->


                                    </div>
                                    <div class="button-block">
                                        <!-- @if ($data->stage != 0)
                                            <button type="submit" id="ChangesaveButton" class="saveButton"
                                                {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Save</button>
                                        @endif -->
                                        <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                        <!-- <button type="submit"
                                            {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }}>Submit</button> -->
                                        <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"
                                                class="text-white"> Exit </a> </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
            <div class="modal fade" id="child-modal1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('extension_child', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            {{-- <div class="modal-body">
                                <div class="group-input">
                                    <label for="major">
                                        <input type="hidden" name="parent_name" value="External_audit">
                                        <input type="hidden" name="due_date" value="{{ $data->due_date }}">
                                        <input type="radio" name="child_type" value="extension">
                                        extension
                                    </label>

                                </div>

                            </div> --}}

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


            <div class="modal fade" id="signature-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('SupplierAuditStateChange_view', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment</label>
                                    <input type="comment" name="comment">
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="rejection-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ url('RejectStateAuditee', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment" required >
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button type="button" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="cancel-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">E-Signature</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('CancelStateRegulatoryInspection', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="mb-3 text-justify">
                                    Please select a meaning and a outcome for this task and enter your username
                                    and password for this task. You are performing an electronic signature,
                                    which is legally binding equivalent of a hand written signature.
                                </div>
                                <div class="group-input">
                                    <label for="username">Username <span class="text-danger">*</span></label>
                                    <input type="text" name="username" required>
                                </div>
                                <div class="group-input">
                                    <label for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" required>
                                </div>
                                <div class="group-input">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <input type="comment" name="comment"required >
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <!-- <div class="modal-footer">
                                <button type="submit" data-bs-dismiss="modal">Submit</button>
                                <button>Close</button>
                            </div> -->
                            <div class="modal-footer">
                              <button type="submit">Submit</button>
                                <button data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="child-modal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Child</h4>
                        </div>
                        <form action="{{ route('child_external_Supplier', $data->id) }}" method="POST">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="group-input">
                                    <label></lable>
                                    <label for="major">
                                        <input type="radio" name="child_type" value="Observations">
                                        Observations
                                    </label>
                                </div>
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" data-bs-dismiss="modal">Close</button>
                                <button type="submit">Continue</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <style>
                #step-form>div {
                    display: none
                }

                #step-form>div:nth-child(1) {
                    display: block;
                }
            </style>

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>

<script>
    function importExcel() {
        const fileInput = document.getElementById('file-input');
        const file = fileInput.files[0];
    
        if (!file) {
            alert('Please select a file first');
            return;
        }
    
        const reader = new FileReader();
    
        reader.onload = function(event) {
            const data = new Uint8Array(event.target.result);
            const workbook = XLSX.read(data, { type: 'array' });
            const sheetName = workbook.SheetNames[0];
            const worksheet = workbook.Sheets[sheetName];
            const jsonData = XLSX.utils.sheet_to_json(worksheet);
    
            populateTable(jsonData);
        };
    
        reader.readAsArrayBuffer(file);
    }
    
    function populateTable(data) {
        const tbody = document.getElementById('observationDetail');
        tbody.innerHTML = ''; // Clear existing table data
    
        data.forEach((row, index) => {
            const tr = document.createElement('tr');
    
            Object.keys(row).forEach((key) => {
                const td = document.createElement('td');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = `${key}[${index}]`;
                input.value = row[key];
                td.appendChild(input);
                tr.appendChild(td);
            });
    
            tbody.appendChild(tr);
        });
    }
    </script>
            <script>
                VirtualSelect.init({
                    ele: '#Facility, #Group, #Audit, #Auditee , #reference_record'
                });

                function openCity(evt, cityName) {
                    var i, cctabcontent, cctablinks;
                    cctabcontent = document.getElementsByClassName("cctabcontent");
                    for (i = 0; i < cctabcontent.length; i++) {
                        cctabcontent[i].style.display = "none";
                    }
                    cctablinks = document.getElementsByClassName("cctablinks");
                    for (i = 0; i < cctablinks.length; i++) {
                        cctablinks[i].className = cctablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";
                }



                function openCity(evt, cityName) {
                    var i, cctabcontent, cctablinks;
                    cctabcontent = document.getElementsByClassName("cctabcontent");
                    for (i = 0; i < cctabcontent.length; i++) {
                        cctabcontent[i].style.display = "none";
                    }
                    cctablinks = document.getElementsByClassName("cctablinks");
                    for (i = 0; i < cctablinks.length; i++) {
                        cctablinks[i].className = cctablinks[i].className.replace(" active", "");
                    }
                    document.getElementById(cityName).style.display = "block";
                    evt.currentTarget.className += " active";

                    // Find the index of the clicked tab button
                    const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

                    // Update the currentStep to the index of the clicked tab
                    currentStep = index;
                }

                const saveButtons = document.querySelectorAll(".saveButton");
                const nextButtons = document.querySelectorAll(".nextButton");
                const form = document.getElementById("step-form");
                const stepButtons = document.querySelectorAll(".cctablinks");
                const steps = document.querySelectorAll(".cctabcontent");
                let currentStep = 0;

                function nextStep() {
                    // Check if there is a next step
                    if (currentStep < steps.length - 1) {
                        // Hide current step
                        steps[currentStep].style.display = "none";

                        // Show next step
                        steps[currentStep + 1].style.display = "block";

                        // Add active class to next button
                        stepButtons[currentStep + 1].classList.add("active");

                        // Remove active class from current button
                        stepButtons[currentStep].classList.remove("active");

                        // Update current step
                        currentStep++;
                    }
                }

                function previousStep() {
                    // Check if there is a previous step
                    if (currentStep > 0) {
                        // Hide current step
                        steps[currentStep].style.display = "none";

                        // Show previous step
                        steps[currentStep - 1].style.display = "block";

                        // Add active class to previous button
                        stepButtons[currentStep - 1].classList.add("active");

                        // Remove active class from current button
                        stepButtons[currentStep].classList.remove("active");

                        // Update current step
                        currentStep--;
                    }
                }
            </script>

            <script>
                document.getElementById('initiator_group').addEventListener('change', function() {
                    var selectedValue = this.value;
                    document.getElementById('initiator_group_code').value = selectedValue;
                });
            </script>
                      <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const removeButtons = document.querySelectorAll('.remove-file');
            
                            removeButtons.forEach(button => {
                                button.addEventListener('click', function () {
                                    const fileName = this.getAttribute('data-file-name');
                                    const fileContainer = this.closest('.file-container');
            
                                    // Hide the file container
                                    if (fileContainer) {
                                        fileContainer.style.display = 'none';
                                    }
                                });
                            });
                        });
                    </script>
                     <script>
                        var maxLength = 255;
                        $('#docname').keyup(function() {
                            var textlen = maxLength - $(this).val().length;
                            $('#rchars').text(textlen);});
                    </script>
  <script>
    var maxLength = 255;
    $('#docname').keyup(function() {
        var textlen = maxLength - $(this).val().length;
        $('#rchars').text(textlen);});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const externalAgencies = document.getElementById('external_agencies');
        const othersGroup = document.getElementById('others_group');
        const othersField = document.getElementById('others');
        const othersLabel = othersField.previousElementSibling;

        function toggleOthersField() {
            if (externalAgencies.value === 'others') {
                othersGroup.style.display = 'block';
                othersField.required = true;
                othersLabel.querySelector('span').classList.remove('d-none');
            } else {
                othersGroup.style.display = 'none';
                othersField.required = false;
                othersLabel.querySelector('span').classList.add('d-none');
            }
        }

        // Initial check
        toggleOthersField();

        // Add event listener
        externalAgencies.addEventListener('change', toggleOthersField);
    });
</script>

<!-- Ensure this CSS is present to initially hide the Others field and its group -->
<style>
    #others_group {
        display: none;
    }
</style>
        @endsection
