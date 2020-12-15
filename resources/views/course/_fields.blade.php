<div class="form-group">
    <input type="hidden" name="id" value="{{ $model->id }}">
    <label class="control-label" for="nameInput">Название</label>
    <input type="text" name="name" class="form-control" id="nameInput" value="{{ $model->exists ? $model->name : old('name') }}">
</div>