//submit button in contact form
let names; 
let emails;
let phone;
let messages;
document.getElementById('submitButton').addEventListener('click', function() {
    names = document.getElementById('name').value;
    emails = document.getElementById('email').value;
    phone = document.getElementById('phone').value;
    messages = document.getElementById('message').value;
});