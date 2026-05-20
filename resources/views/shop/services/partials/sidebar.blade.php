<div class="service-info-card">
    <h5 class="fw-bold mb-3 ac-content-title">Кратко</h5>
    <ul class="service-info-list mb-4">
        @foreach($highlights as $item)
        <li><i class="fas fa-check-circle text-accent me-2"></i>{{ $item }}</li>
        @endforeach
    </ul>
    <div class="ac-form-actions ac-form-actions--stack">
        <a href="{{ route('products') }}" class="btn btn-glow w-100">Перейти в каталог</a>
        <a href="{{ route('contacts') }}" class="btn btn-outline-ac w-100">Задать вопрос</a>
    </div>
</div>
