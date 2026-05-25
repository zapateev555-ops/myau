<a href="{{ route('index') }}" class="brand-logo {{ $class ?? '' }}">
    @include('shop.partials.brand_logo', ['width' => 200, 'height' => 48, 'variant' => 'header', 'class' => 'brand-logo__wrap ac-brand-logo'])
</a>
