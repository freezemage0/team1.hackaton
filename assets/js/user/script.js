;(function() {

    $('#register').submit(() => {
        let passConfirm= document.querySelector('#reg-pass-conf');

        let passConfirmValue = passConfirm.value;
        let passValue = document.querySelector('#reg-pass').value;

        if (passConfirmValue && passConfirmValue.length > 0 && passValue != passConfirmValue) {
            passConfirm.classList.add('is-invalid');
            return false;
        } else {
            passConfirm.classList.remove('is-invalid');
        }
    });

})();