<input type="hidden" name="id" value="{{ $model->id }}">
<div class="form-group">
    <label class="control-label" for="nameInput">ФИО</label>
    <input type="text" name="name" class="form-control" id="nameInput" value="{{ $model->exists ? $model->name : old('name') }}">
</div>
<label class="control-label" for="groupInput">Группа</label>
<select class="form-control" id="groupInput" name="group_id">
    <option selected="selected" value=""></option>
    @foreach(\App\Models\Group::getList() as $key => $name)
        <option @if($model->group_id == $key) selected="selected" @endif value="{{ $key }}">{{ $name }}</option>
    @endforeach;
</select>
