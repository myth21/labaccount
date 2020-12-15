@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                Лабораторные
                @include('typical_create', Auth()->user()->isTeacher() ? ['forceAccess' => true] : [])
            </div>
            <div class="card-body">

                @include('alert')

                @foreach($models as $model)
                    <div class="text-uppercase">{{ $model->name }}</div>
                    @if ($model->labs()->exists())
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Задание</th>
                                <th>Файлов</th>
                                <th class="width100">&nbsp;</th>
                                <th class="width100">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($model->labs as $lab)
                            <tr>
                                <td>
                                    <button type="button" value="{{ $lab->id }}" class="btn btn-primary btn-sm _labBtn" data-toggle="modal" data-target="#myModal">
                                        №{{ $lab->number }} {{ $lab->name }}
                                    </button>
                                </td>
                                <td>{{ str_limit($lab->task, $limit = 150, $end = '...') }}</td>
                                <td>{{ count($lab->labFiles) }}</td>

                                @include('typical_control', ['model' => $lab])
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @unless($loop->last) <hr> @endif

                    @endif
                @endforeach

                @include('lab_modal')
            </div>
        </div>

    </div>
</div>
@endsection
