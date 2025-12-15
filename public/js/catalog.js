// Скрипт для выбора размера
document.addEventListener('DOMContentLoaded', function() {
    // Обработка клика по варианту размера
    document.querySelectorAll('.size-option').forEach(option => {
        option.addEventListener('click', function() {
            const productCard = this.closest('.product-card');

            // Сбрасываем активный класс у всех вариантов в этой карточке
            productCard.querySelectorAll('.size-option').forEach(el => {
                el.classList.remove('active');
            });

            // Добавляем активный класс текущему
            this.classList.add('active');

            // Устанавливаем значение в скрытое поле
            const productId = this.closest('.product-card').querySelector('form').action.split('/').pop();
            const sizeInput = document.getElementById('selected-size-' + productId);
            if (sizeInput) {
                sizeInput.value = this.dataset.size;

                // Активируем кнопку, если она была отключена
                const addBtn = this.closest('.product-card').querySelector('.add-to-cart-btn');
                if (addBtn && addBtn.disabled && addBtn.textContent === 'Выберите размер') {
                    addBtn.disabled = false;
                    addBtn.textContent = 'В корзину';
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Обработка изменения количества через input
        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value < 1) {
                    this.value = 1;
                }
                if (this.value > parseInt(this.max)) {
                    this.value = this.max;
                    alert('Максимальное количество: ' + this.max);
                }
                this.parentNode.submit();
            });

            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    this.parentNode.submit();
                }
            });
        });

        // Подтверждение удаления
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Вы уверены, что хотите удалить этот товар из корзины?')) {
                    e.preventDefault();
                }
            });
        });

        // Подтверждение очистки корзины
        document.querySelectorAll('.clear-cart-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                if (!confirm('Вы уверены, что хотите полностью очистить корзину?')) {
                    e.preventDefault();
                }
            });
        });
    });

    // Проверка выбора размера перед отправкой формы
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const productCard = this.closest('.product-card');
            const sizeOptions = productCard.querySelectorAll('.size-option');
            const sizeInput = productCard.querySelector('input[name="size"]');
            const addBtn = productCard.querySelector('.add-to-cart-btn');

            // Если есть варианты размеров, но не выбран ни один
            if (sizeOptions.length > 0 && (!sizeInput || !sizeInput.value)) {
                e.preventDefault();

                // Делаем кнопку неактивной и меняем текст
                if (addBtn) {
                    addBtn.disabled = true;
                    addBtn.textContent = 'Выберите размер';

                    // Через 2 секунды возвращаем исходное состояние
                    setTimeout(() => {
                        if (addBtn.disabled) {
                            addBtn.disabled = false;
                            addBtn.textContent = 'В корзину';
                        }
                    }, 2000);
                }

                // Подсвечиваем варианты размеров
                sizeOptions.forEach(option => {
                    option.style.backgroundColor = '#ffcccc';
                    option.style.borderColor = '#ff0000';

                    setTimeout(() => {
                        option.style.backgroundColor = '';
                        option.style.borderColor = '';
                    }, 2000);
                });
            }
        });
    });
});
