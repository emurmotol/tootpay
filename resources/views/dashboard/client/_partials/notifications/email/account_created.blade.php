@include('dashboard.client._partials.notifications.email._partials.header')
<div class="message">
    <p>Dear {{ \App\Models\User::find($data['user_id'])->name }},</p>
    <p>Your account was successfully created.</p>
    <p>Your toot card pin code is: <i>{{ $data['pin_code'] }}</i></p>
    <p>You can also access your account by logging with these credentials at <a href="{{ url('login') }}">{{ url('login') }}</a></p>
    <p>User ID: <i>{{ $data['user_id'] }}</i></p>
    <p>Password: <i>{{ $data['password'] }}</i></p>
    <p>Thank you!</p>
</div>
@include('dashboard.client._partials.notifications.email._partials.footer')
