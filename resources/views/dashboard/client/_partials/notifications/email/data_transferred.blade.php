@include('dashboard.client._partials.notifications.email._partials.header')
<div class="message">
    <p>Dear {{ \App\Models\User::find($data['user_id'])->name }},</p>
    <p>Toot card data from #{{ $data->uid }} was successfully transferred to your account.</p>
    <p>Thank you!</p>
</div>
@include('dashboard.client._partials.notifications.email._partials.footer')