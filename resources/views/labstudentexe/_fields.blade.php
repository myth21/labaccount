<input type="hidden" name="lab_id" value="{{ $lab->id }}">
<input type="hidden" name="lab_student_id" value="{{ $labStudent->exists ? $labStudent->id : '' }}">
<input type="hidden" name="id" value="{{ $model->exists ? $model->id : '' }}">

<div>Кто сдаёт?</div>
@foreach (App\Models\Student::getListFromCourse($lab->course) as $id => $name)
    @php
        $ckecked = App\Helpers\Helper::getCkecked($id, $labStudent->getStudentList());
        $isUnited = in_array($id, App\Models\Student::getUnitedListFromLab($lab));
        $readOnly = (!$ckecked && $isUnited || isset($onAdd)) ? 'style="color:#6c757d" onclick="return false;"' : '';
    @endphp
    <div class="custom-control custom-checkbox">
        <input
                class="custom-control-input"
                type="checkbox"
                name="student_id[]"
                id="studentId{{ $id }}"
                value="{{ $id }}"
                {{ $ckecked }}
                {!! $readOnly !!}
        >
        <label {!! $readOnly !!} class="custom-control-label" for="studentId{{ $id }}">
            <i>{{ $name }}</i>
        </label>
    </div>
@endforeach

<div class="form-group">
    <label class="control-label" for="commentInput">Решение / Комментарий</label>
    <textarea class="form-control" name="comment" id="commentInput" rows="4">{{ $model->exists ? $model->comment : old('comment') }}</textarea>
</div>

@if($model->labStudentExeFiles()->exists())
    <input type="hidden" name="isFiles" value="true">

    <div class="clear10"></div>
    <i>Приложенные файлы:</i>
    <ul>
        @foreach($model->labStudentExeFiles as $file)
            <li class="marginBottom10" id="deleteId{{$file->id}}">
                <a href="{{ route('labstudentexefile.download', [$file->id]) }}">{{ $file->name }}</a>
                <button {{ isset($onShow) ? 'hidden' : '' }} class="btn btn-danger btn-sm xSmallFont toDelete" data-model="{{ json_encode($file) }}">Удалить</button>
            </li>
        @endforeach
    </ul>
    <script>
        let deleteModel = new DeleteModel({
            'token': '{{ csrf_token() }}',
            'selector': '.toDelete',
            'e': 'click',
            'confirm': {
                'is': true,
                'message': 'Удалить?',
            },
            'route': '{{ route("labstudentexefile.destroy") }}',
            'deleteId': '#deleteId'
        });
        deleteModel.onReady();
    </script>
@endif

<div class="form-group marginTop20">
    <label for="filesInput">Прикрепить файлы (ctrl+click). Максимальный размер загружаемых файлов: {{ ini_get('upload_max_filesize') }}</label>
    <input type="file" class="form-control-file" id="filesInput" name="files[]" multiple>
</div>

<div class="form-group">
    <label class="control-label" for="statusInput">Состояние</label>
    <select class="form-control w-25" id="statusInput" name="status">
        @foreach($model->getStatusList() as $key => $name)
            <option @if($model->status == $key) selected="selected" @endif value="{{ $key }}">{{ $name }}</option>
        @endforeach;
    </select>
</div>
