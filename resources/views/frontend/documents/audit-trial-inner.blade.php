@extends('frontend.layout.main')
@section('container')
<style>
 

    .diff-wrapper.diff {
        --tab-size: 4;
        background: repeating-linear-gradient(-45deg, whitesmoke, whitesmoke 0.5em, #e8e8e8 0.5em, #e8e8e8 1em);
        border-collapse: collapse;
        border-spacing: 0;
        border: 1px solid black;
        color: black;
        empty-cells: show;
        font-family: monospace;
        font-size: 13px;
        width: 100%;
        word-break: break-all;
    }
    .diff-wrapper.diff th {
        font-weight: 700;
        cursor: default;
        -webkit-user-select: none;
        user-select: none;
    }
    .diff-wrapper.diff td {
        vertical-align: baseline;
    }
    .diff-wrapper.diff td,
    .diff-wrapper.diff th {
        border-collapse: separate;
        border: none;
        padding: 1px 2px;
        background: #fff;
    }
    .diff-wrapper.diff td:empty:after,
    .diff-wrapper.diff th:empty:after {
        content: " ";
        visibility: hidden;
    }
    .diff-wrapper.diff td a,
    .diff-wrapper.diff th a {
        color: #000;
        cursor: inherit;
        pointer-events: none;
    }
    .diff-wrapper.diff thead th {
        background: #a6a6a6;
        border-bottom: 1px solid black;
        padding: 4px;
        text-align: left;
    }
    .diff-wrapper.diff tbody.skipped {
        border-top: 1px solid black;
    }
    .diff-wrapper.diff tbody.skipped td,
    .diff-wrapper.diff tbody.skipped th {
        display: none;
    }
    .diff-wrapper.diff tbody th {
        background: #cccccc;
        border-right: 1px solid black;
        text-align: right;
        vertical-align: top;
        width: 4em;
    }
    .diff-wrapper.diff tbody th.sign {
        background: #fff;
        border-right: none;
        padding: 1px 0;
        text-align: center;
        width: 1em;
    }
    .diff-wrapper.diff tbody th.sign.del {
        background: #fbe1e1;
    }
    .diff-wrapper.diff tbody th.sign.ins {
        background: #e1fbe1;
    }
    .diff-wrapper.diff.diff-html {
    white-space: pre-wrap;
    tab-size: var(--tab-size);
    }
    .diff-wrapper.diff.diff-html .ch {
        line-height: 1em;
        background-clip: border-box;
        background-repeat: repeat-x;
        background-position: left center;
    }
    .diff-wrapper.diff.diff-html .ch.sp {
        background-image: url('data:image/svg+xml,%3Csvg preserveAspectRatio="xMinYMid meet" viewBox="0 0 12 24" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M4.5 11C4.5 10.1716 5.17157 9.5 6 9.5C6.82843 9.5 7.5 10.1716 7.5 11C7.5 11.8284 6.82843 12.5 6 12.5C5.17157 12.5 4.5 11.8284 4.5 11Z" fill="rgba%2860, 60, 60, 50%25%29"/%3E%3C/svg%3E');
        background-size: 1ch 1.25em;
    }
    .diff-wrapper.diff.diff-html .ch.tab {
        background-image: url('data:image/svg+xml,%3Csvg preserveAspectRatio="xMinYMid meet" viewBox="0 0 12 24" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M9.5 10.44L6.62 8.12L7.32 7.26L12.04 11V11.44L7.28 14.9L6.62 13.9L9.48 11.78H0V10.44H9.5Z" fill="rgba%2860, 60, 60, 50%25%29"/%3E%3C/svg%3E');
        background-size: calc(var(--tab-size) * 1ch) 1.25em;
        background-position: 2px center;
    }
    .diff-wrapper.diff.diff-html .change.change-eq .old,
    .diff-wrapper.diff.diff-html .change.change-eq .new {
        background: #fff;
    }
    .diff-wrapper.diff.diff-html .change .old {
        background: #fbe1e1;
    }
    .diff-wrapper.diff.diff-html .change .new {
        background: #e1fbe1;
    }
    .diff-wrapper.diff.diff-html .change .rep {
        background: #fef6d9;
    }
    .diff-wrapper.diff.diff-html .change .old.none,
    .diff-wrapper.diff.diff-html .change .new.none,
    .diff-wrapper.diff.diff-html .change .rep.none {
        background: transparent;
        cursor: not-allowed;
    }
    .diff-wrapper.diff.diff-html .change ins,
    .diff-wrapper.diff.diff-html .change del {
        font-weight: bold;
        text-decoration: none;
    }
    .diff-wrapper.diff.diff-html .change ins {
        background: #94f094;
    }
    .diff-wrapper.diff.diff-html .change del {
        background: #f09494;
    }

</style>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.7.2/axios.min.js" integrity="sha512-JSCFHhKDilTRRXe9ak/FJ28dcpOJxzQaCd3Xg8MyF6XFjODhy/YMCM8HW0TFDckNHWUewW+kfvhin43hKtJxAw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <div id="audit-inner">
        <div class="container-fluid">
            <div class="audit-inner-container">

                <div class="row mb-4">

                    <div class="col-lg-12">
                        <div class="inner-block">
                            <div class="main-head">
                                SOP - {{ $detail->document_id }}
                            </div>
                            <div class="info-list">
                                <div class="list-item">
                                    <div class="head">Site/Division/Process</div>
                                    <div>:</div>
                                    <div>{{ $doc->division }}/{{ $doc->process }}</div>
                                </div>
                                <div class="list-item">
                                    <div class="head">Document Stage</div>
                                    <div>:</div>
                                    <div>{{ $doc->status }}</div>
                                </div>
                                <div class="list-item">
                                    <div class="head">Originator</div>
                                    <div>:</div>
                                    <div>{{ $doc->origiator_name->name }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                @foreach($detail_data->sortBy('id') as $temp)
                    <div class="inner-block audit-main">
                        <div class="info-list">
                            <div class="list-item">
                                <div class="head">Modified By</div>
                                <div>:</div>
                                <div>{{ $temp->user_name }}</div>
                            </div>
                            {{-- <div class="list-item">
                                <div class="head">Modifier role</div>
                                <div>:</div>
                                <div>{{ $temp->user_role }}</div>
                            </div> --}}
                            <div class="list-item">
                                <div class="head">Modified On</div>
                                <div>:</div>
                                <div>{{ $temp->created_at }}</div>
                            </div>
                            @if($temp->comment)
                            <div class="list-item">
                                <div class="head">Comment</div>
                                <div>:</div>
                                <div>{{ $temp->comment }}</div>
                            </div>
                            @endif

                            @if($temp->activity_type == "Responsibility" ||$temp->activity_type == "Abbreviation" ||$temp->activity_type == "Defination" ||$temp->activity_type == "Materials and Equipments" ||$temp->activity_type == "Reporting" )
                            @if(!empty($temp->previous))
                            <div class="list-item">
                                <div class="head">Changed From</div>
                                <div>:</div>
                                @foreach (unserialize($temp->previous) as $data)
                                @if($data)
                                <div>{{ $data }}</div>
                                @else
                                <div>NULL</div>
                                @endif
                                @endforeach

                            </div>
                            @else
                            <div class="list-item">
                                <div class="head">Changed From</div>
                                <div>:</div>
                                <div>NULL</div>
                            </div>
                            @endif
                            @if($temp->current != $temp->previous)
                            <div class="list-item">
                                <div class="head">Changed To</div>
                                <div>:</div>
                                @foreach (unserialize($temp->current) as $data)
                                <div>{{ $data }}</div>
                                @endforeach

                            </div>
                            @endif
                            @else
                            @if(!empty($temp->previous))
                            <div class="list-item">
                                <div class="head">Changed From</div>
                                <div>:</div>
                                <div>{{ $temp->previous }}</div>
                            </div>
                            @else
                            <div class="list-item">
                                <div class="head">Changed From</div>
                                <div>:</div>
                                <div>NULL</div>
                            </div>
                            @endif
                            @if($temp->current != $temp->previous)
                            <div class="list-item">
                                <div class="head">Changed To</div>
                                <div>:</div>
                                <div>{{ $temp->current }}</div>
                            </div>
                            @endif
                            @endif

                            <div class="list-item">
                                <div class="head">Origin state</div>
                                <div>:</div>
                                <div>{{ $temp->origin_state }}</div>
                            </div>
                        </div>


                        <div class="p-4">
                            <p>Track Change:</p>
                            {!! Helpers::compareValues2($temp->previous, $temp->current) !!}
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
