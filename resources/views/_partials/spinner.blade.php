@section('spinner')
    <script>
        $(function() {
            $("#btn-submit").click(function(){
                $(this).button('loading').delay(5000).queue(function() {
                    $(this).button('reset');
                    $(this).dequeue();
                });
            });
        });
    </script>
@endsection