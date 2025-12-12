document.addEventListener('DOMContentLoaded', function() {
    // Обработка фильтров
    const filterForm = document.getElementById('filter-form');
    const priceInputs = document.querySelectorAll('input[name="price"]');
    const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]');
    const brandCheckboxes = document.querySelectorAll('input[name="brand[]"]');
    const categoryAll = document.querySelector('input[name="category_all"]');
    const brandAll = document.querySelector('input[name="brand_all"]');

    // Обработка выбора цены
    priceInputs.forEach(input => {
        input.addEventListener('change', function() {
            document.getElementById('filter-price').value = this.value;
            filterForm.submit();
        });
    });

    // Обработка категорий
    categoryCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCategoryFilter();
        });
    });

    categoryAll.addEventListener('change', function() {
        if (this.checked) {
            categoryCheckboxes.forEach(cb => cb.checked = false);
            document.getElementById('filter-category').value = '';
            filterForm.submit();
        }
    });

    // Обработка брендов
    brandCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateBrandFilter();
        });
    });

    brandAll.addEventListener('change', function() {
        if (this.checked) {
            brandCheckboxes.forEach(cb => cb.checked = false);
            document.getElementById('filter-brand').value = '';
            filterForm.submit();
        }
    });

    function updateCategoryFilter() {
        const selected = Array.from(categoryCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        document.getElementById('filter-category').value = selected.join(',');
        filterForm.submit();
    }

    function updateBrandFilter() {
        const selected = Array.from(brandCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        document.getElementById('filter-brand').value = selected.join(',');
        filterForm.submit();
    }

    // Добавление в корзину через AJAX
    document.querySelectorAll('.add-to-cart-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Товар добавлен в корзину!');
                        // Обновляем счетчик корзины
                        updateCartCount();
                    } else {
                        alert(data.message || 'Ошибка при добавлении в корзину');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ошибка при добавлении в корзину');
                });
        });
    });

    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                    cartBadge.style.display = data.count > 0 ? 'inline' : 'none';
                }
            });
    }
});
