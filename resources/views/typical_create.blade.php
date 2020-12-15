@if(Auth()->user()->isAvailableCreate(isset($forceAccess)))
    <div class="float-right"><a href="{{ route($ctrlName.'.create') }}" class="btn btn-success btn-sm">Добавить</a></div>
@endif