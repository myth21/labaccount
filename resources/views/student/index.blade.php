@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                Студенты
                @include('typical_create')
            </div>
            <div class="card-body">

                @include('alert')

                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th>Студент</th>
                        <th>Группа</th>
                        <th>Курс</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($modelsWithout)
                        <tr class="borderBottomDotted">
                            <td>
                                <table>
                                    @foreach($modelsWithout as $modelWithout)
                                        <tr>
                                            <td class="borderDotted">{{ $modelWithout->name }}</td>
                                            @include('typical_control', ['model' => $modelWithout])
                                        </tr>
                                    @endforeach
                                </table>
                            </td>

                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @endif
                    @foreach($models as $model)
                    <tr class="borderBottomDotted">
                        <td>
                            @if($model->students()->exists())
                                <table>
                                    @foreach($model->students as $student)
                                        <tr>
                                            <td class="borderDotted">{{ $student->name }}</td>
                                            @include('typical_control', ['model' => $student])
                                        </tr>
                                    @endforeach
                                </table>
                            @endif
                        </td>
                        <td>{{ $model->name }}</td>
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
