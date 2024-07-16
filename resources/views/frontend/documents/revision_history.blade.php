@extends('frontend.layout.main')
@section('container')
    {{-- ======================================
                    DASHBOARD
    ======================================= --}}
    <div id="audit-trial">
        <div class="container-fluid">
            <div class="audit-trial-container">

                <div class="inner-block">
                    <div class="main-head">
                        <div class="default-name">
                            {{ Helpers::getDivisionName($document->division_id) }}
                                        /{{ $document->document_type_id }} /{{ $document->created_at->format('Y') }}
                                        /000{{ $document->id }}/R{{$document->major}}.{{$document->minor}}
                            
                            {{-- {{ $document->division }}
                            /{{ $document->doctype }} /{{ date('Y') }}
                            /SOP-000{{ $document->id }} --}}
                        </div>

                        <div class="btn-group">
                            <button class="button_theme1" onclick="window.print();return false;" type="button">Print</button>
                        </div>
                    </div>
                    <div class="info-list">
                        <div class="list-item">
                            <div class="head">Site/Division/Process</div>
                            <div>:</div>
                            <div> 
                                {{ $document->document_number }}
                            </div>
                        </div>
                        <div class="list-item">
                            <div class="head">Document Stage</div>
                            <div>:</div>
                            <div>{{ Helpers::getDocStatusByStage($document->stage) }}</div>
                        </div>
                        <div class="list-item">
                            <div class="head">Originator</div>
                            <div>:</div>
                            <div>{{ $document->originator ? $document->originator->name : '' }}</div>
                        </div>
                    </div>

                    <div class="activity-table">
                        <table class="table table-bordered" id='auditTable'>
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Document</th>
                                    <th>Revision Summary</th>
                                    <th>
                                        Change Control No.
                                    </th>
                                    <th>
                                        Effective Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($revision_history['data'] as $data)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $document->document_number }}</td>
                                        <td>
                                                {{ $data['field'] }}
                                            <br>{{ $data['before'] }}
                                            <br>{{ $data['after'] }}
                                        </td>
                                        <td>{{ $document->change_control_no }}</td>
                                        <td>{{ $document->effective_date }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="activity-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">SOP-{{ $document->id }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="info-list">
                        <div class="list-item">
                            <div class="head">Site/Division/Process</div>
                            <div>:</div>
                            <div>{{ $document->division }}/{{ $document->process }}</div>
                        </div>
                        <div class="list-item">
                            <div class="head">Document Stage</div>
                            <div>:</div>
                            <div>{{ $document->status }}</div>
                        </div>
                        <div class="list-item">
                            <div class="head">Originator</div>
                            <div>:</div>
                            <div>{{ $document->originator }}</div>
                        </div>
                    </div>
                    <div id="auditTableinfo"></div>

                </div>

            </div>
        </div>
    </div>

@endsection
