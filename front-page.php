<?php  get_header(); ?>

       <section class="discount-coupon py-0 my-1 py-md-1 my-md-1">
          <div class="container">
            <div class="bg-gray coupon position-relative p-0">
              <?php
                    // Assuming you want to display the MetaSlider with ID 1381
                    $slider_shortcode = '[metaslider id="1381"]';
                    // Use do_shortcode to render the MetaSlider
                    echo do_shortcode($slider_shortcode);
              ?>

            </div>
          </div>
        </section>
        <?php
          // Get WooCommerce product categories
          $product_categories = get_terms('product_cat', array(
                'hide_empty' => true,
                'number' => 6
            ));

          // Check if there are categories
          if (!empty($product_categories) && !is_wp_error($product_categories)) { ?>

       <section id="featured-products" class="product-store">
        <div class="container-md">
          <div class="display-header d-flex align-items-center justify-content-between">
            <h2 class="section-title text-uppercase">Top categories</h2>
            <div class="btn-right">
              <a href="#" class="d-inline-block text-uppercase fw-bold btn-read-more">
                See all 
                <img src="<?=IMAGES?>/arrow-right.png" class="see-all-icon" alt="all" />
              </a>
            </div>
          </div>
          <div class="product-content padding-small section-width-medium">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5  d-flex justify-content-between align-items-center">
             
            <?php  
              foreach ($product_categories as $category) { 
                  // Get the category image ID
                  $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                  // Get the image URL
                  $image_url = wp_get_attachment_image_url($thumbnail_id, 'full'); ?>


                  <div class="col col-md-4 mb-2 mb-2 width-33">
                    <div class="product-card position-relative">
                      <div class="card-img category-blocking-one">

                       <figure class="category-image-figure">
                           <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_html($category->name); ?>" class="category-image img-fluid" />
                       </figure>    
                        <div class="card-detail d-flex justify-content-between align-items-center mt-2 category-blocking-details" >

                          <h3 class="card-title fs-6 fw-normal m-0">
                            <a href="<?php echo get_term_link($category); ?>">
                             <?php echo  esc_html($category->name); ?> 
                          </a> </h3>
                          <img src="<?=IMAGES?>/visible.png" class="see-all-icon" alt="all" />
                        </div>
                      </div>              
                    </div>
                  </div> 

                <?php
                  } ?>

                </div>
              </div>
            </div>
          </section>
  <?php

          }

  ?>
          

  <section id="latest-products" class="product-store py-1 my-0 py-md-1 my-md-1 pt-0">
    <div class="container-md">
      <div class="display-header d-flex align-items-center justify-content-between">
        <h2 class="section-title text-uppercase">Top Sellers</h2>
        <div class="btn-right">
          <a href="<?php echo get_site_url();?>/shop" class="d-inline-block text-uppercase fw-bold btn-read-more">
            See all 
            <img src="<?=IMAGES?>/arrow-right.png" class="see-all-icon" alt="all" />
          </a>
        </div>
      </div>
      <div class="product-content padding-small section-width-medium">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">

          <?php
                
              // Get WooCommerce products including product images
              $args = array(
                    'limit' => 10,  // Change the limit as needed
                    'status' => 'publish',
                    // 'orderby' => 'sales',
                    'meta_key'       => 'total_sales',
                    'orderby'        => 'meta_value_num',
                    'order'          => 'DESC',
              );
              $products = wc_get_products($args);  

              foreach ($products as $product) {
                $product_id = $product->get_id();
                $product_name = $product->get_name();
                $product_image_id = $product->get_image_id();
                $product_image_url = wp_get_attachment_image_url($product_image_id, 'full');


                $product_price = $product->get_price();
                $product_regular_price = $product->get_regular_price();
                $product_url = get_permalink($product_id);
          ?>
          


          <div class="col mb-2 mb-2 width-20">
            <div class="product-card position-relative">

              <div class="card-img position-relative">

                <a href="<?php echo $product_url; ?>"> 
                  <figure class="product-image-figure">
                    <img src="<?php echo  $product_image_url; ?>" alt="<?php echo $product_name; ?>" 
                         class="product-image img-fluid">
                  </figure> 
                </a>  

                <div class="cart-concern position-absolute">
                  <div class="product-tool-bar">
                    <p> 
                      <span class="shopping-carriage favorite-icon shopping-carriage-like"
                          onClick="$webAppCore.favorites.add('.cart-counter',
                                                     '<?php echo $product_id;?>',
                                                     'get_cart_counter',
                                                     '',
                                                     '.submitting-favorite-best-<?php echo $product_id;?>', 
                                                     '<?=IMAGES?>/love.png', 
                                                     '<?=IMAGES?>/loading.gif', 
                                                     '<?=IMAGES?>/heart-cover.png', 
                                                     '',
                                                     'image');">  
                      <img src="<?=IMAGES?>/love.png" alt="favorite" class="smaller-img-20 submitting-favorite-best-<?php echo $product_id;?>"/>
                     </span>
                   </p>   
                   <p>
                     <span class="shopping-carriage favorite-icon shopping-carriage-like"
                          onClick="$webAppCore.productCompare.add('.cart-counter',
                                                     '<?php echo $product_id;?>',
                                                     'get_cart_counter',
                                                     '',
                                                     '.submitting-compare-best-<?php echo $product_id;?>', 
                                                     '<?=IMAGES?>/compare.png', 
                                                     '<?=IMAGES?>/loading.gif', 
                                                     '<?=IMAGES?>/compare-added.png', 
                                                     '',
                                                     'image');">  
                      <img src="<?=IMAGES?>/compare.png" alt="favorite" class="submitting-compare-best-<?php echo $product_id;?>"/>
                    </span>
                  </p>  
                  <p>
                     <span class="shopping-carriage favorite-icon shopping-carriage-like"
                          onClick="$webAppCore.productView.add('.cart-counter',
                                                     '<?php echo $product_id;?>',
                                                     'get_cart_counter',
                                                     '',
                                                     '.submitting-view-best-<?php echo $product_id;?>', 
                                                     '<?=IMAGES?>/view.png', 
                                                     '<?=IMAGES?>/loading.gif', 
                                                     '<?=IMAGES?>/view.png', 
                                                     '',
                                                     'image');">  
                      <img src="<?=IMAGES?>/view.png" alt="favorite" class="submitting-view-best-<?php echo $product_id;?>"/>
                    </span>
                  </p>  
                 </div>    
                </div>
                <!-- cart-concern -->
              </div>
              

              <div class="card-detail align-items-center mt-3 card-detail-product">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="<?php echo $product_url; ?>"><?php echo $product_name; ?></a>
                </h3>
                <div class="d-flex justify-content-between align-items-center clearfix group pricing"> 
                  <h3 class="card-sub-title fs-6 fw-normal">
                    <span class="card-price fw-bold"><?php echo wc_price($product_price); ?></span>
                  </h3>
                  <div class="shopping-carriage shopping-carriage-buy buying-icon float-right"
                       onClick="$webAppCore.cart.add('.cart-counter',
                                                     '<?php echo $product_id;?>',
                                                     'get_cart_counter',
                                                     '',
                                                     '.submitting-btn-best-<?php echo $product_id;?>', 
                                                     '<?=IMAGES?>/shopping-bag.png', 
                                                     '<?=IMAGES?>/loading.gif', 
                                                     '<?=IMAGES?>/next.png', 
                                                     '<?php echo get_site_url();?>/cart',
                                                     'image');">
                      <img src="<?=IMAGES?>/shopping-bag.png" 
                           class="submitting-btn-best-<?php echo $product_id;?>" alt="favorite"/>

                  </div>  
                </div>  
              </div>


            </div>
          </div>

          <?php  } ?>
          



        </div>
      </div>
    </div>
  </section>



   <section id="latest-products" class="product-store py-1 my-1 py-md-1 my-md-1 pt-0">
    <div class="container-md">
      <div class="display-header d-flex align-items-center justify-content-between">
        <h2 class="section-title text-uppercase">New Arrivals</h2>
        <div class="btn-right">
          <a href="<?php echo get_site_url();?>/shop" class="d-inline-block text-uppercase fw-bold btn-read-more">
            See all 
            <img src="<?=IMAGES?>/arrow-right.png" class="see-all-icon" alt="all" />
          </a>
        </div>
      </div>
      <div class="product-content padding-small section-width-medium">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
          
        <?php
                
              // Get WooCommerce products including product images
              $args = array(
                    'limit' => 15,  // Change the limit as needed
                    'status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
              );
              $products = wc_get_products($args);  
              foreach ($products as $product) {
                $product_id = $product->get_id();
                $product_name = $product->get_name();
                $product_image_id = $product->get_image_id();
                $product_image_url = wp_get_attachment_image_url($product_image_id, 'full');

                $product_price = $product->get_price();
                $product_regular_price = $product->get_regular_price();
                $product_url = get_permalink($product_id);

          ?>
          
          <div class="col mb-2 mb-2 width-20">
            <div class="product-card position-relative">


              <div class="card-img position-relative">
              
                <a href="<?php echo $product_url; ?>"> 
                  <figure class="product-image-figure">
                    <img src="<?php echo  $product_image_url; ?>" alt="<?php echo $product_name; ?>" 
                         class="product-image img-fluid">
                  </figure> 
                </a> 

                <div class="cart-concern position-absolute">

                   <div class="product-tool-bar">

                    <p>  
                      <span class="shopping-carriage favorite-icon shopping-carriage-like"
                            onclick="$webAppCore.favorites.add('.cart-counter',
                                                       '<?php echo $product_id;?>',
                                                       'get_cart_counter',
                                                       '',
                                                       '.submitting-favorite-new-<?php echo $product_id;?>', 
                                                       '<?=IMAGES?>/love.png', 
                                                       '<?=IMAGES?>/loading.gif', 
                                                       '<?=IMAGES?>/heart-cover.png', 
                                                       '',
                                                       'image');">  
                        <img src="<?=IMAGES?>/love.png" alt="favorite" class="smaller-img-20 submitting-favorite-new-<?php echo $product_id;?>"/>
                      </span>
                    </p>  


                    <p>  
                      <span class="shopping-carriage favorite-icon shopping-carriage-like"
                            onclick="$webAppCore.productCompare.add('.cart-counter',
                                                       '<?php echo $product_id;?>',
                                                       'get_cart_counter',
                                                       '',
                                                       '.submitting-compare-new-<?php echo $product_id;?>', 
                                                       '<?=IMAGES?>/compare.png', 
                                                       '<?=IMAGES?>/loading.gif', 
                                                       '<?=IMAGES?>/compare-added.png', 
                                                       '',
                                                       'image');">  
                        <img src="<?=IMAGES?>/compare.png" alt="favorite" class="submitting-compare-new-<?php echo $product_id;?>"/>
                      </span>
                    </p>  


                    <p>  
                      <span class="shopping-carriage favorite-icon shopping-carriage-like"
                            onclick="$webAppCore.productView.add('.cart-counter',
                                                       '<?php echo $product_id;?>',
                                                       'get_cart_counter',
                                                       '',
                                                       '.submitting-view-new-<?php echo $product_id;?>', 
                                                       '<?=IMAGES?>/view.png', 
                                                       '<?=IMAGES?>/loading.gif', 
                                                       '<?=IMAGES?>/view.png', 
                                                       '',
                                                       'image');">  
                        <img src="<?=IMAGES?>/view.png" alt="favorite" class="submitting-view-new-<?php echo $product_id;?>"/>
                      </span>
                    </p>  
                  </div>
                </div>

                <!-- cart-concern -->
              </div>

              <div class="card-detail align-items-center mt-2 card-detail-product">
                <h3 class="card-title fs-6 fw-normal m-0">
                  <a href="<?php echo $product_url; ?>"><?php echo $product_name; ?></a>
                </h3>
                <div class="d-flex justify-content-between align-items-center clearfix group pricing"> 
                  
                  <h3 class="card-sub-title fs-6 fw-normal">
                    <span class="card-price fw-bold"><?php echo wc_price($product_price); ?></span>
                  </h3>

                  <div class="shopping-carriage shopping-carriage-buy buying-icon float-right"  
                       onclick="$webAppCore.cart.add('.cart-counter',
                                                     '<?php echo $product_id;?>',
                                                     'get_cart_counter',
                                                     '',
                                                     '.submitting-btn-new-<?php echo $product_id;?>', 
                                                     '<?=IMAGES?>/shopping-bag.png', 
                                                     '<?=IMAGES?>/loading.gif', 
                                                     '<?=IMAGES?>/next.png', 
                                                     '<?php echo get_site_url();?>/cart',
                                                     'image');">
                      <img src="<?=IMAGES?>/shopping-bag.png" alt="favorite" 
                           class="submitting-btn-new-<?php echo $product_id;?>"/>
                  </div>  
                </div>  
              </div>

            </div>
          </div>

          <?php  } ?>


        </div>
      </div>
    </div>
  </section>



  <section class="discount-coupon py-1 my-1 py-md-1 my-md-1">
    <div class="container">
      <a href="<?php echo get_site_url();?>/my-account/"> 
        <div class="coupon position-relative p-0">
          <img src="<?=IMAGES?>/uzazi-register-banner.png" alt="slider" class="the-slider"/>
        </div>
      </a> 
    </div>
  </section>

<?php get_footer(); ?>