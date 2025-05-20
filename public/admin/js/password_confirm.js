document.addEventListener('DOMContentLoaded', function () {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirmation');
    const help = document.getElementById('passwordHelp');

    function checkPasswordsMatch() {
        if (password.value !== confirm.value) {
            confirm.setCustomValidity('Passwords do not match');
            help.style.display = 'block';
        } else {
            confirm.setCustomValidity('');
            help.style.display = 'none';
        }
    }

    password.addEventListener('input', checkPasswordsMatch);
    confirm.addEventListener('input', checkPasswordsMatch);
});
