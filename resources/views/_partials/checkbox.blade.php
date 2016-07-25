@section('checkbox')
    <script>
        $("#select-multiple").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });
    </script>
@endsection