document.addEventListener('DOMContentLoaded', function () {
    var cartPage = document.getElementById('cart-page');
    if (!cartPage) {
        return;
    }

    var totalEl = document.getElementById('cart-total');
    var debounceTimers = {};

    function formatPrice(value) {
        return new Intl.NumberFormat('ru-RU').format(Math.round(value)) + ' \u20BD';
    }

    function clampQuantity(value) {
        var qty = parseInt(value, 10);
        if (Number.isNaN(qty) || qty < 1) {
            return 1;
        }
        if (qty > 100) {
            return 100;
        }
        return qty;
    }

    function getRow(input) {
        return input.closest('[data-cart-row]');
    }

    function updateRowTotals(row) {
        var input = row.querySelector('.cart-qty-input');
        var unitPrice = parseFloat(row.dataset.unitPrice) || 0;
        var quantity = clampQuantity(input.value);
        input.value = quantity;

        var lineTotal = unitPrice * quantity;
        var lineTotalEl = row.querySelector('.cart-line-total');
        if (lineTotalEl) {
            lineTotalEl.textContent = formatPrice(lineTotal);
        }

        return lineTotal;
    }

    function updateCartTotal() {
        var sum = 0;
        cartPage.querySelectorAll('[data-cart-row]').forEach(function (row) {
            sum += updateRowTotals(row);
        });

        if (totalEl) {
            totalEl.textContent = formatPrice(sum);
        }

        return sum;
    }

    function updateDockBadge(count) {
        document.querySelectorAll('.ac-navbar__badge, .ac-dock__badge').forEach(function (badge) {
            if (count > 0) {
                badge.textContent = String(count);
                badge.style.display = '';
            } else {
                badge.style.display = 'none';
            }
        });

        document.querySelectorAll('.ac-topbar .badge.bg-danger').forEach(function (badge) {
            if (count > 0) {
                badge.textContent = String(count);
                badge.style.display = '';
            } else {
                badge.style.display = 'none';
            }
        });
    }

    function saveQuantity(input) {
        var row = getRow(input);
        var url = input.dataset.updateUrl;
        if (!url) {
            return;
        }

        var quantity = clampQuantity(input.value);
        input.value = quantity;

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: JSON.stringify({ quantity: quantity }),
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('update failed');
                }
                return response.json();
            })
            .then(function (data) {
                if (data.removed) {
                    row.remove();
                    if (!cartPage.querySelector('[data-cart-row]')) {
                        window.location.reload();
                    }
                } else if (typeof data.quantity !== 'undefined') {
                    input.value = data.quantity;
                    var lineTotalEl = row.querySelector('.cart-line-total');
                    if (lineTotalEl && typeof data.line_total !== 'undefined') {
                        lineTotalEl.textContent = formatPrice(data.line_total);
                    }
                }

                if (typeof data.cart_total !== 'undefined' && totalEl) {
                    totalEl.textContent = formatPrice(data.cart_total);
                } else {
                    updateCartTotal();
                }

                if (typeof data.cart_items_count !== 'undefined') {
                    updateDockBadge(data.cart_items_count);
                }
            })
            .catch(function () {
                input.classList.add('is-invalid');
                setTimeout(function () {
                    input.classList.remove('is-invalid');
                }, 1500);
            });
    }

    function scheduleSave(input) {
        var itemId = input.dataset.itemId;
        clearTimeout(debounceTimers[itemId]);
        debounceTimers[itemId] = setTimeout(function () {
            saveQuantity(input);
        }, 400);
    }

    cartPage.querySelectorAll('.cart-qty-input').forEach(function (input) {
        input.addEventListener('input', function () {
            updateRowTotals(getRow(input));
            updateCartTotal();
            scheduleSave(input);
        });
    });

    cartPage.querySelectorAll('.cart-qty-minus').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = button.parentElement.querySelector('.cart-qty-input');
            input.value = clampQuantity(parseInt(input.value, 10) - 1);
            input.dispatchEvent(new Event('input', { bubbles: true }));
        });
    });

    cartPage.querySelectorAll('.cart-qty-plus').forEach(function (button) {
        button.addEventListener('click', function () {
            var input = button.parentElement.querySelector('.cart-qty-input');
            input.value = clampQuantity(parseInt(input.value, 10) + 1);
            input.dispatchEvent(new Event('input', { bubbles: true }));
        });
    });
});
