<h5 class="card-title">№{{ $model->number }} {{ $model->name }}</h5>
<h6 class="card-subtitle mb-2 text-muted">{{ $model->course->name }}</h6>
<p class="card-text">{{ $model->task }}</p>
@if($model->labFiles()->exists())
    <i>Приложенные файлы:</i>
    <ul>
        @foreach($model->labFiles as $labFile)
            <li><a href="{{ route('labfile.download', [$labFile->id]) }}">{{ $labFile->name }}</a></li>
        @endforeach
    </ul>
@endif