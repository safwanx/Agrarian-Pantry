document.addEventListener("DOMContentLoaded", function() {
    const signInButton = document.getElementById('sign-in-1');
    const signUpButton = document.getElementById('sign-up-1');

    const signInContainer = document.querySelector('.sign-in-container');
    const signUpContainer = document.querySelector('.sign-up-container');

    signUpContainer.style.display = 'none';

    signInButton.addEventListener('click', function() {
        signInContainer.style.display = 'block';
        signUpContainer.style.display = 'none';
    });
    
    signUpButton.addEventListener('click', function() {
        signInContainer.style.display = 'none';
        signUpContainer.style.display = 'block';
    });

});
