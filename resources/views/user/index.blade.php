@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                Пользователи
                @include('typical_create')
            </div>
            <div class="card-body">

                @include('alert')

                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th>Роль</th>
                        <th>Email/Логин</th>
                        <th>Курс</th>
                        <th>Активный</th>

                        <th class="width100">&nbsp;</th>
                        <th class="width100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                        <tr>
                            <td>{{ \App\User::getRoleFromDropdownList($model->role) }}</td>
                            <td>{{ $model->email }}</td>
                            <td>
                                @if($model->courses()->exists())
                                    @foreach($model->courses as $course)
                                        <div class="text-uppercase">{{ $course->name }}</div>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $model->active ? 'Да' : 'Нет' }}</td>

                            @include('typical_control')
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
