@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    {{ $model->exists
                    ? isset($onShow) ? 'Смотреть' : 'Редактировать'
                    : 'Добавить' }} выполнение
                </div>
                <div class="card-body">

                    <div class="quote">
                        @include('lab._item', ['model' => $lab])
                    </div>

                    @include('errors')

                    <div class="card-group">
                        <div class="card">
                            <div class="card-body">

                                @if($labStudent->labStudentExes()->exists())
                                    @include($ctrlName.'._story')
                                @endif

                                <form action="{{ $formAction }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @include($ctrlName.'._fields')
                                    <div class="clear20"></div>
                                    <a class="btn btn-primary btn-sm whiteFont float-right" href="{{ route($ctrlName.'.index') }}">Отмена</a>
                                    <button class="btn btn-success btn-sm" type="submit">Сохранить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection