@extends('frontend.layout.main')
@section('container')
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>

    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / Effectiveness-Check
        </div>

    </div>
    @php
        $users = DB::table('users')->get();
    @endphp



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}
    <div id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm2')">Acknowledge</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Effectiveness check Results</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm4')">HOD Review</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">QA/CQA  Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">QA/CQA  Approval Effective</button>
                 <button class="cctablinks" onclick="openCity(event, 'CCForm7')">Activity Log</button> 
            </div>

            <form action="{{ route('effectiveness.store') }}" method="post" , enctype="multipart/form-data">
                @csrf

                @if(!empty($parent_id))
                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                    <input type="hidden" name="parent_record" value="{{ $parent_record }}">
                @else 
                    
                @endif
                <div id="step-form">
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="sub-head">
                                General Information
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input type="hidden" name="record_number" value="{{ Helpers::getDivisionName(session()->get('division')) }}/EC/{{ date('Y') }}/{{ $record_number }}">
                                        <input disabled type="text" value="{{ Helpers::getDivisionName(session()->get('division')) }}/EC/{{ date('Y') }}/{{ $record_number }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Division Code</b></label>
                                        <input disabled type="text" name="division_id" id="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        {{-- <div class="static">{{ Helpers::getDivisionName(session()->get('division')) }}</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" name="initiator_id"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                        {{-- <div class="static">{{ date('d-M-Y') }}</div> --}}
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
                                                <option value="{{ $data->name }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="due-date">Due Date </label>
                                        <div class="calenderauditee">
                                            <!-- Display the formatted date in a readonly input -->
                                            <input type="text" id="due_date_display" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getDueDate(30, true) }}" />
                                           
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ Helpers::getDueDate(30, false) }}" class="hide-input" readonly />
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    function handleDateInput(dateInput, displayId) {
                                        const date = new Date(dateInput.value);
                                        const options = { day: '2-digit', month: 'short', year: 'numeric' };
                                        document.getElementById(displayId).value = date.toLocaleDateString('en-GB', options).replace(/ /g, '-');
                                    }
                                    
                                    // Call this function initially to ensure the correct format is shown on page load
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const dateInput = document.querySelector('input[name="due_date"]');
                                        handleDateInput(dateInput, 'due_date_display');
                                    });
                                </script>

                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Quality Reviewer"><b>Quality Reviewer</b></label>
                                        <select id="select-state" placeholder="Select..." name="Quality_Reviewer">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
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
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Original Date Due"><b>Original Date Due</b></label>
                                        <div class="static">17-04-2023 11:12PM</div>
                                    </div>
                                </div> --}}
                            </div>
                            <div class="sub-head">
                                Effectiveness Planning Information
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Effectiveness check Plan"><b>Effectiveness check Plan</b></label>
                                        <input type="text" name="Effectiveness_check_Plan">
                                    </div>
                                </div>
                            </div>
                            <div class="group-input">
                                        <label for="Attachments">Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Attachments"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Attachments[]"
                                                    oninput="addMultipleFiles(this, 'Attachments')" multiple>
                                            </div>
                                        </div>

                                    </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a class="text-white"> Exit </a> </button>
                            </div>
                        </div>

                    </div>

                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <!-- Effectiveness check Results -->
                                
                               <div class="sub-head">
                                Acknowledge
                               </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness Results">Acknowledge Comment</label>
                                        <textarea type="text" id="acknowledge_comment" name="acknowledge_comment"></textarea>
                                    </div>
                                </div>
                              
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness check Attachments">Acknowledge Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="acknowledge_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="acknowledge_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'acknowledge_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                               
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <!-- Effectiveness check Results -->
                                
                                <div class="col-12 sub-head">
                                    Effectiveness Check Results
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness Results">Effectiveness Results</label>
                                        <textarea type="text" name="Effectiveness_Results"></textarea>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Effectiveness check Attachments"><b>Effectiveness check
                                                Attachment</b></label>
                                        <input type="file" id="myfile" name="Effectiveness_check_Attachment">
                                    </div>
                                </div> -->
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness check Attachments">Effectiveness check Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Effectiveness_check_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Effectiveness_check_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Effectiveness_check_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 sub-head">
                                    Effectiveness Summary
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Effectiveness Summary">Effectiveness Summary</label>
                                        <textarea type="text" name="effect_summary"></textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-12 sub-head">
                                    Reopen
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Addendum Comments"><b>Addendum Comments</b></label>
                                        <textarea type="text" name="Addendum_Comments"></textarea>
                                    </div>
                                </div> --}}
                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Addendum Attachments"><b>Addendum Attachment</b></label>
                                        <input type="file" id="myfile" name="Addendum_Attachment">
                                    </div>
                                </div> -->
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Addendum Attachments">Addendum Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Addendum_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Addendum_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Addendum_Attachment')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"> Exit </a> </button>
                            </div>
                        </div> 
                    </div>
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <!-- Reference Info comments -->
                                <div class="col-12 sub-head">
                                    HOD  comments
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments"><b> HOD Comments</b></label>
                                        <textarea name="Comments"></textarea>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Attachments"><b>Attachment</b></label>
                                        <input type="file" id="myfile" name="Attachment">
                                    </div>
                                </div> -->
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Attachments">HOD  Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Attachment[]"
                                                    oninput="addMultipleFiles(this, 'Attachment')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Reference Records"><b>Reference Records</b></label>
                                          <div class="static"></div>  
                                        <input type="file" id="myfile" name="refer_record">
                                    </div>
                                </div> -->
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Reference Records">Reference Records</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="refer_record"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="refer_record[]"
                                                    oninput="addMultipleFiles(this, 'refer_record')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <!-- Effectiveness check Results -->
                                <div class="sub-head">
                                    QA/CQA Review
                                </div>
                               
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness Results">QA/CQA Review Comment</label>
                                        <textarea type="text" name="qa_cqa_review_comment"></textarea>
                                    </div>
                                </div>
                              
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness check Attachments">QA/CQA Review Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="qa_cqa_review_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="qa_cqa_review_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'qa_cqa_review_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                               
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <!-- Effectiveness check Results -->
                                
                               <div class="sub-head">
                                QA/CQA Approval
                               </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness Results">QA/CQA Approval Comment</label>
                                        <textarea type="text" name="qa_cqa_approval_comment"></textarea>
                                    </div>
                                </div>
                              
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Effectiveness check Attachments">QA/CQA Approval Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="qa_cqa_approval_Attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="qa_cqa_approval_Attachment[]"
                                                    oninput="addMultipleFiles(this, 'qa_cqa_approval_Attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                               
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row"> 
                                <!-- Activity History -->
                                 <!-- <div class="col-12 sub-head">
                                    Data History
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Actual Closure Date"><b>Actual Closure Date</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Original Date Due"><b>Original Date Due</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>  -->
                                <div class="col-12 sub-head">
                                    Record Signature
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Submit by"><b>Submit by</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Submit On"><b>Submit On</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Not Effective By"><b>Not Effective By</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Not Effective On"><b>Not Effective On</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Effective by"><b>Effective by</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Effective On"><b>Effective On</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Not Effective Approval Complete By"><b>Not Effective Approval Complete By</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Not Effective Approval Complete On"><b>Not Effective Approval Complete On</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Effective Approval Complete By"><b>Effective Approval Complete By</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Effective Approval Complete On"><b>Effective Approval Complete On</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Re Open For Addendum By"><b>Re Open For Addendum By</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Re Open For Addendum On"><b>Re Open For Addendum On</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancellation Approve By"><b>Cancellation Approve By</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancellation Approve On"><b>Cancellation Approve On</b></label>
                                        <div class="static"></div>
                                    </div>
                                </div> -->
                                <!-- <div class="col-12 sub-head">
                                    Cancellation Details
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancellation Category"><b>Cancellation Category</b></label>
                                        <select>
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="Duplicate Entry">Duplicate Entry</option>
                                            <option value="Entered in Error">Entered in Error</option>
                                            <option value="No Longer Necessary">No Longer Necessary</option>
                                            <option value="Parent Record Closed">Parent Record Closed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="TrackWise Record Type"><b>TrackWise Record Type</b></label>
                                        <select>
                                            <option >Enter Your Selection Here</option>
                                            <option value="Effectiveness Check">Effectiveness Check</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Cancellation Justification">Cancellation Justification</label>
                                        <textarea name="cancel_justification"></textarea>
                                    </div>
                                </div>
                            </div>  -->
                             <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                <button type="button" class="backButton" onclick="previousStep()">Back</button>
                                <button type="submit">Submit</button>
                                <button type="button"> <a class="text-white" href="#"> Exit </a> </button>
                            </div> 
                        </div>
                    </div>
                </div>
            </form>

            <!-- General Information -->



        </div>
    </div>


    <script>
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
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);});
    </script>
@endsection
