<div class="form-group">
    <input type="hidden" name="id" value="{{ $model->id }}">
    <label class="control-label" for="nameInput">Название</label>
    <input type="text" name="name" class="form-control" id="nameInput" value="{{ $model->exists ? $model->name : old('name') }}">
</div>

<div>Курсы</div>
@foreach (\App\Models\Course::getList() as $id => $name)
<div class="custom-control custom-checkbox">
    <input class="custom-control-input" type="checkbox" name="course_id[]" id="courseId{{ $id }}" value="{{ $id }}" {{ App\Helpers\AppHelper::getChecked($id, $model->courses->pluck('id')->all(), old('course_id')) }}>
    <label class="custom-control-label" for="courseId{{ $id }}"><i>{{ $name }}</i></label>
</div>
@endforeach