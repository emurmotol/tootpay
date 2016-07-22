@include('flash::message')

@section('javascript')
    <script>
        $('div.alert').not('.alert-important').delay(3000).slideUp(200);
    </script>
@endsection