<?php
/**
 * Template Name: Custom Shop Page
 */

get_header();

// Fetch all product colors and sizes
$colors = get_terms([
    'taxonomy' => 'pa_color',
    'hide_empty' => true,
]);

$sizes = get_terms([
    'taxonomy' => 'pa_size',
    'hide_empty' => true,
]);

?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
        <div class="d-inline-flex">
            <?php
            if (function_exists('woocommerce_breadcrumb')) {
                woocommerce_breadcrumb(array(
                    'wrap_before' => '<p class="m-0">',
                    'wrap_after'  => '</p>',
                    'delimiter'   => '<p class="m-0 px-2">-</p>',
                    'before'      => '',
                    'after'       => ''
                ));
            }
            ?>
        </div>
    </div>
</div>

<!-- Page Header End -->

<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-12">
            <!-- Price Filter Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                <form id="price-filter-form">
                    <!-- Add your price filters here -->
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input price-filter" checked id="price-all">
                        <label class="custom-control-label" for="price-all">All Price</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input price-filter" id="price-1" data-min="0" data-max="100">
                        <label class="custom-control-label" for="price-1">$0 - $100</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input price-filter" id="price-2" data-min="100" data-max="200">
                        <label class="custom-control-label" for="price-2">$100-$200</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input price-filter" id="price-3" data-min="200" data-max="300">
                        <label class="custom-control-label" for="price-3">$200-$300</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input price-filter" id="price-4" data-min="300" data-max="400">
                        <label class="custom-control-label" for="price-4">$300-$400</label>
                    </div>
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input price-filter" id="price-5" data-min="400" data-max="500">
                        <label class="custom-control-label" for="price-5">$400-$500</label>
                    </div>
                    <!-- Add more price filters as needed -->
                </form>
            </div>
            <!-- Price Filter End -->

            <!-- Color Filter Start -->
            <div class="border-bottom mb-4 pb-4">
                <h5 class="font-weight-semi-bold mb-4">Filter by color</h5>
                <form id="color-filter-form">
                    <!-- Add your color filters here -->
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input color-filter" checked id="color-all">
                        <label class="custom-control-label" for="color-all">All Color</label>
                    </div>
                    <?php foreach ($colors as $color): ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input color-filter" id="color-<?php echo esc_attr($color->slug); ?>">
                            <label class="custom-control-label" for="color-<?php echo esc_attr($color->slug); ?>"><?php echo esc_html($color->name); ?></label>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
            <!-- Color Filter End -->

            <!-- Size Filter Start -->
            <div class="mb-5">
                <h5 class="font-weight-semi-bold mb-4">Filter by size</h5>
                <form id="size-filter-form">
                    <!-- Add your size filters here -->
                    <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                        <input type="checkbox" class="custom-control-input size-filter" checked id="size-all">
                        <label class="custom-control-label" for="size-all">All Size</label>
                    </div>
                    <?php foreach ($sizes as $size): ?>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input size-filter" id="size-<?php echo esc_attr($size->slug); ?>">
                            <label class="custom-control-label" for="size-<?php echo esc_attr($size->slug); ?>"><?php echo esc_html($size->name); ?></label>
                        </div>
                    <?php endforeach; ?>
                </form>
            </div>
            <!-- Size Filter End -->
        </div>
        <!-- Shop Sidebar End -->

        <!-- Products Start -->
        <div class="col-lg-9 col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <label for="sort-select" class="mr-2">Sort by:</label>
                    <select id="sort-select" class="custom-select">
                        <option value="latest">Latest</option>
                        <option value="rating">Best Rating</option>
                        <option value="popularity">Popularity</option>
                    </select>
                </div>
            </div>
            <div class="row pb-3" id="product-list">
                <!-- Products will be dynamically loaded here -->
            </div>
        </div>
        <!-- Products End -->
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.add-to-cart-button').on('click', function(e) {
            e.preventDefault(); // Prevent default action of the anchor tag

            // Example: Retrieve product information from the DOM or data attributes
            var productTitle = $(this).closest('.card').find('.card-title').text();
            var productPrice = $(this).closest('.card').find('.product-price').text();

            // Example: Add the product to the cart (you would implement your own logic here)
            addToCart(productTitle, productPrice);

            // Optional: Provide feedback to the user (e.g., alert or toast notification)
            alert('Product added to cart: ' + productTitle);
        });

        function addToCart(title, price) {
            // Implement your cart addition logic here, such as using localStorage or making an API call
            // Example using localStorage:
            var cart = JSON.parse(localStorage.getItem('cart')) || [];
            var item = { title: title, price: price };
            cart.push(item);
            localStorage.setItem('cart', JSON.stringify(cart));
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const priceCheckboxes = document.querySelectorAll('.price-filter');
    const colorCheckboxes = document.querySelectorAll('.color-filter');
    const sizeCheckboxes = document.querySelectorAll('.size-filter');
    const sortSelect = document.getElementById('sort-select');

    priceCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterProducts));
    colorCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterProducts));
    sizeCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterProducts));
    sortSelect.addEventListener('change', filterProducts);

    function filterProducts() {
        const selectedPrices = Array.from(priceCheckboxes)
            .filter(checkbox => checkbox.checked && checkbox.id !== 'price-all')
            .map(checkbox => ({
                min: parseFloat(checkbox.getAttribute('data-min')),
                max: parseFloat(checkbox.getAttribute('data-max'))
            }));

        const selectedColors = Array.from(colorCheckboxes)
            .filter(checkbox => checkbox.checked && checkbox.id !== 'color-all')
            .map(checkbox => checkbox.id.replace('color-', ''));

        const selectedSizes = Array.from(sizeCheckboxes)
            .filter(checkbox => checkbox.checked && checkbox.id !== 'size-all')
            .map(checkbox => checkbox.id.replace('size-', ''));

        const selectedSort = sortSelect.value;

        const filterData = {
            prices: selectedPrices,
            colors: selectedColors,
            sizes: selectedSizes,
            sort: selectedSort
        };

        fetchProducts(filterData);
    }

    function fetchProducts(filterData) {
        fetch('<?php echo admin_url("admin-ajax.php?action=filter_products"); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(filterData)
        })
        .then(response => response.json())
        .then(products => {
            displayProducts(products);
        });
    }

    function displayProducts(products) {
        const productList = document.getElementById('product-list');
        productList.innerHTML = products.map(product => {
            // Check if product is variable and has variations
            if (product.type === 'variable' && product.variations) {
                return product.variations.map(variation => `
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="${variation.image.src}" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">${variation.name}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>${variation.price_html}</h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="${variation.permalink}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <a href="#" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                `).join('');
            } else {
                // Display simple product
                return `
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="${product.image}" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">${product.name}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>${product.price}</h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="${product.permalink}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <a href="#" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                `;
            }
        }).join('');
    }

    filterProducts(); // Initial load
});
</script>

<?php
get_footer();
?>
