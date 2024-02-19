//submit button in contact form
let names; 
let emails;
let messages;
document.getElementById('submitButton').addEventListener('click', function() {
    names = document.getElementById('name').value;
    emails = document.getElementById('email').value;
    messages = document.getElementById('message').value;
    alert('Thank you for your message!');
});