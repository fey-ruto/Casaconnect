document.addEventListener('DOMContentLoaded', function () {
    const firstNameInput = document.getElementById('signup-firstname');
    const lastNameInput = document.getElementById('signup-lastname');
    const emailInput = document.getElementById('signup-email');
    const passwordInput = document.getElementById('signup-password');
    const confirmPasswordInput = document.getElementById('signup-confirm-password');
    const submitButton = document.querySelector('.btn');

    function validateField(input, nextInput, validator = () => true) {
        input.addEventListener('input', function () {
            if (input.value.trim() && validator(input.value)) {
                nextInput.disabled = false;
            } else {
                nextInput.value = ''; // Clearing the next input
                nextInput.disabled = true;
            }
        });
    }

    function validatePassword(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return regex.test(password);
    }

    lastNameInput.disabled = true;
    emailInput.disabled = true;
    passwordInput.disabled = true;
    confirmPasswordInput.disabled = true;
    submitButton.disabled = true;

    validateField(firstNameInput, lastNameInput);
    validateField(lastNameInput, emailInput);
    validateField(emailInput, passwordInput, (value) => /\S+@\S+\.\S+/.test(value));
    validateField(passwordInput, confirmPasswordInput, validatePassword);

    confirmPasswordInput.addEventListener('input', function () {
        if (confirmPasswordInput.value === passwordInput.value && validatePassword(passwordInput.value)) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    });
});
