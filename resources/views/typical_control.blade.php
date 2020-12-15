<td>
    @if(Auth()->user()->can('update', $model))
        <a href="{{ route($ctrlName.'.edit', ['id' => $model->id]) }}" class="btn btn-primary btn-sm">Редактировать</a>
    @endif
</td>
<td>
    @if(Auth()->user()->can('destroy', $model))
        <form action="{{ route($ctrlName.'.destroy', ['id' => $model->id]) }}" method="post">
            <input type="hidden" name="{{ $ctrlName }}_id" value="{{ $model->id }}">
            {{ method_field('DELETE') }}
            @csrf
            <button class="btn btn-danger btn-sm" onclick="return confirm('Удалить?')">Удалить</button>
        </form>
    @endif
</td>
