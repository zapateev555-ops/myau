<label class="nx-upload-btn {{ $class ?? 'w-100' }}">
    <input type="file"
           name="image"
           class="nx-upload-btn__input @error('image') is-invalid @enderror"
           accept="image/jpeg,image/png,image/webp,image/gif"
           @if(!empty($required)) required @endif
           @if(!empty($autoSubmit)) onchange="this.form.submit()" @endif>
    <span class="nx-upload-btn__face">
        <img src="{{ asset('images/logo-mark.svg') }}" alt="" class="nx-upload-btn__icon" width="20" height="20">
        <span>{{ $label ?? 'Загрузить фото' }}</span>
    </span>
</label>
@error('image')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
