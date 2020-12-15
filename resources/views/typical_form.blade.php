@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    {{ $model->exists ? 'Редактирование' : 'Добавление' }}
                </div>
                <div class="card-body">

                    @include('errors')

                    <form action="{{ $model->exists ? route($ctrlName.'.update') : route($ctrlName.'.store') }}" method="post" enctype="multipart/form-data">
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
@endsection