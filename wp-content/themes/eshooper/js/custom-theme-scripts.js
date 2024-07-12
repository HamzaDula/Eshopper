jQuery(document).ready(function($) {
    // Handle category link clicks
    $('.category-link').click(function(e) {
        e.preventDefault(); // Prevent default link behavior

        var category = $(this).data('category');

        // AJAX request to fetch products based on category
        $.ajax({
            url: customThemeAjax.ajaxUrl,
            type: 'GET',
            data: { 
                action: 'custom_fetch_products_by_category',
                category: category 
            },
            success: function(response) {
                displayProducts(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching products:', error);
            }
        });
    });

    // Function to display products in the product-display container
    function displayProducts(products) {
        var productDisplay = $('#product-display');
        productDisplay.empty(); // Clear previous products

        // Loop through products and create HTML for each product
        products.forEach(function(product) {
            var productHtml = '<div class="col-lg-3 col-md-4 col-sm-6">' +
                                '<div class="card">' +
                                    '<div class="card-body">' +
                                        '<h5 class="card-title">' + product.name + '</h5>' +
                                        '<p class="card-text">' + product.description + '</p>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';
            productDisplay.append(productHtml);
        });
    }
});
