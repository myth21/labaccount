@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="card">
            <div class="card-header">
                Курсы
                @include('typical_create')
            </div>
            <div class="card-body">

                @include('alert')

                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th scope="row">Название</th>
                        <th class="width100">&nbsp;</th>
                        <th class="width100">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $model)
                        <tr>
                            <td class="text-uppercase">{{ $model->name }}</td>
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
