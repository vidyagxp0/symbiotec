@extends('frontend.rcms.layout.main_rcms')
@section('rcms_container')
    <style>
        header .header_rcms_bottom {
            display: none;
        }

        .calenderauditee {
            position: relative;
        }

        .new-date-data-field .input-date input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
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
        $(document).ready(function() {
            let docIndex = 1;
            $('#documentAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        ' <td><input type="text" name="documentDetails[' + docIndex +
                        '][currentDocNumber]"></td>' +
                        ' <td><input type="text"name="documentDetails[' + docIndex +
                        '][currentVersionNumber]"></td>' +
                        '<td><input type="text" name="documentDetails[' + docIndex +
                        '][newDocNumber]"></td>' +
                        '<td><input type="text" name="documentDetails[' + docIndex +
                        '][newVersionNumber\]"></td>' +
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                        '</tr>';
                    '</tr>';

                    docIndex++;
                    return html;
                }
                var tableBody = $('#documentTableDetails tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            let affectedDocIndex = 1;
            $('#affectedDocAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                        '"></td>' +
                        ' <td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][afftectedDoc]"></td>' +
                        ' <td><input type="text"name="affectedDocuments[' + affectedDocIndex +
                        '][documentName]"></td>' +
                        '<td><input type="number" name="affectedDocuments[' + affectedDocIndex +
                        '][documentNumber]"></td>' +
                        '<td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][versionNumber]"></td>' +
                        ' <td><input type="date"name="affectedDocuments[' + affectedDocIndex +
                        '][implimentationDate]"></td>' +
                        '<td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][newDocumentNumber]"></td>' +
                        '<td><input type="text" name="affectedDocuments[' + affectedDocIndex +
                        '][newVersionNumber]"></td>' +
                        '<td><button type="text" class="removeRowBtn">Remove</button></td>' +
                        '</tr>';
                    '</tr>';

                    docIndex++;
                    return html;
                }
                var tableBody = $('#affectedDocAddTable tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

    <div id="rcms_form-head">
        <div class="container-fluid">
            <div class="inner-block">


                <div class="slogan">
                    <strong>Site Division / Project </strong>:
                    {{ Helpers::getDivisionName(session()->get('division')) }} / Evaluation
                </div>
            </div>
        </div>
    </div>
    @php
        $users = DB::table('users')->get();
    @endphp
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">Evaluation Detail</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Approver Detail</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">Reviewer Detail</button>
                <!-- <button class="cctablinks" onclick="openCity(event, 'CCForm5')">Activity Log</button> -->
            </div>
            <form action="{{ route('evaluation-store') }}" method="POST" enctype="multipart/form-data" id="myForm">
                @csrf
                <!-- Tab content -->
                <div id="step-form">

                    @if (!empty($parent_id))
                        <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                        <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    @endif

                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" placeholder="{{ Helpers::getDivisionName(session()->get('division')) }}/Evaluation/{{ date('Y') }}/{{ str_pad($record_number, 4, '0', STR_PAD_LEFT) }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Function Code</b></label>
                                        <input disabled type="text" name="division_id"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>

                                @php
                                    $initiationDate = date('Y-m-d');
                                    $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days'));
                                @endphp

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input disabled type="text" name="initiator_id"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="initiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date">
                                    </div>
                                </div>

                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Date Due</label>
                                        <div><small class="text-primary">Please mention expected date of completion</small></div>
                                        <div class="calenderauditee">
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly placeholder="DD-MM-YYYY" />
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('d-M-Y') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                        </div>
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

                                    // Formatting the date in "dd-MMM-yyyy" format
                                    var dueDateFormatted = `${day}-${monthNames[monthIndex]}-${year}`;

                                    // Set the formatted due date value to the input field
                                    document.getElementById('due_date').value = dueDateFormatted;
                                </script>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars"
                                            class="text-primary">255 </span><span class="text-primary"> characters
                                            remaining</span>

                                        <input id="docname" type="text" name="short_description" maxlength="255"
                                            required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Description">Description<span class="text-danger">*</span></label><span
                                            id="rchars" class="text-primary">255 </span><span class="text-primary">
                                            characters
                                            remaining</span>

                                        <input id="docname" type="text" name="description" maxlength="255" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Reference Document</label>
                                        <select name="reference_document" id="reference_document">
                                            <option value="">Select Document</option> 
                                            @if (!empty($document))
                                                @foreach ($document as $doc)
                                                    <option value="{{ $doc->id }}">{{ $doc->document_number }}/ {{ $doc->document_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Document No.</b></label>
                                        <input disabled type="text" name="site" id="site" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Department Name</b></label>
                                        <input disabled type="text" name="department_name" id="department_name" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Document Name</b></label>
                                        <input disabled type="text" name="sop_title" id="sop_title" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Document Review Date</b></label>
                                        <input disabled type="text" name="sop_review_date" id="sop_review_date" readonly>  
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Initial attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="initial_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="initial_attachment[]"
                                                    oninput="addMultipleFiles(this, 'initial_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Reviewer</label>
                                        <select name="reviewer">
                                            <option value="">Select Reviewer</option>
                                            @if (!empty($users))
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Approver</label>
                                        <select name="approver">
                                            <option value="">Select Approver</option>
                                            @if (!empty($users))
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initated By</b></label>
                                        <input disabled type="text" name="initiated_by" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiated On</b></label>
                                        <input disabled type="text" name="initiated_on">
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>



                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">
                                    Checklist for Tablet Dispensing
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <div class="why-why-chart">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%;">Sr. No.</th>
                                                        <th style="width: 30%;">Evaluation Points</th>
                                                        <th>Check Box</th>
                                                        <th style="width: 20%;">Initiator Remark</th>
                                                        <th style="width: 20%;">Reviewer Remark</th>
                                                        <th style="width: 20%;">Approver Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="flex text-center">1.1</td>
                                                        <td>Is the SOP and formats is in line with the SOP on SOP (CQA-001)</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_1" value="" id="checkbox_1">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_1" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.2</td>
                                                        <td>Does any improvement is required w.r.t. system/procedure upgradation?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_2" value="" id="checkbox_2">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_2" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.3</td>
                                                        <td>Is SOP defined in instructive and chronologically order?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_3" value="" id="checkbox_3">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_3" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_3" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_3" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.4</td>
                                                        <td>Does any gramatical/spelling/typo error and sentence formation error througout SOP?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_4" value="" id="checkbox_4">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_4" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_4" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_4" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.5</td>
                                                        <td>Is reference SOP mentioned in SOP is in sxistence?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_5" value="" id="checkbox_5">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_5" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_5" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_5" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.6</td>
                                                        <td>Is SOP due to any Compliance / CAPA review?></td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_6" value="" id="checkbox_6">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_6" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_6" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_6" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.7</td>
                                                        <td>Is there any recommendation /suggestions from any internal/external auditor/agency?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_7" value="" id="checkbox_7">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_7" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_7" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_7" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="flex text-center">1.8</td>
                                                        <td>Is there any legal/safety requirement for change/incorporate/elaboratein SOP?</td>
                                                        <td>
                                                            <div
                                                                style="display: flex; justify-content: space-around; align-items: center;  margin: 5%; gap:5px">
                                                                <input type="checkbox" name="checkbox_8" value="" id="checkbox_8">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="initiatorRemark_8" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="reviewerRemark_8" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div style="margin: auto; display: flex; justify-content: center;">
                                                                <textarea name="approverRemark_8" style="border-radius: 7px; border: 1.5px solid black;"></textarea>
                                                            </div>
                                                        </td>
                                                    </tr>
                    
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="group-input">
                                    <label for="Description Deviation">Evaluation Comments</label>
                                    <textarea class="summernote" name="Description_Deviation[]" id="summernote-1"></textarea>
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

                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                            <div class="col-md-12 mb-4">
                                <div class="group-input">
                                    <label for="Description Deviation">Approval Feedback</label>
                                    <textarea class="summernote" name="approver_feedback" id="approver_feedback"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="group-input">
                                    <label for="Description Deviation">Approver Comments</label>
                                    <textarea class="summernote" name="approver_comment" id="approver_comment"></textarea>
                                </div>
                            </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Approver attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="approver_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="approver_attachment[]"
                                                    oninput="addMultipleFiles(this, 'approver_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Approved By</b></label>
                                        <input disabled type="text" name="approved_by">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Approved On</b></label>
                                        <input disabled type="text" name="approved_on">
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">

                            <div class="col-md-12 mb-4">
                                <div class="group-input">
                                    <label for="Description Deviation">Reviewer Feedback</label>
                                    <textarea class="summernote" name="reviewer_feedback" id="reviewer_feedback"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="group-input">
                                    <label for="Description Deviation">Reviewer Comments</label>
                                    <textarea class="summernote" name="reviewer_comment" id="reviewer_comment"></textarea>
                                </div>
                            </div>

                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="others">Reviewer attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="reviewer_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="reviewer_attachment[]"
                                                    oninput="addMultipleFiles(this, 'reviewer_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Reviewer By</b></label>
                                        <input disabled type="text" name="reviewed_by">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Reviewer On</b></label>
                                        <input disabled type="text" name="reviewed_on">
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"
                                        href="{{ url('rcms/qms-dashboard') }}">Exit</a> </button>
                            </div>
                        </div>
                    </div>

                    
                </div>
        </div>
    </div>
    </form>

    </div>
    </div>

    <div class="modal fade" id="change-control-type-of-change-instruction-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Instructions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h4>1. Major Change:</h4>
                    <ul>
                        <li>A major change is usually a significant alteration that may have a substantial impact on the
                            product.</li>

                        <li>It might involve modifications to the manufacturing process, formulation, equipment, or other
                            critical aspects of production.</li>

                        <li>Major changes often require thorough assessment, validation, and regulatory approval before
                            implementation.</li>
                    </ul>


                    <h4>2. Minor Change:</h4>
                    <ul>

                        <li>A minor change is typically a less significant alteration, one that is unlikely to have a
                            substantial impact on product quality, safety, or efficacy.</li>

                        <li>Minor changes may include adjustments to documentation, labeling, or other non-critical aspects
                            that don't significantly affect the product's characteristics.</li>

                        <li>These changes may still require some level of evaluation and documentation but may not
                            necessitate the same level of scrutiny as major changes.</li>
                    </ul>


                    <h4>3. Critical Change:</h4>
                    <ul>

                        <li>A critical change is one that has the potential to significantly impact product quality, safety,
                            or efficacy and may require immediate attention.</li>

                        <li>These changes are often associated with unexpected events or deviations that need prompt
                            resolution to maintain product integrity.</li>

                        <li>Critical changes may require urgent assessment, corrective actions, and regulatory reporting.
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>


    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myForm').submit(function(event) {
                $('input[type="checkbox"]').each(function() {
                    $(this).attr('value', $(this).is(':checked') ? 'yes' : 'no');
                    // Ensure the checkbox is not unchecked so that its value is sent in the form
                    $(this).prop('checked', true);
                });
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reference_document').change(function() {
                var recordId = $(this).val();
                if (recordId) {
                    $.ajax({
                        url: '/get-doc-detail/' + recordId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            console.log(data);
                            $('#site').val(data.document_number);
                            $('#department_name').val(data.department_id);
                            $('#sop_title').val(data.document_name);
                            $('#sop_review_date').val(data.next_review_date);
                        },
                        error: function() {
                            alert('Error retrieving record details');
                        }
                    });
                } else {
                    $('#site').val('');
                    $('#department_name').val('');
                    $('#sop_title').val('');
                    $('#sop_review_date').val('');
                }
            });
        });
    </script>


    <style>
        #step-form>div {
            display: none;
        }

        #step-form>div:nth-child(1) {
            display: block;
        }

        #productTable,
        #materialTable {
            display: none;
        }
    </style>

    <script>
        const productSelect = document.getElementById('productSelect');
        const productTable = document.getElementById('productTable');
        const materialSelect = document.getElementById('materialSelect');
        const materialTable = document.getElementById('materialTable');

        materialSelect.addEventListener('change', function() {
            if (materialSelect.value === 'yes') {
                materialTable.style.display = 'block';
            } else {
                materialTable.style.display = 'none';
            }
        });

        productSelect.addEventListener('change', function() {
            if (productSelect.value === 'yes') {
                productTable.style.display = 'block';
            } else {
                productTable.style.display = 'none';
            }
        });
    </script>

    <script>
        VirtualSelect.init({
            ele: '#related_records, #cft_reviewer, #risk_assessment_related_record'
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
        function calculateRiskAnalysis(selectElement) {
            // Get the row containing the changed select element
            let row = selectElement.closest('tr');

            // Get values from select elements within the row
            let R = parseFloat(document.getElementById('analysisR').value) || 0;
            let P = parseFloat(document.getElementById('analysisP').value) || 0;
            let N = parseFloat(document.getElementById('analysisN').value) || 0;

            // Perform the calculation
            let result = R * P * N;

            // Update the result field within the row
            document.getElementById('analysisRPN').value = result;
        }
    </script>
    {{-- var riskData = @json($riskData); --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
            var dateToday = new Date();
            var month = dateToday.getMonth() + 1;
            var day = dateToday.getDate();
            var year = dateToday.getFullYear();

            if (month < 10)
                month = '0' + month.toString();
            if (day < 10)
                day = '0' + day.toString();

            var maxDate = year + '-' + month + '-' + day;

            $('#dueDate').attr('min', maxDate);
        });
    </script>

    <script>
        $(document).ready(function() {
            var aiText = $('.ai_text');


            console.log(riskData);
            $('#short_description').on('input', function() {
                var description = $(this).val().toLowerCase();
                var riskLevelSelectize = $('#risk_level')[0].selectize;
                // var aiText = $('#ai_text');

                var foundRiskLevel = false;
                for (var i = 0; i < riskData.length; i++) {
                    if (description.includes(riskData[i].keyword.toLowerCase())) {
                        riskLevelSelectize.setValue(riskData[i].risk_level, true);
                        aiText.show();
                        foundRiskLevel = true;
                        console.log(riskData[i].keyword);
                        break;
                    }
                }
                if (!foundRiskLevel) {
                    riskLevelSelectize.setValue('0', true);
                    aiText.hide();
                }
            });

            $('#risk_level').on('change', function() {
                if ($(this).val() !== '0') {
                    aiText.hide();
                }
            });
        });
    </script>
    <script>
        // JavaScript
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>

    <style>
        .swal2-container.swal2-center.swal2-backdrop-show .swal2-icon.swal2-error.swal2-icon-show,
        .swal2-container.swal2-center.swal2-backdrop-show .selectize-control.swal2-select.single {
            display: none !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show #swal2-title {
            text-align: center;
            font-size: 1.5rem !important;
        }

        .swal2-container.swal2-center.swal2-backdrop-show .swal2-html-container.my-html-class {
            text-transform: capitalize !important;
        }
    </style>
    <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);
        });
    </script>
    <script>
        $(document).ready(function() {
            // Event listener for the remove file button
            $(document).on('click', '.remove-file', function() {
                $(this).closest('.file-container').remove();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-file');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileName = this.getAttribute('data-file-name');
                    const fileContainer = this.parentElement;

                    // Hide the file container
                    if (fileContainer) {
                        fileContainer.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
