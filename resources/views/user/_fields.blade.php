<input type="hidden" name="id" value="{{ $model->id }}">

<div class="form-group">

    <label class="control-label" for="emailInput">Email/Логин</label>
    <input type="text" name="email" class="form-control" id="emailInput" value="{{ $model->exists ? $model->email : old('email') }}">

    <label class="control-label" for="passwordInput">Пароль</label>
    <input type="password" name="password" class="form-control" id="passwordInput" value="" required>

    <label class="control-label">Курсы</label>
    @foreach (\App\Models\Course::getList() as $id => $name)
        <div class="custom-control custom-checkbox">
            <input class="custom-control-input" type="checkbox" name="course_id[]" id="courseId{{ $id }}" value="{{ $id }}" {{ App\Helpers\AppHelper::getChecked($id, $model->courses->pluck('id')->all(), old('course_id')) }}>
            <label class="custom-control-label" for="courseId{{ $id }}"><i>{{ $name }}</i></label>
        </div>
    @endforeach

    <label class="control-label" for="roleInput">Роль</label>
    <select class="form-control" id="roleInput" name="role">
        @foreach(\App\User::getRoleDropdownList() as $key => $name)
            <option @if($model->role == $key) selected="selected" @endif value="{{ $key }}">{{ $name }}</option>
        @endforeach;
    </select>

    <div class="custom-control custom-radio marginTop20">
        <input value="0" type="radio" id="activeInput1" name="active" class="custom-control-input">
        <label class="custom-control-label" for="activeInput1">Не активный</label>
    </div>
    <div class="custom-control custom-radio marginBottom20">
        <input value="1" type="radio" id="activeInput2" name="active" class="custom-control-input" checked="checked">
        <label class="custom-control-label" for="activeInput2">Активный</label>
    </div>

</div>
