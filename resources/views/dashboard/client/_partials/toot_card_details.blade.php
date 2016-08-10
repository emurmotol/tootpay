<p class="huge">
    As of {{ \Carbon\Carbon::now()->toDayDateTimeString() }}, you have <span class="text-success">P{{ number_format($toot_card->load, 2, '.', ',') }} load</span> with <span class="text-success">{{ number_format($toot_card->points, 2, '.', ',') }} points</span>.
</p>
<p class="huge">
    For more information visit your account at <span class="text-primary">http://toot.pay/</span>.
</p>
<p class="huge">
    Thank you.
</p>