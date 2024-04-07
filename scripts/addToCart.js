$(document).ready(function() {
    $('.add-to-cart-btn').click(function() {
        var productId = $(this).attr('data-product-id');
        var productName = $(this).attr('data-product-name');
        var productPrice = $(this).attr('data-product-price');

        $.ajax({
            type: 'POST',
            url: './php/add_to_cart.php',
            data: {
                product_id: productId,
                product_name: productName,
                product_price: productPrice
            },
            success: function(response) {
                alert(response);
            }
        });
    });
});