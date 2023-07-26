<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th>Student</th>
            {{-- <th>Group</th> --}}
            @foreach ($procedures->groupBy('section_id') as $key =>$section)
                @foreach ($section as $procedure)
                    <th style="background-color: {{ $colors[$key] }}; color: #fff">{{ $procedure->title }}</th>
                @endforeach
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->sequence_number }}</td>
                {{-- <td></td> --}}
                @foreach ($procedures as $procedure)
                    @if(!in_array($procedure->section_id, $student->sectionids))
                        <td class="table-secondary">{{ 'N/A' }}</td>
                    @else
                        @if ($student->is_terminated)
                            <td class="table-danger">{{ 'T' }}</td>
                        @else
                            <td class="table-success">{{ $student->checkResult($procedure->id) }} <span class="small text-secondary">@php $findGroup = $student->groups->firstWhere('section.section_id', $procedure->section_id); echo '( ' . $findGroup->title . ' )'; @endphp</span></td>
                        @endif
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>