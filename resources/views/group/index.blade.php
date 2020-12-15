@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                Группы
                @include('typical_create')
            </div>
            <div class="card-body">

                @include('alert')

                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th class="width100">Группа</th>
                        <th class="width100"> </th>
                        <th class="width100"> </th>
                        <th>Курс</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                    <tr class="borderBottomDotted">
                        <td>{{ $model->name }}</td>
                        @include('typical_control')
                        <td>
                            @if($model->courses()->exists())
                                @foreach($model->courses as $course)
                                    <div class="text-uppercase">{{ $course->name }}</div>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
