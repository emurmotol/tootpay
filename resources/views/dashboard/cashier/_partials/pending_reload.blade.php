<div class="sr-only">{{ $priority = 1 }}</div>
@foreach($reloads as $reload)
    <div class="col-md-4">
        <div class="panel panel-default cashier-huge">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <strong>#{{ $priority++ }}</strong>
                </div>
                <div class="pull-right">
                    <span data-livestamp="{{ strtotime($reload->created_at) }}"></span>
                </div>
            </div>

            <div class="panel-body">
                <ul class="list-unstyled">
                    <li>Reload ID: <strong>{{ $reload->id }}</strong></li>
                    <li>User ID: <strong>{{ $reload->user_id }}</strong></li>
                    <li>Toot Card ID: <strong>{{ $reload->toot_card_id }}</strong></li>
                    <li>Amount: <strong>P{{ number_format($reload->amount, 2, '.', ',') }}</strong></li>
                    <li class="reload-actions">
                        <button class="btn btn-primary btn-lg paid" data-id="{{ $reload->id }}" data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">Paid</button>
                        <button class="btn btn-warning btn-lg cancel" data-id="{{ $reload->id }}" data-loading-text="<i class='fa fa-spinner fa-pulse'></i> Loading...">Cancel</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endforeach