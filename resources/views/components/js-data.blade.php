<script>
    window.rental = window.rental || {};
    window.rental.routeName = '{{request()->route()->getName()}}';
    window.rental.cart = {!! json_encode($cart->toArray()) !!};
    @if (isset($interval))
        window.rental.interval = {
            from: '{{ $interval->from->format('Y-m-d H:i') }}',
            to: '{{ $interval->to->format('Y-m-d H:i') }}'
        };
    @endif
</script>
