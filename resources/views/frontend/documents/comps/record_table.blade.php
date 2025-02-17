<div class="main-head">
    <div>Records</div>
    <div>
        {{ count($documents) }} Results {{ isset($count) ? ' out of Results  ' .  $count : 'found' }}
    </div>
</div>
<div class="table-list">
    <table class="table table-bordered">
        <thead>
            <th class="pr-id" data-bs-toggle="modal" data-bs-target="#division-modal">
                ID
            </th>
            <th class="division">
                Document Type
            </th>
            <th class="division">
                Division
            </th>
            <th class="short-desc">
                Short Description
            </th>
            <th class="create-date">
                Create Date Time
            </th>
            <th class="assign-name">
                Originator
            </th>
            <th class="modify-date">
                Modify Date Time
            </th>
            <th class="status">
                Status
            </th>
            <th class="action">
                Action
            </th>
        </thead>
        <tbody id="searchTable">
            @if (count($documents) > 0)
            @foreach ($documents as $doc)
                @php
                    $documentType = DB::table('document_types')->where('id', $doc->document_type_id)->select('name')->first();
                    $originator = DB::table('users')->where('id', $doc->originator_id)->select('name')->first();

                    $documentTypeName = $documentType ? $documentType->name : 'N/A';
                    $originatorName = $originator ? $originator->name : 'N/A';
                @endphp
            <tr>
                <td class="pr-id" style="text-decoration:underline"><a href="{{ route('documents.edit', $doc->id) }}">
                        000{{ $doc->id }}
                    </a>
                </td>
                <td class="division">
                    {{ $documentTypeName }}
                </td>
                <td class="division">
                    {{ Helpers::getDivisionName($doc->division_id) }}
                </td>

                <td style="display: inline-block;
                width: 305px;
                white-space: nowrap;
                overflow: hidden !important;
                text-overflow: ellipsis" class="short-desc">
                    {{ $doc->short_description }}
                </td>
                <td class="create-date">
                    {{ $doc->created_at }}
                </td>
                <td class="assign-name">
                    {{ $originatorName }}
                </td>
                <td class="modify-date">
                    {{ $doc->updated_at }}
                </td>
                <td class="status">
                    {{ Helpers::getDocStatusByStage($doc->stage, $doc->training_required) }}
                </td>
                <td class="action">
                    <div class="action-dropdown">
                        <div class="action-down-btn">Action <i class="fa-solid fa-angle-down"></i></div>
                        <div class="action-block">
                            <a href="{{ url('doc-details', $doc->id) }}">View
                            </a>

                            @if ($doc->status != 'Obsolete')
                                <a href="{{ route('documents.edit', $doc->id) }}">Edit</a>
                                
                            @endif

                            <!--<form-->
                            <!--    action="{{ route('documents.destroy', $doc->id) }}"-->
                            <!--    method="post">-->
                            <!--    @csrf-->
                            <!--    @method('DELETE')-->
                            <!--    <button type="submit">Delete</button>-->
                            <!--</form>-->

                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <center>
                <h5>Data not Found</h5>
            </center>
            @endif

        </tbody>
    </table>
    @if (isset($count))
        {!! $documents->links() !!}
    @endif
</div>