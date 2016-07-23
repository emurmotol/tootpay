<form class="navbar-form navbar-left" role="search">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>

@section('search')
    <script>
        function search(search, url, type) {
            $.ajax({
                type: type,
                url: url,
                data: { 'search' : search },
                success: function(response){
                    $('#merchandises').html(response);
                    console.log(response);
                }
            });
        }
    </script>
@endsection