document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitBtn = form.querySelector('.submit-btn');

    // Валидация телефона
    const phoneInput = document.getElementById('customer_phone');
    phoneInput.addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 0) {
            value = '+7 (' + value.substring(1, 4) + ') ' + value.substring(4, 7) + '-' + value.substring(7, 9) + '-' + value.substring(9, 11);
        }
        this.value = value.substring(0, 18);
    });

    // Подтверждение отправки формы
    form.addEventListener('submit', function(e) {
        // Проверяем обязательные поля
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.style.borderColor = '#e74c3c';
                field.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';
            } else {
                field.style.borderColor = '';
                field.style.boxShadow = '';
            }
        });

        if (!isValid) {
            e.preventDefault();
            alert('Пожалуйста, заполните все обязательные поля');
            return;
        }

        // Блокируем кнопку отправки
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Оформление...';

        // Можно добавить дополнительную проверку данных
        const phoneValue = phoneInput.value.replace(/\D/g, '');
        if (phoneValue.length < 11) {
            e.preventDefault();
            alert('Пожалуйста, введите корректный номер телефона');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Подтвердить заказ';
        }
    });

    // Подсчет итоговой суммы с учетом доставки
    function calculateTotal() {
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
        let shippingCost = 0;

        if (shippingMethod) {
            switch(shippingMethod.value) {
                case 'courier':
                    shippingCost = 300;
                    break;
                case 'post':
                    shippingCost = 200;
                    break;
                default:
                    shippingCost = 0;
            }
        }

        // Если нужно показывать сумму с доставкой
        // const totalWithShipping = {{ $total }} + shippingCost;
        // console.log('Сумма с доставкой:', totalWithShipping);
    }

    // Слушаем изменения способа доставки
    document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
        radio.addEventListener('change', calculateTotal);
    });

    // Инициализация расчета
    calculateTotal();
});
