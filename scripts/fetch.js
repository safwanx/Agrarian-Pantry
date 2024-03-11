fetch('fetch_products.php')
            .then(response => response.json())
            .then(products => {
                let productsDiv = document.getElementById('products');
                products.forEach(product => {
                    let productDiv = document.createElement('div');
                    productDiv.innerHTML = `
                        <h2>${product.name}</h2>
                        <p>${product.description}</p>
                        <p>Price: $${product.price}</p>
                        <p>Quantity: ${product.quantity}</p>
                        <img src="${product.image_url}" alt="Product Image" style="max-width: 200px; max-height: 200px;">
                    `;
                    productsDiv.appendChild(productDiv);
                });
            })
            .catch(error => console.error('Error:', error));