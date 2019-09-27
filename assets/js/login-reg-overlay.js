const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const signUpMobileButton = document.getElementById('signUpMobile');
const signInMobileButton = document.getElementById('signInMobile');
const container = document.getElementById('form-container');

signUpButton.addEventListener('click', () => {
    container.classList.add('right-panel-active');
});

signInButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
});

signUpMobileButton.addEventListener('click', () => {
    container.classList.add('right-panel-active');
});

signInMobileButton.addEventListener('click', () => {
    container.classList.remove('right-panel-active');
});

$(document).ready(function() {
    setTimeout(function() {
        $(".alert").alert('close');
    }, 1500);
});
