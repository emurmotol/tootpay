@section('sort')
    <script>
        $(function () {
            $(".sort li a").click(function () {
                $("#sort").text($(this).text());
                $("#sort").val($(this).text());
            });
        });
    </script>
@endsection