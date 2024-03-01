let name;
let email;
let phone;
let company;
let message;

document.getElementById('sellerButton').addEventListener('click', function() {
    name = document.getElementById('name').value;
    email = document.getElementById('email').value;
    phone = document.getElementById('phone').value;
    company = document.getElementById('company').value;
    message = document.getElementById('message').value;
});
