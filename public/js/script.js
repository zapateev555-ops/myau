document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ac-alert').forEach(function (alertEl) {
        var hideAlert = function () {
            if (alertEl.classList.contains('is-hiding')) {
                return;
            }
            alertEl.classList.add('is-hiding');
            window.setTimeout(function () {
                alertEl.remove();
            }, 400);
        };
        window.setTimeout(hideAlert, 10000);
    });

    document.querySelectorAll('form[action*="cart/add"]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (form.dataset.submitting === '1') {
                event.preventDefault();
                return;
            }

            form.dataset.submitting = '1';

            form.querySelectorAll('button[type="submit"]').forEach(function (button) {
                button.disabled = true;
            });
        });
    });

    document.querySelectorAll('.minus-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = this.parentElement.querySelector('.quantity-input');
            var val = parseInt(input.value, 10) || 1;
            if (val > 1) input.value = val - 1;
        });
    });

    document.querySelectorAll('.plus-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var input = this.parentElement.querySelector('.quantity-input');
            var val = parseInt(input.value, 10) || 1;
            var max = parseInt(input.getAttribute('max'), 10) || 100;
            if (val < max) input.value = val + 1;
        });
    });
});
