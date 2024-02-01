@extends('layout.app')

@section('title', 'Главная страница')

@section('content')
    <div class="container panel panel-default">
        <div class="panel-body">
        <h1>Статистика</h1>
    <p>
    {{ Form::open(['url'=>'/', 'class' => 'filter-form', 'method' => 'get']) }}
    <div class="form-group col-md-4">
        {{Form::label(22, 'IP: ')}}
        {{Form::text('ip', $request->ip, ['placeholder' => "0.0.0.0/32",'name' => 'ip','autocomplite' => 'off', 'class' => 'form-control'])}}
    </div>
    <div class="form-group col-md-4">
        {{Form::label(22, 'Маска: ')}}
        {{Form::text('mask', $request->mask, ['placeholder' => "0.0.0/32",'name' => 'mask','autocomplite' => 'off', 'class' => 'form-control'])}}
    </div>
    <div class="form-group col-md-4">
        {{Form::label(22, 'Дата: ')}}
        {{Form::date('dateFrom', $request->dateFrom, ['placeholder' => "от",'name' => 'dateFrom','autocomplite' => 'off', 'class' => 'form-control'])}}
        {{Form::date('dateTo', $request->dateTo, ['placeholder' => "до",'name' => 'dateTo','autocomplite' => 'off', 'class' => 'form-control'])}}
    </div>
    {{ Form::submit('Поиск', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
    </p>
    <table class="table ">
        <thead>
        <th>Дата</th>
        <th>IP</th>
        <th>Время (мин)</th>
        </thead>
        <tbody>
        @if ($posts->count() == 0)
            <tr>
                <td colspan="5">No rows to display.</td>
            </tr>
        @endif

        @foreach ($posts as $post)
            <tr>
                <td>
                    <div class="">
                        <h2 class="">{{ $post->date }}</h2>
                    </div>
                </td>
                <td>
                    <div class="">
                        <h2 class="">{{ $post->ip->ip }}</h2>
                    </div>
                </td>
                <td>
                    <div class="">
                        <h2 class="">{{ $post->time }}</h2>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <p>
        Displaying {{$posts->count()}} of {{ $posts->total() }} rows.
    </p>
    <p>
        Total time {{$sum}} .
    </p>
    <p>
        Timer {{$timer}} .
    </p>
    <p>
        {{ $posts->withQueryString()->links() }}
    </p>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var start = new Date();

            $(window).unload(function() {
                var end = new Date();
                $.ajax({
                    url: "log",
                    data: {'timeSpent': end - start},
                    async: false
                })
            });
        });
    </script>
@endsection
