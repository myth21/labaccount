@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Выполнение
            </div>
            <div class="card-body">

                @include('alert')
                @foreach($models as $model)
                    <div class="text-uppercase">{{ $model->name }}</div>
                    @if ($model->labs()->exists())
                        <table class="table table-borderless">
                            <thead>
                            <tr>
                                <th>Лабораторная</th>
                                <th>Решения</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($model->labs as $lab)
                                <tr class="@unless($loop->last) borderBottomDotted @endif">
                                    <td class="width100">
                                        <button type="button" value="{{ $lab->id }}" class="btn btn-primary btn-sm _labBtn" data-toggle="modal" data-target="#myModal">
                                            №{{ $lab->number }} {{ $lab->name }}
                                        </button>
                                    </td>
                                    <td>
                                        @if($lab->labStudents()->exists())
                                        <table class="marginBottom10">
                                            @foreach($lab->labStudents as $labStudent)
                                            <tr>
                                                @php
                                                    $latestLabStudentExe = $labStudent->labStudentExes()->latest()->first() ;
                                                @endphp
                                                <td class="borderDotted">
                                                    {!! implode(',<br>', $labStudent->getStudentList()) !!}
                                                </td>
                                                <td class="borderDotted">
                                                    {{ str_limit($latestLabStudentExe->comment , $limit = 75, $end = '...') }}
                                                </td>
                                                <td class="borderDotted{{ $latestLabStudentExe->getStatusClassName() }}">
                                                    {{ $latestLabStudentExe->status }}
                                                </td>

                                                <td class="borderDotted xSmallFont">
                                                    {!! str_replace(' ', '<br>', $latestLabStudentExe->updated_at) !!}
                                                </td>

                                                @unless($latestLabStudentExe->isStatus(\App\Models\LabStudentExe::DONE_STATUS))
                                                    <td>
                                                        <a href="{{ route($ctrlName.'.add', ['id' => $labStudent->id]) }}" class="btn btn-success btn-sm">Продолжить<br>решение</a>
                                                    </td>

                                                    @include('typical_control', [
                                                        'model' => $latestLabStudentExe,
                                                        'ctrlName' => $ctrlName
                                                    ])
                                                @endif
                                            </tr>
                                            @endforeach
                                        </table>
                                        @endif

                                        <div class="marginBottom20">
                                            <a href="{{ route($ctrlName.'.create', ['id' => $lab->id]) }}" class="btn btn-success btn-sm">Добавить решение</a>
                                        </div>
                                    </td>
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
