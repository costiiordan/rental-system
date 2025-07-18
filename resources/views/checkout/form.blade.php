<form action="{{ LaravelLocalization::localizeUrl(route('checkout.save-order')) }}" method="POST">
    <h2 class="checkout-section-title">@lang('Finalizează comanda')</h2>
    <h3>@lang('Date client')</h3>
    <div class="form-control">
        <label for="name_input">@lang('Nume')*</label>
        <input type="text" id="name_input" name="name" value="{{ old('name') }}" required>
        @error('name')
        <div class="error-msg">{{$message}}</div>
        @enderror
    </div>
    <div class="form-control">
        <label for="email_input">@lang('Email')*</label>
        <input type="email" id="email_input" name="email" value="{{ old('email') }}">
        @error('email')
        <div class="error-msg">{{$message}}</div>
        @enderror
    </div>
    <div class="form-control">
        <label for="phone_input">@lang('Telefon')*</label>
        <input type="tel" id="phone_input" name="phone" value="{{ old('phone') }}" required>
        @error('phone')<div class="error-msg">{{$message}}</div>@enderror
    </div>

    <h3>@lang('Date facturare')</h3>
    <div class="form-control">
        <label for="billing_name_input">@lang('Nume pesoana/comapnie')*</label>
        <input type="text" id="billing_name_input" name="billing_name" value="{{ old('billing_name') }}">
        @error('billing_name')<div class="error-msg">{{$message}}</div>@enderror
    </div>
    <div class="form-control">
        <label for="billing_vat_number">@lang('Cui/Cnp')</label>
        <input type="text" id="billing_vat_number_input" name="billing_vat_number" value="{{ old('billing_vat_number') }}">
        @error('billing_vat_number')<div class="error-msg">{{$message}}</div>@enderror
    </div>
    <div class="form-control">
        <label for="billing_address_input">@lang('Adresa')*</label>
        <input type="text" id="billing_address_input" name="billing_address" value="{{ old('billing_address') }}" required>
        @error('billing_address')<div class="error-msg">{{$message}}</div>@enderror
    </div>
    <div class="form-control">
        <label for="billing_city_input">@lang('Oraș')*</label>
        <input type="text" id="billing_city_input" name="billing_city" value="{{ old('billing_city') }}" required>
        @error('billing_city')<div class="error-msg">{{$message}}</div>@enderror
    </div>
    <div class="form-control">
        <label for="billing_county_input">@lang('Județ')*</label>
        <input type="text" id="billing_county_input" name="billing_county" value="{{ old('billing_county') }}" required>
        @error('billing_county')<div class="error-msg">{{$message}}</div>@enderror
    </div>
    <div class="form-control">
        <label for="billing_country_input">@lang('Țara')*</label>
        <input type="text" id="billing_country_input" name="billing_country" value="{{ old('title', 'Romania') }}" required>
        @error('billing_country')<div class="error-msg">{{$message}}</div>@enderror
    </div>
    <div class="form-control">
        @php
            $paymentMethodValue = old('payment_method', \App\Models\Constants\PaymentMethods::CARD);
            $cashChecked = $paymentMethodValue === \App\Models\Constants\PaymentMethods::CASH;
            $bankTransferChecked = $paymentMethodValue === \App\Models\Constants\PaymentMethods::BANK_TRANSFER;
            $cardChecked = $paymentMethodValue === \App\Models\Constants\PaymentMethods::CARD;
        @endphp
        <label>@lang('Metodă de plată')*</label>
{{--        <label>--}}
{{--            <input type="radio" name="payment_method" value="{{\App\Models\Constants\PaymentMethods::CARD}}" @checked($cardChecked)>--}}
{{--            <span>@lang('Card prin Netopia')</span>--}}
{{--        </label>--}}
        <label>
            <input type="radio" name="payment_method" value="{{\App\Models\Constants\PaymentMethods::CASH}}" @checked($cashChecked)>
            <span>@lang('Cash la ridicare')</span>
        </label>
        <label >
            <input type="radio" name="payment_method" value="{{\App\Models\Constants\PaymentMethods::BANK_TRANSFER}}" @checked($bankTransferChecked)>
            <span>@lang('Transfer bancar')</span>
        </label>
        @error('payment_method')<div class="error-msg">{{$message}}</div>@enderror
    </div>
    <div class="form-control">
        <label for="customer_note_input">@lang('Comentariu')</label>
        <textarea id="customer_note_input" name="customer_note" rows="3">{{ old('customer_note') }}</textarea>
        @error('customer_note')<div class="error-msg">{{$message}}</div>@enderror
        <div class="form-control-note-example">
            @lang('Exemplu: Va rog să-mi reglați bicicleta pentru greutate de 80kg.')
        </div>
    </div>

    @csrf

    <div>
        <button type="submit" class="btn-golden checkout-submit-button">
            @lang('Salvează rezervarea')
        </button>
    </div>
</form>
