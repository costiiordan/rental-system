<dialog class="add-to-cart-dialog" data-role="add-to-cart-dialog">
    <p>@lang('Produsul a fost adaugat in cos.')</p>

    <div class="add-to-cart-dialog-actions">
        <button class="btn-secondary" data-action="close-dialog">@lang('Rezerva si alte produse')</button>
        <a href="{{ route('checkout.index') }}" class="btn-golden">@lang('Finalizează comanda')</a>
    </div>
</dialog>
