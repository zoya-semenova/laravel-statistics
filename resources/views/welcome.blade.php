@extends('layout.app')

@section('title', 'Главная страница')

@section('content')
    <div class="container panel panel-default">
        <div class="panel-body">
            <div class="sm:mb-0 self-center">
                    <a id="admin" href="{{ route("admin") }}" class="text-md no-underline text-grey-darker hover:text-blue-dark ml-2 px-1">Админка</a>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var start = new Date;

            $("#admin").on("click", function() {
                var end = new Date;
                $.ajax({
                    url: "log",
                    data: {'timeSpent': (end.getMinutes() - start.getMinutes())},
                    async: false
                })
            });
        });
    </script>
@endsection
