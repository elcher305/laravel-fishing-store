// Минимальный JavaScript для валидации форм
document.addEventListener('DOMContentLoaded', function() {
    // Обработка всех форм
    const forms = document.querySelectorAll('.auth-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showFormError(this);
            }
        });
    });

    // Валидация формы
    function validateForm(form) {
        let isValid = true;
        const inputs = form.querySelectorAll('input[required]');

        inputs.forEach(input => {
            if (!input.value.trim()) {
                markAsInvalid(input, 'Это поле обязательно для заполнения');
                isValid = false;
            } else if (input.type === 'email' && !isValidEmail(input.value)) {
                markAsInvalid(input, 'Введите корректный email');
                isValid = false;
            } else {
                markAsValid(input);
            }
        });

        return isValid;
    }

    // Проверка email
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Пометка поля как невалидного
    function markAsInvalid(input, message) {
        input.classList.add('error');

        // Удаляем старое сообщение
        const oldMessage = input.parentNode.querySelector('.error-message');
        if (oldMessage) oldMessage.remove();

        // Добавляем новое сообщение
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        input.parentNode.appendChild(errorDiv);
    }

    // Пометка поля как валидного
    function markAsValid(input) {
        input.classList.remove('error');

        // Удаляем сообщение об ошибке
        const errorMessage = input.parentNode.querySelector('.error-message');
        if (errorMessage) errorMessage.remove();
    }

    // Показ ошибки формы
    function showFormError(form) {
        const submitBtn = form.querySelector('.auth-button');
        const originalText = submitBtn.textContent;

        submitBtn.textContent = 'Ошибка валидации';
        submitBtn.style.backgroundColor = '#e74c3c';

        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.style.backgroundColor = '';
        }, 2000);
    }

    // Автофокус на первом поле
    const firstInput = document.querySelector('.form-input');
    if (firstInput) {
        firstInput.focus();
    }
});
