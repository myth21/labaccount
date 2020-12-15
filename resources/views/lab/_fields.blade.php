<div class="form-group">
    <input type="hidden" name="id" value="{{ $model->id }}">

    <label class="control-label" for="courseInput">Курс</label>
    <select class="form-control" id="courseInput" name="course_id">
        @foreach(\App\Models\Course::getList() as $key => $name)
            <option @if($model->course_id == $key) selected="selected" @endif value="{{ $key }}">{{ $name }}</option>
        @endforeach;
    </select>

    <label class="control-label" for="numberInput">Номер</label>
    <input type="text" name="number" class="form-control" id="numberInput" value="{{ $model->exists ? $model->number : old('number') }}">

    <label class="control-label" for="nameInput">Название</label>
    <input type="text" name="name" class="form-control" id="nameInput" value="{{ $model->exists ? $model->name : old('name') }}">

    <label class="control-label" for="taskInput">Задание</label>
    <textarea class="form-control" name="task" id="taskInput" rows="6">{{ $model->exists ? $model->task : old('task') }}</textarea>

    @if($model->labFiles()->exists())
        <div class="clear10"></div>
        <div>Файлы</div>
        <ul>
            @foreach($model->labFiles as $labFile)
                <li class="marginBottom10" id="deleteId{{$labFile->id}}">
                    <a href="{{ route('labfile.download', [$labFile->id]) }}">{{ $labFile->name }}</a>
                    <button
                            class="btn btn-danger btn-sm xSmallFont toDelete"
                            data-model="{{ json_encode($labFile) }}"
                    >Удалить</button>
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
                'route': '{{ route("labfile.destroy") }}',
                'deleteId': '#deleteId'
            });
            deleteModel.onReady();
        </script>
    @endif

    <div class="form-group marginTop20 ">
        <label for="filesInput">Прикрепить файлы (ctrl+click)</label>
        <input type="file" class="form-control-file" id="filesInput" name="files[]" multiple>
    </div>

    <div class="clear10"></div>

</div>