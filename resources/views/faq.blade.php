@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">Frequently Asked Questions</div>
            <div class="panel-body">
                <div class="faq">
                    <div class="question"><strong>1. What is {{ config('static.app.name') }} card?</strong></div>
                    <div class="answer">{{ ucfirst(config('static.app.name')) }} card is
                        {{ config('static.app.company') }} customer {{ config('static.app.name') }} program that rewards members
                        with points every time they eat in canteen. The points can then be used as currency for any item
                        sold in any of the food.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>2. How do I become a member?</strong></div>
                    <div class="answer">Buy a {{ config('static.app.name') }} card Welcome Kit at cashier counter of
                        Kuya Franz canteen for only
                        P{{ number_format(\App\Models\Setting::value('toot_card_price'), 2, '.', ',') }}. Fill out the
                        Application Form and submit to the cashier counter of canteen. You can also
                        register online at <a href="{{ url('/') }}">{{ url('/') }}</a>.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>3. What is the duration of the membership?</strong></div>
                    <div class="answer">Membership in {{ config('static.app.name') }} card is valid for {{ (new NumberFormatter(config('app.locale'), NumberFormatter::SPELLOUT))->format(\App\Models\Setting::value('toot_card_expire_year_count')) }} ({{ \App\Models\Setting::value('toot_card_expire_year_count') }}) years
                        from date of application.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>4. How do I earn points?</strong></div>
                    <div class="answer">Just use your {{ config('static.app.name') }} card in paying your bill in
                        canteen. For every P{{ number_format(\App\Models\Setting::value('per_point'), 2, '.', ',') }} purchase
                        you earn one (1) {{ config('static.app.name') }} point. One (1) {{ config('static.app.name') }} point = P1.00. No Card, No Points.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>5. How do I redeem?</strong></div>
                    <div class="answer">Just go to the cashier that you will be utilizing your {{ config('static.app.name') }} points for payment
                        of your food order.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>6. How do I check my {{ config('static.app.name') }} points balance?</strong></div>
                    <div class="answer">You may go to canteen and tap your card in card reader. It will automatically
                        display your point balance. Your {{ config('static.app.name') }} points balance is also send a digital receipt every time
                        you do a load or payment transaction. You may also visit and log on to <a
                                href="{{ url('/') }}">{{ url('/') }}</a>. to
                        manage your account online, find out your card balance.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>7. What happens if I lose my card?</strong></div>
                    <div class="answer">You will buy another {{ config('static.app.name') }} card to transfer the
                        balance and {{ config('static.app.name') }} points.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>8. What happens if I damage my {{ config('static.app.name') }} card?
                            Can I have it replaced?</strong>
                    </div>
                    <div class="answer">A damaged card caused by cardholder's mishandling may be replaced with a fee of
                        P{{ number_format(\App\Models\Setting::value('toot_card_price'), 2, '.', ',') }}.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>9. How do I change personal data?</strong></div>
                    <div class="answer">Keep your personal information up to date by reporting any change. Log on to
                        <a href="{{ url('/') }}">{{ url('/') }}</a> and fill up the data update form.
                    </div>
                </div>
                <div class="faq">
                    <div class="question"><strong>10. What is the advantage of loading more in
                            the {{ config('static.app.name') }} card?</strong>
                    </div>
                    <div class="answer">The convenience of cashless transaction in canteen.</div>
                </div>
            </div>
        </div>
    </div>
@endsection