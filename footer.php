<?php
/**
 * The template for displaying the footer.
 *
 * @package OceanWP WordPress theme
 */

?>

	</main><!-- #main -->

	<?php do_action( 'ocean_after_main' ); ?>

	<?php do_action( 'ocean_before_footer' ); ?>

	<?php
	// Elementor `footer` location.
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
		?>

		<?php // do_action( 'ocean_footer' ); ?>

	<?php } ?>

	<?php do_action( 'ocean_after_footer' ); ?>

    

    <footer id="footer" class="py-5 border-top">
		    <div class="container-lg section-width-medium">
		      <div class="row">

		        <div class="col-lg-3 col-md-3 pb-3">
		          <div class="footer-menu">
		            <h5 class="widget-title pb-2">Product categories</h5>
		            <ul class="menu-list list-unstyled footer-menu-list">
		              <?php
					    
					    // Get WooCommerce product categories
					    $product_categories = get_terms('product_cat', array(
					                'hide_empty' => true,
					                'number' => 6));
                       // Check if there are categories
					   if (!empty($product_categories) && !is_wp_error($product_categories)) { 
					    foreach ($product_categories as $category) {  ?>
		              <li class="pb-2">
		                <a href="<?php echo get_term_link($category); ?>"><?php echo  esc_html($category->name); ?> </a>
		              </li>
		          <?php  } } ?>
		              
		            </ul>
		          </div>
		        </div>

		        <div class="col-lg-3 col-md-3 pb-3">
		          <div class="footer-menu">
		            <h5 class="widget-title pb-2">Explore</h5>
		            <ul class="menu-list list-unstyled footer-menu-list">
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/about">About Uzazi</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/blog-2">Blog</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/vendor-register/">Become a Vendor</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/careers">Careers</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/return-replacement-policy">
		                   Return and Replacement policy</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/terms-conditions/">Terms and conditions</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/terms-of-use/">Terms of use</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/privacy-policy-2/">Privacy policy</a>
		              </li>
		            </ul>
		          </div>
		        </div>
		    
		        <div class="col-lg-2 col-md-3 pb-3">
		          <div class="footer-menu">
		            <h5 class="widget-title pb-2">help</h5>
		            <ul class="menu-list list-unstyled footer-menu-list">
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/frequently-asked-questions-faqs">FAQs</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/customer-service-portal">Customer service portal</a>
		              </li>
		              <li class="pb-2">
		                <a href="<?=get_site_url();?>/frequently-asked-questions-faqs">Report a problem</a>
		              </li>
		            </ul>
		          </div>
		        </div>


		        <div class="col-lg-4 col-md-3 pb-3">
		          <div class="footer-menu">
		            <div>
		              <a class="navbar-brand m-0" href="<?php echo get_site_url(); ?>">
		                <img src="<?=IMAGES?>/foot-logo.png" class="logo" alt="uzazi hub">
		              </a>
		            </div>
		            <div class="footer-contact-text footer-menu-list pt-3 mt-2">
		             
		              <span>2nd Floor, Room 305 Global House, 8 Buyinja Lane, Nakawa Kampala </span>
		              <span>Call us: <a href="+256741895504">(+256 ) 741 895 504</a>, 
		                             <a href="+256761 421 005">(+256 ) 761 421 005</a> </span>
		              <span class="fw-boldx light-border"><a href="mailto:mama@uzazihub.com">mama@uzazihub.com </a>, <a href="mailto:uzazihub@gmail.com">uzazihub@gmail.com </a>


		              </span>
		            </div>
		          </div>
		        </div>



		        <div class="col-lg-12 col-md-12 pb-3">
		           <div class="footer-menu">
		            <h5 class="widget-title pb-2">Follow us on</h5>
		            <ul class="menu-list-social m-0 p-0">

		              <li class="pb-2 menu-top-social">
		                <a  href="https://www.facebook.com/uzazistore?mibextid=D4KYlr" target="_blank">
		                  <img src="<?=IMAGES?>/facebook.png" alt="" />
		                </a>  
		              </li>
		              <li class="pb-2 menu-top-social">
		                <a  href="https://www.instagram.com/uzazihub?utm_source=qr&igshid=MzNlNGNkZWQ4Mg%3D%3D" target="_blank">
		                  <img src="<?=IMAGES?>/instagram.png" alt="" />
		                </a>  
		              </li>
		              <li class="pb-2 menu-top-social">
		                <a  href="https://www.tiktok.com/@uzazihub?_t=8fnYIEXR9OP&_r=1" target="_blank">
		                   <img src="<?=IMAGES?>/tik-tok.png" alt="" />
		                </a>   
		              </li>
		              <li class="pb-2 menu-top-social">
		                <a  href="https://twitter.com/uzazihub?t=KR2bbyDRraS8zjt767cdJw&s=08" target="_blank">  
		                  <img src="<?=IMAGES?>/twitter.png" alt="" />
		                </a>  
		              </li>
		              <li class="pb-2 menu-top-social">
		                <a  href="https://www.tiktok.com/@uzazihub?_t=8fnYIEXR9OP&_r=1" target="_blank">  
		                  <img src="<?=IMAGES?>/youtube.png" alt="" />
		                </a>  
		              </li>
		              <li class="pb-2 menu-top-social">
		                <a  href="https://www.linkedin.com/company/uzazihub/" target="_blank">  
		                  <img src="<?=IMAGES?>/linkedin.png" alt="" />
		                </a>  
		              </li>

		            </ul>
		          </div>
		        </div>


		      </div>


		      <div class="row">
		        <div class="col-md-12 text-lg-center text-center copyright-text">
		          <p>&copy; Copyright All rights reserved Uzazihub Uganda <?php echo date('Y'); ?></p>
		        </div>
		      </div>
		    </div>
		  </footer>  



</div><!-- #wrap -->

<?php do_action( 'ocean_after_wrap' ); ?>

</div><!-- #outer-wrap -->

<?php do_action( 'ocean_after_outer_wrap' ); ?>

<?php
// If is not sticky footer.
if ( ! class_exists( 'Ocean_Sticky_Footer' ) ) {
	get_template_part( 'partials/scroll-top' );
}
?>

<?php
// Search overlay style.
if ( 'overlay' === oceanwp_menu_search_style() ) {
	get_template_part( 'partials/header/search-overlay' );
}
?>

<?php
// If sidebar mobile menu style.
if ( 'sidebar' === oceanwp_mobile_menu_style() ) {

	// Mobile panel close button.
	if ( get_theme_mod( 'ocean_mobile_menu_close_btn', true ) ) {
		get_template_part( 'partials/mobile/mobile-sidr-close' );
	}
	?>

	<?php
	// Mobile Menu (if defined).
	get_template_part( 'partials/mobile/mobile-nav' );
	?>

	<?php
	// Mobile search form.
	if ( get_theme_mod( 'ocean_mobile_menu_search', true ) ) {
		ob_start();
		get_template_part( 'partials/mobile/mobile-search' );
		echo ob_get_clean();
	}
}
?>

<?php
// If full screen mobile menu style.
if ( 'fullscreen' === oceanwp_mobile_menu_style() ) {
	get_template_part( 'partials/mobile/mobile-fullscreen' );
}
?>

<?php wp_footer(); ?>


 <script src="<?=JS?>/jquery-1.11.0.min.js"></script>
 <script src="<?=JS?>/plugins.js"></script>
 <script src="<?=JS?>/script.js"></script>

</body>
</html>
