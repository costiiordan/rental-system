<form action="{{route('checkout.save-order')}}" method="POST">
    <h2>Date client</h2>
    <div>
        <label for="name_input">Nume*</label>
        <input type="text" id="name_input" name="name" value="{{ old('name') }}" placeholder="Nume" required>
        @error('name')
        <div>{{$message}}</div>
        @enderror
    </div>
    <div>
        <label for="email_input">Email*</label>
        <input type="email" id="email_input" name="email" value="{{ old('email') }}" placeholder="Email">
        @error('email')
        <div>{{$message}}</div>
        @enderror
    </div>
    <div>
        <label for="phone_input">Telefon*</label>
        <input type="tel" id="phone_input" name="phone" value="{{ old('phone') }}" placeholder="Telefon" required>
        @error('phone')<div>{{$message}}</div>@enderror
    </div>

    <h2>Date facturare</h2>
    <div>
        <label for="billing_name_input">Nume pesoana/comapnie*</label>
        <input type="text" id="billing_name_input" name="billing_name" value="{{ old('billing_name') }}" placeholder="Nume">
        @error('billing_name')<div>{{$message}}</div>@enderror
    </div>
    <div>
        <label for="billing_vat_number">Cui/Cnp</label>
        <input type="text" id="billing_vat_number_input" name="billing_vat_number" value="{{ old('billing_vat_number') }}" placeholder="Cui">
        @error('billing_vat_number')<div>{{$message}}</div>@enderror
    </div>
    <div>
        <label for="billing_address_input">Adresa*</label>
        <input type="text" id="billing_address_input" name="billing_address" value="{{ old('billing_address') }}" placeholder="Adresa" required>
        @error('billing_address')<div>{{$message}}</div>@enderror
    </div>
    <div>
        <label for="billing_city_input">Oraș*</label>
        <input type="text" id="billing_city_input" name="billing_city" value="{{ old('billing_city') }}" placeholder="Oraș" required>
        @error('billing_city')<div>{{$message}}</div>@enderror
    </div>
    <div>
        <label for="billing_county_input">Județ*</label>
        <input type="text" id="billing_county_input" name="billing_county" value="{{ old('billing_county') }}" placeholder="Județ" required>
        @error('billing_county')<div>{{$message}}</div>@enderror
    </div>
    <div>
        <label for="billing_country_input">Țara*</label>
        <input type="text" id="billing_country_input" name="billing_country" value="{{ old('title', 'Romania') }}" placeholder="Țara" required>
        @error('billing_country')<div>{{$message}}</div>@enderror
    </div>
    <div>
        @php
            $paymentMethodValue = old('payment_method', \App\Models\Constants\PaymentMethods::CARD);
            $cashChecked = $paymentMethodValue === \App\Models\Constants\PaymentMethods::CASH;
            $bankTransferChecked = $paymentMethodValue === \App\Models\Constants\PaymentMethods::BANK_TRANSFER;
            $cardChecked = $paymentMethodValue === \App\Models\Constants\PaymentMethods::CARD;
        @endphp

        <label>
            <input type="radio" name="payment_method" value="{{\App\Models\Constants\PaymentMethods::CARD}}" @checked($cardChecked)>
            <span>Card prin Netopia</span>
        </label>
        <label>
            <input type="radio" name="payment_method" value="{{\App\Models\Constants\PaymentMethods::CASH}}" @checked($cashChecked)>
            <span>Cash la ridicare</span>
        </label>
        <label >
            <input type="radio" name="payment_method" value="{{\App\Models\Constants\PaymentMethods::BANK_TRANSFER}}" @checked($bankTransferChecked)>
            <span>Transfer bancar</span>
        </label>
        @error('payment_method')<div>{{$message}}</div>@enderror
        <div>
            <label for="customer_note_input">Comentariu</label>
            <textarea id="customer_note_input" name="customer_note">{{ old('customer_note') }}</textarea>
            @error('customer_note')<div>{{$message}}</div>@enderror
        </div>
    </div>

    @csrf

    <div>
        <button type="submit">
            Salvează rezervarea
        </button>
    </div>
</form>
