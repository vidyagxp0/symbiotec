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
    </style>

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
        cell3.innerHTML = '<div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="scheduled_start_date' + currentRowCount + '" readonly placeholder="DD-MM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' + currentRowCount + '_checkdate" class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' + currentRowCount + '`);checkDate(`scheduled_start_date' + currentRowCount + '_checkdate`,`scheduled_end_date' + currentRowCount + '_checkdate`)" /></div></div></div>';

        var cell4 = newRow.insertCell(3);
        cell4.innerHTML = "<input type='time' name='scheduled_start_time[]'>";

        var cell5 = newRow.insertCell(4);
        cell5.innerHTML = '<div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"><input type="text" id="scheduled_end_date' + currentRowCount + '" readonly placeholder="DD-MM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date' + currentRowCount + '_checkdate" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' + currentRowCount + '`);checkDate(`scheduled_start_date' + currentRowCount + '_checkdate`,`scheduled_end_date' + currentRowCount + '_checkdate`)" /></div></div></div>';

        var cell6 = newRow.insertCell(5);
        cell6.innerHTML = "<input type='time' name='scheduled_end_time[]'>";

        var cell7 = newRow.insertCell(6);
        var auditorHtml = '<select name="auditor[]"><option value="">-- Select --</option>';
        for (var i = 0; i < users.length; i++) {
            auditorHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
        }
        auditorHtml += '</select>';
        cell7.innerHTML = auditorHtml;

        var cell8 = newRow.insertCell(7);
        var auditeeHtml = '<select name="auditee[]"><option value="">-- Select --</option>';
        for (var i = 0; i < users.length; i++) {
            auditeeHtml += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
        }
        auditeeHtml += '</select>';
        cell8.innerHTML = auditeeHtml;

        var cell9 = newRow.insertCell(8);
        cell9.innerHTML = "<input type='text' name='remarks[]'>";

        var cell10 = newRow.insertCell(9);
        cell10.innerHTML = '<button type="button" class="removeRowBtn">Remove</button>';
    }

    $(document).on('click', '.removeRowBtn', function() {
        $(this).closest('tr').remove();
        updateRowNumbers();
    });

    function updateRowNumbers() {
        $('#internalaudit tbody tr').each(function(index, row) {
            $(row).find('td:first').text(index + 1);
        });
    }
</script>

    <script>
        $(document).ready(function() {
            $('#internalaudit-table').click(function(e) {
                let index = 0;
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    console.log(users);
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

                var tableBody = $('#internalaudit tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    @php
    $division = DB::table('divisions')->get();
     @endphp
     <script>
      $(document).ready(function() {
        $('#ObservationAdd').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);
                var html =
                    '<tr>' +
                    '<td>' + serialNumber + '</td>' +
                    '<td><input type="text" name="observation_id[]"></td>' +
                    '<td><input type="text" name="observation_description[]"></td>' +
                    '<td><input type="text" name="area[]"></td>' +
                    '<td><input type="text" name="auditee_response[]"></td>' +
                    '<td><input type="text" name="observation_id[]"></td>' +
                    '<td><input type="text" name="observation_description[]"></td>' +
                    '<td><input type="text" name="area[]"></td>' +
                    '<td><input type="text" name="auditee_response[]"></td>' +
                    '<td><input type="text" name="observation_id[]"></td>' +
                    '<td><input type="text" name="observation_description[]"></td>' +
                    '<td><input type="text" name="area[]"></td>' +
                    '<td><input type="text" name="auditee_response[]"></td>' +
                    '<td><input type="text" name="observation_id[]"></td>' +
                    '<td><input type="text" name="observation_description[]"></td>' +
                    '<td><input type="text" name="area[]"></td>' +
                    '<td><input type="text" name="auditee_response[]"></td>' +
                    '<td><input type="text" name="observation_id[]"></td>' +
                    '<td><input type="text" name="observation_description[]"></td>' +
                    '<td><input type="text" name="area[]"></td>' +                    
                    '<td><button type="button" class="removeRowBtn">Remove</button></td>' +
                    '</tr>';
                return html;
            }
            var tableBody = $('#onservation-field-table tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
            updateRowNumbers();
        });
                // Remove row functionality
                $(document).on('click', '.removeRowBtn', function() {
            $(this).closest('tr').remove();
            updateRowNumbers();
        });
        function updateRowNumbers() {
            $('#onservation-field-table tbody tr').each(function(index, row) {
                $(row).find('td:first').text(index + 1);
            });
        }
    });
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

    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Regulatory Inspection
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}




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

            <form id="auditform" action="{{ route('regulatory_audit_store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                         <input disabled type="text" name="record_number"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}/RI/{{ date('Y') }}/{{ $record_number }}"> 
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input disabled type="text" name="division_id" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                    <input type="hidden" name="division_id" value="{{ session()->get('division') }}">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" value="{{ Auth::user()->name }}">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
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
                                    <!-- <div class="calenderauditee"> -->
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" name="due_date" readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" readonly  name="due_date_n" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                    <!-- </div> -->
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
                                    <select name="Initiator_Group" id="initiator_group">
                                        <option value="">-- Select --</option>
                                        <option value="CQA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CQA') selected @endif>Corporate Quality Assurance</option>
                                        <option value="QAB" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'QAB') selected @endif>Quality Assurance Biopharma</option>
                                        <option value="CQC" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CQC') selected @endif>Central Quality Control</option>
                                        <option value="MANU" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'MANU') selected @endif>Manufacturing</option>
                                        <option value="PSG" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'PSG') selected @endif>Plasma Sourcing Group</option>
                                        <option value="CS" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CS') selected @endif>Central Stores</option>
                                        <option value="ITG" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'ITG') selected @endif>Information Technology Group</option>
                                        <option value="MM" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'MM') selected @endif>Molecular Medicine</option>
                                        <option value="CL" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'CL') selected @endif>Central Laboratory</option>
                                        <option value="TT" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'TT') selected @endif>Tech team</option>
                                        <option value="QA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'QA') selected @endif>Quality Assurance</option>
                                        <option value="QM" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'QM') selected @endif>Quality Management</option>
                                        <option value="IA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'IA') selected @endif>IT Administration</option>
                                        <option value="ACC" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'ACC') selected @endif>Accounting</option>
                                        <option value="LOG" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'LOG') selected @endif>Logistics</option>
                                        <option value="SM" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'SM') selected @endif>Senior Management</option>
                                        <option value="BA" @if (old('Initiator_Group', $data->Initiator_Group ?? '') == 'BA') selected @endif>Business Administration</option>
                                    </select>
                                </div>
                            </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Initiator Group Code</label>
                                        <input type="text" name="initiator_group_code" id="initiator_group_code"
                                            value="" readonly>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                    class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please mention brief summary</small></div>
                                        <textarea name="short_description"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                    </div>
                                </div>  
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="severity-level">Severity Level</label>
                                        <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span>
                                        <select name="severity_level">
                                            <option value="0">-- Select --</option>
                                            <option value="minor">Minor</option>
                                            <option value="major">Major</option>
                                            <option value="critical">Critical</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Initiated Through</label>
                                        <div><small class="text-primary">Please select related information</small></div>
                                        <select name="initiated_through"
                                            onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                            <option value="">-- select --</option>
                                            <option value="recall">Recall</option>
                                            <option value="return">Return</option>
                                            <option value="deviation">Deviation</option>
                                            <option value="complaint">Complaint</option>
                                            <option value="regulatory">Regulatory</option>
                                            <option value="lab-incident">Lab Incident</option>
                                            <option value="improvement">Improvement</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6" id="initiatedThroughBlock">
                                    <div class="group-input" id="initiated_through_req">
                                        <label for="If Other">Others<span class="text-danger d-none">*</span></label>
                                        <textarea  name="initiated_if_other"></textarea>
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
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="repeat">Repeat</label>
                                        <select name="repeat"
                                            onchange="otherController(this.value, 'yes', 'repeat_nature')">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="NA">NA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input" id="repeat_nature">
                                        <label for="repeat_nature">Repeat Nature<span
                                                class="text-danger d-none">*</span></label>
                                        <textarea name="repeat_nature"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Type of Audit</label>
                                        <select name="audit_type"
                                            onchange="otherController(this.value, 'others', 'type_of_audit_req')">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="R&D">R&D</option>
                                            <option value="GLP">GLP</option>
                                            <option value="GCP">GCP</option>
                                            <option value="GDP">GDP</option>
                                            <option value="GEP">GEP</option>
                                            <option value="ISO 17025">ISO 17025</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6"  id="IfOthers">
                                    <div class="group-input" id="type_of_audit_req">
                                        <label for="If Other">If Others<span class="text-danger d-none">*</span></label>
                                        <textarea name="if_other"></textarea>
                                        @error('if_other')
                                            <p class="text-danger">this field is required</p>
                                        @enderror
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
        <label for="supplier_agencies">Supplier Agencies</label>
        <select name="external_agencies" id="supplier_agencies" onchange="toggleOthersField(this.value, 'external_agencies_req', 'others')">
            <option value="">-- Select --</option>
            <option value="jordan_fda">Jordan FDA</option>
            <option value="us_fda">USFDA</option>
            <option value="mhra">MHRA</option>
            <option value="anvisa">ANVISA</option>
            <option value="iso">ISO</option>
            <option value="who">WHO</option>
            <option value="local_fda">Local FDA</option>
            <option value="tga">TGA</option>
            <option value="others">Others</option>
        </select>
    </div>
</div>
<div class="col-lg-6">
    <div class="group-input" id="external_agencies_req">
        <label for="others">Others<span class="text-danger d-none">*</span></label>
        <textarea name="others" id="others"></textarea>
        @error('if_other')
            <p class="text-danger">this field is required</p>
        @enderror
    </div>
</div>
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="others">Others<span class="text-danger d-none">*</span></label>
                                        <textarea name="others"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Initial Comments">Description</label>
                                        <textarea class="tiny" name="initial_comments"></textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Initial Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="audit_file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="inv_attachment[]"
                                                    oninput="addMultipleFiles(this, 'audit_file_attachment')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Planning content -->
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                {{-- <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date ">
                                        <label for="due-date">Due Date <span class="text-danger"></span></label>
                                        <div><small class="text-primary">Please mention expected date of completion</small></div>
                                        <div class="calenderauditee">
                                        <input type="text" name="due_date" id="due_date"  readonly placeholder="DD-MM-YYYY" />
                                        <input type="date" class="hide-input"
                                        oninput="handleDateInput(this, 'due_date')"
                                        />
                                         </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="start_date"><b>Audit Schedule Start Date
                                        </b></label>
                                        <input type="text" value="{{ date('d-M-Y') }}" name="start_date"
                                            disabled>
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="start_date">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Audit Schedule Start Date">Audit Schedule Start Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="start_date" readonly
                                                placeholder="DD-MM-YYYY" />
                                            <input type="date" id="start_date_checkdate" name="start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input"
                                                oninput="handleDateInput(this, 'start_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Audit Schedule End Date">Audit Schedule End Date</label>
                                        <div class="calenderauditee">
                                            <input type="text" id="end_date" readonly
                                                placeholder="DD-MM-YYYY" />
                                            <input type="date" id="end_date_checkdate" name="end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" 
                                                oninput="handleDateInput(this, 'end_date');checkDate('start_date_checkdate','end_date_checkdate')" />
                                        </div>

                                    </div>
                                </div>
                                <div class="col-12">
    <div class="group-input">
        <label for="audit-agenda-grid">
            Audit Agenda<button type="button" name="audit-agenda-grid" onclick="addAuditAgenda('internalaudit')">+</button>
        </label>
        <table class="table table-bordered" id="internalaudit">
            <thead>
                <tr>
                    <th>Row#</th>
                    <th>Area of Audit</th>
                    <th>Scheduled Start Date</th>
                    <th>Scheduled Start Time</th>
                    <th>Scheduled End Date</th>
                    <th>Scheduled End Time</th>
                    <th>Auditor</th>
                    <th>Auditee</th>
                    <th>Remarks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><input type="text" name="audit[]"></td>
                    <td>
                        <div class="group-input new-date-data-field mb-0">
                            <div class="input-date">
                                <div class="calenderauditee">
                                    <input type="text" class="test" id="scheduled_start_date1" readonly placeholder="DD-MM-YYYY" />
                                    <input type="date" id="scheduled_start_date1_checkdate" name="scheduled_start_date[]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `scheduled_start_date1`);checkDate('scheduled_start_date1_checkdate','scheduled_end_date1_checkdate')" />
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><input type="time" name="scheduled_start_time[]"></td>
                    <td>
                        <div class="group-input new-date-data-field mb-0">
                            <div class="input-date">
                                <div class="calenderauditee">
                                    <input type="text" class="test" id="scheduled_end_date1" readonly placeholder="DD-MM-YYYY" />
                                    <input type="date" id="scheduled_end_date1_checkdate" name="scheduled_end_date[]" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date1`);checkDate('scheduled_start_date1_checkdate','scheduled_end_date1_checkdate')" />
                                </div>
                            </div>
                        </div>
                    </td>
                    <td><input type="time" name="scheduled_end_time[]"></td>
                    <td>
                        <select id="select-state" placeholder="Select..." name="auditor[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select id="select-state" placeholder="Select..." name="auditee[]">
                            <option value="">Select a value</option>
                            @foreach ($users as $data)
                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="text" name="remarks[]"></td>
                    <td><button type="button" class="removeRowBtn">Remove</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Facility Name">Facility Name</label>
                                        <select multiple name="Facility[]" placeholder="Select Facility Name"
                                            data-search="false" data-silent-initial-value-set="true" id="Facility">
                                            <option value="Plant 1">Plant 1</option>
                                            <option value="QA">QA</option>
                                            <option value="QC">QC</option>
                                            <option value="MFG">MFG</option>
                                            <option value="Corporate">Corporate</option>
                                            <option value="Microbiology">Microbiology</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Group Name">Group Name</label>
                                        <select multiple name="Group[]" placeholder="Select Group Name"
                                            data-search="false" data-silent-initial-value-set="true" id="Group">
                                            <option value="QA">QA</option>
                                            <option value="QC">QC</option>
                                            <option value="Manufacturing">Manufacturing</option>
                                            <option value="Warehouse">Warehouse</option>
                                            <option value="RA">RA</option>
                                            <option value="R&D">R&D</option>
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Product/Material Name">Product/Material Name</label>
                                        <input type="text" name="material_name">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments(If Any)">Comments(If Any)</label>
                                        <textarea class="tiny" name="if_comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Preparation content -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Lead Auditor">Lead Auditor</label>
                                        <select name="lead_auditor">
                                            <option value="">-- Select --</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="File Attachments">File Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        {{-- <div class="file-attachment-field">
                                            <div id="file_attachment"></div>
                                            <input type="file" id="myfile" name="file_attachment[]"
                                            oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                        </div> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Audit Team">Audit Team</label>
                                        <select multiple name="Audit_team[]" placeholder="Select Audit Team"
                                            data-search="false" data-silent-initial-value-set="true" id="Audit">
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="Auditee">Auditee</label>
                                        <select multiple name="Auditee[]" placeholder="Select Auditee"
                                            data-search="false" data-silent-initial-value-set="true" id="Auditee">
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supplier Auditor Details">Supplier Auditor Details</label>
                                        <textarea class="tiny" name="Auditor_Details"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supplier Auditing Agency">Supplier Auditing Agency</label>
                                        <textarea class="tiny" name="External_Auditing_Agency"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Relevant Guidelines / Industry Standards">Relevant Guidelines /
                                            Industry Standards</label>
                                        <textarea class="tiny" name="Relevant_Guidelines"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Comments">QA Comments</label>
                                        <textarea class="tiny" name="QA_Comments"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Guideline Attachment">Guideline Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                     

                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment_guideline"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment_guideline[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment_guideline')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Category">Audit Category</label>
                                        <select name="Audit_Category">
                                            <option value="0">-- Select --</option>
                                            <option value="1">Internal Audit/Self Inspection</option>
                                            <option value="2">Supplier Audit</option>
                                            <option value="3">Regulatory Audit</option>
                                            <option value="4">Consultant Audit</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supplier/Vendor/Manufacturer Details">Supplier/Vendor/Manufacturer
                                            Details</label>
                                        <input type="text" name="Supplier_Details">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Supplier/Vendor/Manufacturer Site">Supplier/Vendor/Manufacturer
                                            Site</label>
                                        <input type="text" name="Supplier_Site">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments">Comments</label>
                                        <textarea class="tiny" name="Comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Execution content -->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="audit_start_date Date">Audit Start Date</label>
                                        <div class="calenderauditee">
                                            <input type="text"  id="audit_start_date" readonly
                                                placeholder="DD-MM-YYYY" />
                                            <input type="date" id="audit_start_date_checkdate" name="audit_start_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'audit_start_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <div class="calenderauditee">
                                            <label for="Audit End Date">Audit End Date</label>
                                            <div class="calenderauditee">
                                            <input type="text" id="audit_end_date" readonly
                                                placeholder="DD-MM-YYYY" />
                                            <input type="date" id="audit_end_date_checkdate" name="audit_end_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'audit_end_date');checkDate('audit_start_date_checkdate','audit_end_date_checkdate')" />
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <input type="file" id="file-input" />
                                    <button type="button" onclick="importExcel()">Import Observations</button>
                                </div>
                                <div class="group-input">
                                    <label for="audit-agenda-grid">
                                        Observation Details
                                        <button type="button" name="audit-agenda-grid" id="ObservationAdd">+</button>
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

                                                                                <tr>
                                                                                    <td><input disabled type="text" name="serial[]" value="1"></td>
                                                                                    <td><input type="text" class="divisionCode" name="divisionCode[]"></td>
                                                                                    <td><input type="text" class="siteId" name="siteId[]"></td>
                                                                                    <td><input type="text" class="referenceNo" name="referenceNo[]"></td>
                                                                                    <td><input type="text" class="obsevrationShortDesc" name="obsevrationShortDesc[]"></td>
                                                                                    <td><input type="text" class="observation_detail" name="observation_detail[]"></td>
                                                                                    <td><input type="text" class="observationCategory" name="observationCategory[]"></td>
                                                                                    <td><input type="text" class="observationSubCat" name="observationSubCat[]"></td>
                                                                                    <td><input type="text" class="frequency" name="frequency[]"></td>
                                                                                    <td><input type="text" class="auditingAgency" name="auditingAgency[]"></td>
                                                                                    <td><input type="text" class="audittype" name="audittype[]"></td>
                                                                                    <td><input type="text" class="auditStartDate" name="auditStartDate[]"></td>
                                                                                    <td><input type="text" class="auditEndDate" name="auditEndDate[]"></td>
                                                                                    <td><input type="text" class="auditor" name="auditor[]"></td>
                                                                                    <td><input type="text" class="observation_category" name="observation_category[]"></td>
                                                                                    <td><input type="text" class="observationType" name="observationType[]"></td>
                                                                                    <td><input type="text" class="observationArea" name="observationArea[]"></td>
                                                                                    <td><input type="text" class="observationAreaSubCat" name="observationAreaSubCat[]"></td>
                                                                                    <td><input type="text" class="capaRequired" name="capaRequired[]"></td>
                                                                                    <td><input type="text" class="capaOwner" name="capaOwner[]"></td>
                                                                                    <td><input type="text" class="capaDescription" name="capaDescription[]"></td>
                                                                                    <td><input type="text" class="capaDueDate" name="capaDueDate[]"></td>
                                                                                    <td><input type="text" class="capaSatus" name="capaSatus[]"></td>  
                                                                                    <td><input type="text" class="delayJustification" name="delayJustification[]"></td>
                                                                                    <td><input type="text" class="delayCategory" name="delayCategory[]"></td>
                                                                                    <td><input type="text" class="remarks" name="remarks[]"></td>
                                                                                    <td><input type="text" readonly class="Action" name="Action[]"></td>
                                                                                </tr>                                                 

                                                                            </tbody>

                                                                        </table>
                                                                    </div>
                                                                </div> 
                                                            
                                                            <div class="col-lg-12">
                                                                <div class="group-input">
                                                                    <label for="Audit Attachments">Audit Attachments</label>
                                                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                                                            documents</small></div>
                                                                    <div class="file-attachment-field">
                                                                        <div class="file-attachment-list" id="audit_attachment"></div>
                                                                        <div class="add-btn">
                                                                            <div>Add</div>
                                                                            <input type="file" id="myfile" name="Audit_file[]"
                                                                                oninput="addMultipleFiles(this, 'audit_attachment')" multiple>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="group-input">
                                                                    <label for="Audit Comments">Audit Comments</label>
                                                                    <textarea class="tiny" name="Audit_Comments1"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="button-block">
                                                            <button type="submit" class="saveButton">Save</button>
                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                    Exit </a> </button>
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
                                                                    <textarea class="tiny" name="Remarks"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="group-input">
                                                                    <label for="Reference Recores">Reference Record</label>
                                                                    <select multiple id="reference_record" name="refrence_record[]" id="">
                                                                        {{-- <option value="">--Select---</option> --}}
                                                                        @foreach ($old_record as $new)
                                                                            <option value="{{ $new->id }}">
                                                                                {{ Helpers::getDivisionName($new->division_id) }}/IA/{{ date('Y') }}/{{ Helpers::recordFormat($new->record) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="group-input">
                                                                    <label for="Report Attachments">Report Attachments</label>
                                                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                                                            documents</small></div>
                                                                    {{-- <input type="file" id="myfile" name="report_file[]" multiple> --}}
                                                                    {{-- <div class="file-attachment-field">
                                                                        <div id="Audit_file_attachment"></div>
                                                                        <input type="file" id="myfile" name="report_file[]"
                                                                        oninput="addMultipleFiles(this, 'Audit_file_attachment')" multiple>
                                                                    </div> --}}
                                                                    <div class="file-attachment-field">
                                                                        <div class="file-attachment-list" id="report_attachment"></div>
                                                                        <div class="add-btn">
                                                                            <div>Add</div>
                                                                            <input type="file" id="myfile" name="report_file[]"
                                                                                oninput="addMultipleFiles(this, 'report_attachment')" multiple>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="group-input">
                                                                    <label for="Audit Attachments">Audit Attachments</label>
                                                                    <div><small class="text-primary">Please Attach all relevant or supporting
                                                                            documents</small></div>
                                                                    {{-- <input type="file" id="myfile" name="myfile[]" multiple> --}}
                                                                    {{-- <div class="file-attachment-field">
                                                                        <div id="myfile_attachment"></div>
                                                                        <input type="file" id="myfile" name="myfile[]"
                                                                        oninput="addMultipleFiles(this, 'myfile_attachment')" multiple>
                                                                    </div> --}}
                                                                    <div class="file-attachment-field">
                                                                        <div class="file-attachment-list" id="myfile_attachment"></div>
                                                                        <div class="add-btn">
                                                                            <div>Add</div>
                                                                            <input type="file" id="myfile" name="myfile[]"
                                                                                oninput="addMultipleFiles(this, 'myfile_attachment')" multiple>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="group-input">
                                                                    <label for="Audit Comments">Audit Comments</label>
                                                                    <textarea class="tiny" name="Audit_Comments2"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="group-input">
                                                                    <label for="due_date_extension">Due Date Extension Justification</label>
                                                                    <div><small class="text-primary">Please Mention justification if due date is
                                                                            crossed</small></div>
                                                                    <textarea class="tiny" name="due_date_extension"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="button-block">
                                                            <button type="submit" class="saveButton">Save</button>
                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                            <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                    Exit </a> </button>
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
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Schedule On">Schedule Audit On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                        <div class="group-input">
                                                                            <label for="Audit Schedule On">Comment</label>
                                                                            <div class="static"></div>
                                                                        </div>
                                                                    </div>
                                                            
                                                                    <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Preparation Completed On"> Completed Audit Preparation
                                                                        By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Preparation Completed On">Completed Audit Preparation 
                                                                        On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                        <div class="group-input">
                                                                            <label for="Audit Schedule On">Comment</label>
                                                                            <div class="static"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Mgr.more Info Reqd By">Reject By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Mgr.more Info Reqd On"> Reject On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                        <div class="group-input">
                                                                            <label for="Audit Schedule On">Comment</label>
                                                                            <div class="static"></div>
                                                                        </div>
                                                                    </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Cancelled By">Cancelled By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Cancelled On">Cancelled On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                        <div class="group-input">
                                                                            <label for="Audit Schedule On">Comment</label>
                                                                            <div class="static"></div>
                                                                        </div>
                                                                    </div>
                                                            
                                                            
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Observation Submitted By">Issue  Report By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Observation Submitted On">Issue Report On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Observation Submitted By">Comment</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Lead More Info Reqd By">CAPA Plan Proposed By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Lead More Info Reqd On">CAPA Plan Proposed On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                        <div class="group-input">
                                                                            <label for="Audit Schedule On">Comment</label>
                                                                            <div class="static"></div>
                                                                        </div>
                                                                    </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Lead More Info Reqd By">No CAPA Required By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="group-input">
                                                                    <label for="Audit Lead More Info Reqd On">No CAPA Required On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                        <div class="group-input">
                                                                            <label for="Audit Schedule On">Comment</label>
                                                                            <div class="static"></div>
                                                                        </div>
                                                                    </div>
                                                            <!-- <div class="col-lg-6">
                                                                <div class="group-input">
                                                                    <label for="Audit Response Completed By">All CAPA Closed By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="group-input">
                                                                    <label for="Audit Response Completed On">Audit Response Completed On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="group-input">
                                                                    <label for="Response Feedback Verified By">Response Feedback Verified
                                                                        By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="group-input">
                                                                    <label for="Response Feedback Verified On">Response Feedback Verified
                                                                        On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="group-input">
                                                                    <label for=" Rejected By">Rejected By</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="group-input">
                                                                    <label for="Rejected On">Rejected On</label>
                                                                    <div class="static"></div>
                                                                </div>
                                                            </div> -->

                                                        </div>
                                                        <div class="button-block">
                                                            <!-- <button type="submit" class="saveButton">Save</button> -->
                                                            <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                                            <!-- <button type="submit">Submit</button> -->
                                                            <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                                                    Exit </a> </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </form>

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
    <script>
        document.getElementById('myfile').addEventListener('change', function() {
            var fileListDiv = document.querySelector('.file-list');
            fileListDiv.innerHTML = ''; // Clear previous entries

            for (var i = 0; i < this.files.length; i++) {
                var file = this.files[i];
                var listItem = document.createElement('div');
                listItem.textContent = file.name;
                fileListDiv.appendChild(listItem);
            }
        });
    </script>


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
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record'
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
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('type_of_audit').addEventListener('change', function() {
        //         var typeOfAuditReqInput = document.getElementById('type_of_audit_req');
        //         if (typeOfAuditReqInput) {
        //             var selectedValue = this.value;
        //             if (selectedValue == 'others') {
        //                 typeOfAuditReqInput.setAttribute('required', 'required');
        //             } else {
        //                 typeOfAuditReqInput.removeAttribute('required');
        //             }
        //         } else {
        //             console.error("Element with id 'type_of_audit_req' not found");
        //         }
        //     });
        // });
    </script>
    <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>
     <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);});
    </script>
    <!-- Add the following script at the end of your HTML -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const supplierAgencies = document.getElementById('supplier_agencies');
        const othersGroup = document.getElementById('external_agencies_req');
        const othersField = document.getElementById('others');
        const othersLabel = othersField.previousElementSibling;

        function toggleOthersField(value) {
            if (value === 'others') {
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
        toggleOthersField(supplierAgencies.value);

        // Add event listener
        supplierAgencies.addEventListener('change', function() {
            toggleOthersField(this.value);
        });
    });
</script>

<!-- Ensure this CSS is present to initially hide the Others field and its group -->
<style>
    #external_agencies_req {
        display: none;
    }
</style>
@endsection
