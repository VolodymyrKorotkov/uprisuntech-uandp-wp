const inputs = document.querySelectorAll('.mdc-text-field__input');

// Додаємо обробник події для кожного інпуту
inputs.forEach(function (input) {
    const label = input.nextElementSibling; // Отримуємо мітку

    input.addEventListener('input', function () {
        if (input.value) {
            label.style.display = 'none';
        } else {
            label.style.display = 'block';
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const inputs = document.querySelectorAll('.mdc-text-field__input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            if (input.value.length > 0) {
                moveToNextInput(index);
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && input.value.length === 0) {
                moveToPreviousInput(index);
            }
        });
    });

    // Обработчик вставки данных для первого инпута
    inputs[0].addEventListener('paste', (e) => {
        // Предотвратить стандартное поведение вставки
        e.preventDefault();

        // Получить текст из буфера обмена и разделить его на символы
        const pastedData = e.clipboardData.getData('text');
        const characters = pastedData.split('');

        // Распределить символы по инпутам
        characters.forEach((char, index) => {
            if (index < inputs.length) {
                inputs[index].value = char;
            }
        });
jQuery('.mdc-floating-label').hide();
        // Фокус на последний заполненный инпут или следующий, если доступен
        const focusIndex = characters.length < inputs.length ? characters.length : inputs.length - 1;
        inputs[focusIndex].focus();
    });

    function moveToNextInput(index) {
        if (index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    }

    function moveToPreviousInput(index) {
        if (index > 0) {
            inputs[index - 1].focus();
        }
    }
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.confirm-email__form-button').addEventListener('click', function() {
        // Собираем значения из всех инпутов
        const inputs = document.querySelectorAll('.mdc-text-field__input');
        let activationKey = '';
        inputs.forEach(input => {
            activationKey += input.value;
        });

        console.log('activationKey', activationKey);
        // Проверка, что ключ активации состоит из 6 цифр
        if (activationKey.length === 6 && /^[0-9]+$/.test(activationKey)) {
            $('input.activation_key').val(activationKey)
        } else {
            alert('Пожалуйста, введите 6 цифр');
        }
    });
});
let counterElement = document.getElementById('counter');
let countdown = parseInt(counterElement.textContent);

let interval = setInterval(() => {
    countdown -= 1;
    counterElement.textContent = countdown;

    if (countdown <= 0) {
        clearInterval(interval);
        let linkElement = document.createElement('a');
        linkElement.href = "/dashboard";
        linkElement.textContent = "Resend email";
        let email_resend = document.querySelector('.confirm-email__resend');
        jQuery(email_resend).html(linkElement);

    }
}, 1000);
