<div class="footer">
    <p>Sincerely,</p>
    <p>{{ config('mail.from.name')  }}</p>
    <p>{{ config('mail.from.address')  }}</p>
    <p>{{ config('static.app.company') }}</p>
    <p><a href="{{ url('/') }}">{{ url('/') }}</a></p>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://getbootstrap.com/dist/js/bootstrap.min.js"></script>
</body>
</html>