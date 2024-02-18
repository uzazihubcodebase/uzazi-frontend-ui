<?php
define( 'TEMPPATH', get_bloginfo('stylesheet_directory'));
define( 'IMAGES', TEMPPATH. "/images");
define( 'JS', TEMPPATH. "/js");

/**
 * OceanWP Child Theme Functions
 *
 * When running a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions will be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {

	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update the theme).
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );

	// Load the stylesheet.
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	
}

add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );


function enqueue_custom_scripts() {

    // Enqueue jQuery
    wp_enqueue_script('jquery');
    // Enqueue your custom script
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
    // Pass the Ajax URL to the script
    wp_localize_script('custom-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


function user_cart_counter() {
    // Get the cart contents count
    $cart_count = WC()->cart->get_cart_contents_count();
    // Send the cart count as the Ajax response
    return $cart_count;
}

function get_cart_counter() {
    // Get the cart contents count
    $cart_count = WC()->cart->get_cart_contents_count();
    echo $cart_count;
    die();
}

// Hook for the Ajax action
add_action('wp_ajax_get_cart_counter', 'get_cart_counter');
add_action('wp_ajax_nopriv_get_cart_counter', 'get_cart_counter');



function is_user_loggedin() {
    if (is_user_logged_in()) {
        // Perform actions for logged-in users
        echo json_encode(array('status' => 'success', 'message' => 'User is logged in.'));
    } else {
        // Send a response indicating that the user is not logged in
        echo json_encode(array('status' => 'error', 'message' => 'User is not logged in.'));
    }

    wp_die(); // Always include this to terminate the script properly
}

add_action('wp_ajax_my_ajax_action', 'is_user_loggedin');
add_action('wp_ajax_nopriv_my_ajax_action', 'is_user_loggedin');


function add_to_cart() {

        header("Content-type: application/json; charset=utf-8");
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1; 
        $product = wc_get_product($product_id);
        if ( $product !== "" ) {

            // Perform actions to add product to the cart
            WC()->cart->add_to_cart($product_id, $quantity);

            // Get the cart count
            $cart_count = WC()->cart->get_cart_contents_count();

            // Send a response back with success and cart count
            echo json_encode(array('status' => true, 'cart_count' => $cart_count));
            exit;
       
        } else {
            
             echo json_encode(array('status' => false, 'message' => 'Invalid product ID'));
             exit;
        }
        // Don't forget to stop execution afterward.
        wp_die();
}
add_action('wp_ajax_add_to_cart', 'add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart');







// Function to remove a product from favorites
function remove_product_from_favorites($product_id) {
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'favorites', true);

    if (($key = array_search($product_id, $favorites)) !== false) {
        unset($favorites[$key]);
    }

    update_user_meta($user_id, 'favorites', $favorites);
}

// Function to check if a product is in favorites
function is_product_in_favorites($product_id) {
    $user_id = get_current_user_id();
    $favorites = get_user_meta($user_id, 'favorites', true);
    return is_array($favorites) && in_array($product_id, $favorites);
}

function add_to_favorites_ajax() { 

    try{
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $product    = wc_get_product($product_id);



        if ($product !== "" ) {

            if(!is_user_logged_in()){
              echo json_encode(array('success' => false, 
                                     'message' => 'Login to add to favorites list', 'condition' => ''));
              exit;
            }

            // Add product to favorites
            $user_id = get_current_user_id();
            // Check if the product is already in favorites
            $havemeta = get_user_meta($user_id, 'favorites', false);

            if (is_product_in_favorites($product_id)) {

                // If it's in favorites, remove it
                remove_product_from_favorites($product_id);
                echo json_encode(array('success' => true, 'message' => 'Product removed from favorites.', 
                                       'condition' => 'removed'));
                exit;
            }
        
                
            $havemeta = get_user_meta($user_id, 'favorites', false);    
            if($havemeta){
                
               $favorites = get_user_meta($user_id, 'favorites', true);
               array_push($favorites, $product_id);
               // Update user meta with the new favorites list
               update_user_meta($user_id, 'favorites', $favorites);
            } else {
            
               $favorites = array();
               array_push($favorites, $product_id);
               add_user_meta($user_id, 'favorites', $favorites);
            } 

            // Send a response back with success
            echo json_encode(array('success' => true, 'condition' => 'added'));
            exit;


        } else {

            echo json_encode(array('success' => false, 'message' => 'Invalid product ID', 'condition' => ''));
            exit;
        }


    } catch (Exception $e) {
        // Handle the exception
        // You can log the error, display a message, or perform any other actions
        error_log('Exception caught: ' . $e->getMessage());
        // Display a user-friendly error message
        echo 'An error occurred. Please try again later.';
    }

}
add_action('wp_ajax_add_to_favorites_ajax', 'add_to_favorites_ajax');
add_action('wp_ajax_nopriv_add_to_favorites_ajax', 'add_to_favorites_ajax'); // For non-logged-in users


function get_favorite_products() {

    // Get current user ID
    $user_id = get_current_user_id();

    // Get user's favorite products
    $favorites = get_user_meta($user_id, 'favorites', false);
    $favorites = is_array($favorites) ? $favorites : array();

    return $favorites;
}
add_action('wp_ajax_add_to_favorites', 'get_favorite_products');
add_action('wp_ajax_nopriv_add_to_favorites', 'get_favorite_products'); 















// Function to remove a product from favorites
function remove_product_from_compare_products($product_id) {
    $user_id = get_current_user_id();
    $compare_products = get_user_meta($user_id, 'compare_products', true);

    if (($key = array_search($product_id, $favorites)) !== false) {
        unset($compare_products[$key]);
    }

    update_user_meta($user_id, 'compare_products', $favorites);
}

// Function to check if a product is in favorites
function is_product_in_compare_products($product_id) {
    $user_id = get_current_user_id();
    $compare_products = get_user_meta($user_id, 'compare_products', true);
    return is_array($compare_products) && in_array($product_id, $compare_products);
}

function add_to_compare_products_ajax() { 

    try{
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $product    = wc_get_product($product_id);



        if ($product !== "" ) {

            if(!is_user_logged_in()){
              echo json_encode(array('success' => false, 
                                     'message' => 'Login to add to product compare list', 'condition' => ''));
              exit;
            }

            // Add product to compare_products
            $user_id = get_current_user_id();
            // Check if the product is already in compare products
            $havemeta = get_user_meta($user_id, 'compare_products', false);

            if (is_product_in_compare_products($product_id)) {

                // If it's in compare products, remove it
                remove_product_from_compare_products($product_id);
                echo json_encode(array('success' => true, 
                                       'message' => 'Product removed from compare products.', 
                                       'condition' => 'removed'));
                exit;
            }
        
                
            $havemeta = get_user_meta($user_id, 'compare_products', false);    
            if($havemeta){
                
               $compare_products = get_user_meta($user_id, 'compare_products', true);
               array_push($compare_products, $product_id);
               // Update user meta with the new favorites list
               update_user_meta($user_id, 'compare_products', $compare_products);
            } else {
            
               $compare_products = array();
               array_push($compare_products, $product_id);
               add_user_meta($user_id, 'compare_products', $compare_products);
            } 

            // Send a response back with success
            echo json_encode(array('success' => true, 'condition' => 'added'));
            exit;


        } else {

            echo json_encode(array('success' => false, 'message' => 'Invalid product ID', 'condition' => ''));
            exit;
        }


    } catch (Exception $e) {
        // Handle the exception
        // You can log the error, display a message, or perform any other actions
        error_log('Exception caught: ' . $e->getMessage());
        // Display a user-friendly error message
        echo 'An error occurred. Please try again later.';
    }

}
add_action('wp_ajax_add_to_compare_products_ajax', 'add_to_compare_products_ajax');
add_action('wp_ajax_nopriv_add_to_compare_products_ajax', 'add_to_compare_products_ajax'); 
// For non-logged-in users


function get_compare_products() {

    // Get current user ID
    $user_id = get_current_user_id();

    // Get user's favorite products
    $compare_products = get_user_meta($user_id, 'compare_products', false);
    $compare_products = is_array($compare_products) ? $compare_products : array();

    return $compare_products;
}
add_action('wp_ajax_add_to_compare_products', 'get_compare_products');
add_action('wp_ajax_nopriv_add_to_compare_products', 'get_compare_products'); 





function get_product_details() {
    $product    = wc_get_product($product_id);
    if ($product === "" ) {

      echo json_encode(array('success' => false, 'product' => ''));
      exit;
    }

      echo json_encode(array('success' => true, 'product' => $product));
      exit;
}
add_action('wp_ajax_get_product_details', 'get_product_details');
add_action('wp_ajax_nopriv_get_product_details', 'get_product_details'); 






///  get the cart details here 
function get_cart_details_ajax_handler() {
    
    // Ensure that WooCommerce is active
    if (class_exists('WooCommerce')) {
        // Get cart details
        $cart_details = WC()->cart->get_cart();

        // Process and send the cart details as a response
        $formatted_cart_details = array();

        foreach ($cart_details as $cart_item_key => $cart_item) {
            $product_id = $cart_item['product_id'];
            $product_name = get_the_title($product_id);
            $quantity = $cart_item['quantity'];
            $price = wc_price(WC()->cart->get_product_price($product_id));
            
            $formatted_cart_details[] = array(
                'product_id' => $product_id,
                'product_name' => $product_name,
                'quantity' => $quantity,
                'price' => $price,
            );
        }

        echo json_encode(array('success' => true, 'cart' => $formatted_cart_details));
        exit;

    } else {

        echo json_encode(array('success' => true, 'cart' => 'WooCommerce is not active.'));
        exit;
    }
}

// Hook for the AJAX action
add_action('wp_ajax_get_cart_details', 'get_cart_details_ajax_handler');
add_action('wp_ajax_nopriv_get_cart_details', 'get_cart_details_ajax_handler');




// Assuming you're working within a WordPress theme or plugin
// function display_cart_contents() {
//     // Get the cart contents
//     $cart_contents = WC()->cart->get_cart();

//     // Check if the cart is not empty
//     if (!empty($cart_contents)) {
//         echo '<ul>';
//         // Loop through each item in the cart
//         foreach ($cart_contents as $cart_item_key => $cart_item) {
//             // Get product details
//             $product_id = $cart_item['product_id'];
//             $product_name = get_the_title($product_id);
//             $quantity = $cart_item['quantity'];
//             $price = wc_price($cart_item['data']->get_price());
//             // Display product information
//             echo '<li>';
//             echo '<strong>' . esc_html($product_name) . '</strong> - Quantity: ' . esc_html($quantity) . ', Price: ' . esc_html($price);
//             echo '</li>';
//         }

//         echo '</ul>';
//     } else {
//         echo 'Your cart is empty.';
//     }
// }





// Hook for the Ajax action
// add_action('wp_ajax_get_cart_counter', 'display_cart_contents');
// add_action('wp_ajax_nopriv_get_cart_counter', 'display_cart_contents');




// ///  return the product categories 
// function get_best_categories($counting = 6) {
//     // Get the terms (categories) from the taxonomy 'category'
//     $categories = get_categories(array(
//         'orderby' => 'count', 
//         'order'   => 'DESC',    
//         'number'  => $counting          
//     ));
//     return $categories;
// }

// // Hook for the Ajax action
// add_action('wp_ajax_get_cart_counter', 'get_best_categories');
// add_action('wp_ajax_nopriv_get_cart_counter', 'get_best_categories');




// function display_cart_contents() {
//     // Get the cart contents
//     $cart_contents = WC()->cart->get_cart();

//     // Check if the cart is not empty
//     if (!empty($cart_contents)) {
//         echo '<ul>';
//         // Loop through each item in the cart
//         foreach ($cart_contents as $cart_item_key => $cart_item) {
//             // Get product details
//             $product_id = $cart_item['product_id'];
//             $product_name = get_the_title($product_id);
//             $quantity = $cart_item['quantity'];
//             $price = wc_price($cart_item['data']->get_price());
//             // Display product information
//             echo '<li>';
//             echo '<strong>' . esc_html($product_name) . '</strong> - Quantity: ' . esc_html($quantity) . ', Price: ' . esc_html($price);
//             echo '</li>';
//         }

//         echo '</ul>';
//     } else {
//         echo 'Your cart is empty.';
//     }
// }

// // Hook for the Ajax action
// add_action('wp_ajax_get_cart_counter', 'display_cart_contents');
// add_action('wp_ajax_nopriv_get_cart_counter', 'display_cart_contents');

