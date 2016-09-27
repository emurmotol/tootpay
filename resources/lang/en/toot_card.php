<?php

return [

    'no_available' => 'There are no available cards.',
    'no_user' => 'This card is not associated to any user.',
    'created' => '<strong>#:uid</strong> has been successfully created!',
    'updated' => '<strong>#:uid</strong> has been successfully updated!',
    'deleted' => '<strong>#:uid</strong> has been successfully deleted!',
    'delete_fail_associated' => 'Unable to delete <strong>#:uid</strong>. The card is currently associated to :user_link.',
    'delete_fail_active' => 'Unable to delete <strong>#:uid</strong>. The card is still active!',
    'exception' => ':Error',
    'queue_number_is' => 'Your queue number is:',
    'details' => '<strong>Your balance is...</strong>',
    'balance' => 'As of :Date, you have <span class="text-success">P:load load</span> with <span class="text-success">:points points</span>.',
    'tap_card' => '<strong>Please tap your toot card!</strong>',
    'enter_pin' => '<strong>Enter your pin code</strong>',
    'enter_load_amount' => '<strong>Enter load amount</strong>',

    'empty_load_amount' => '<strong class="text-danger"><i class="fa fa-exclamation-triangle"></i> The load amount field is required.</strong>',
    'empty_pin' => '<strong class="text-danger"><i class="fa fa-exclamation-triangle"></i> The pin code field is required.</strong>',
    'exceed_max_load_limit' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! The load amount you entered exceeds the maximum load limit. (P:limit)</strong>',
    'exceed_min_load_limit' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! The load amount you entered exceeds the minimum load limit. (P:limit)</strong>',
    'insufficient_balance' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! Your balance is not enough to complete the payment.</strong>',
    'insufficient_load_share' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! Your load is not enough to complete the load sharing.</strong>',
    'insufficient_load' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! Your load is not enough to complete the payment.</strong>',
    'insufficient_points' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! Your points are not enough to complete the redeem.</strong>',
    'invalid_card' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! Invalid toot card.</strong>',
    'active' => '<strong class="text-danger"><i class="fa fa-exclamation-triangle"></i> Toot card is active.</strong>',
    'already_associated' => '<strong class="text-danger"><i class="fa fa-exclamation-triangle"></i> Toot card is already taken.</strong>',
    'inactive_card' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! Inactive toot card.</strong>',
    'expired_card' => '<strong class="text-danger"><i class="fa fa-exclamation-triangle"></i> Your toot card has expired.</strong>',
    'to_many_card_tap' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! To many card tap.</strong>',
    'transaction_complete' => '<strong class="text-success"><i class="fa fa-check"></i> Transaction complete!</strong>',
    'reload_request_sent' => '<strong class="text-success"><i class="fa fa-check"></i> Reload request was successfully sent!</strong>',
    'load_shared' => '<strong class="text-success"><i class="fa fa-check"></i> You have successfully shared your load!</strong>',
    'wrong_pin' => '<strong class="text-danger"><i class="fa fa-times"></i> Whoops! Wrong pin code. Try again.</strong>',

];