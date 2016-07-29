@section('password')
    <script>
        $(".fa-eye").on("click", function() {
            $(this).toggleClass("fa-eye-slash");
            var type = $("#password").attr("type");
            if (type == "text")
            { $("#password").attr("type", "password");}
            else
            { $("#password").attr("type", "text"); }
        });
    </script>
@endsection