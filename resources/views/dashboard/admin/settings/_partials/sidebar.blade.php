<div class="panel panel-primary">
    <div class="panel-heading"><i class="fa fa-gear" aria-hidden="true"></i> Settings</div>

    <ul class="list-group">
        <a href="{{ route('settings.toot_card') }}" class="list-group-item {!! Route::is('settings.toot_card') ? 'active' : '' !!}">Toot Card</a>
        <a href="{{ route('settings.operation_day') }}" class="list-group-item {!! Route::is('settings.operation_day') ? 'active' : '' !!}">Operation Day</a>
    </ul>
</div>