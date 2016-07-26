<form role="search">
    <div class="form-group">
        <input type="text" id="search" name="search" class="form-control"
               onkeyup="searchFor(this.value, '{!! $url !!}', '{!! $type !!}')" placeholder="Search">
    </div>
</form>

@section('search')
    <script>
        function searchFor(keyword, url, type) {
            $.ajax({
                type: type,
                url: url,
                data: {'search': keyword},
                success: function (result) {
                    $('.table-responsive').html(result);
                    console.log(result);
                }
            });
        }
    </script>
@endsection