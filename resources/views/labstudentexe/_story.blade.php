<div>История</div>
<table class="table table-borderless">
    @foreach ($labStudent->labStudentExes as $labStudentExe)
        <tr>
            <td class="borderDotted">{{ $labStudentExe->comment }}</td>
            <td class="borderDotted">
                @if ($labStudentExe->labStudentExeFiles()->exists())
                    @foreach($labStudentExe->labStudentExeFiles as $file)
                        <a href="{{ route('labstudentexefile.download', [$file->id]) }}" title="Скачать">{{ $file->name }}</a>
                        <br>
                    @endforeach
                @else
                    -
                @endif
            </td>
            <td class="borderDotted xSmallFont">{{ $labStudentExe->created_at }}</td>
        </tr>
    @endforeach
</table>