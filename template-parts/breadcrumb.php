<div class="freshio-breadcrumb
    <?php
    // Check if it's a product category or custom taxonomy
    if (is_tax('product_cat')) {
        $term = get_queried_object(); // Get the current term (category)

        // Check if term object exists and retrieve the ACF field value
        if ($term && isset($term->term_id)) {
            $breadcrumb_image = get_field('breadcrumb_image', 'product_cat_' . $term->term_id); // Get ACF field value

            // Check if breadcrumb image exists
            if (!empty($breadcrumb_image)) {
                echo ' freshio-breadcrumb-background'; // Add a custom class if the image is present
            }
        }
    }
    ?>"
    <?php
    // Set inline background image if breadcrumb_image exists
    if (!empty($breadcrumb_image)) {
        echo ' style="background-image: url(' . esc_url($breadcrumb_image['url']) . ');"';
    }
    ?>
>
	<div class="col-full">
		<h1 class="breadcrumb-heading">
			<?php
			if (is_page()) {
				the_title();
			} elseif (is_single()) {
				the_title();
			} elseif (is_archive() && is_tax() && !is_category() && !is_tag()) {
				$tax_object = get_queried_object();
				echo esc_html($tax_object->name);
			} elseif (is_category()) {
				single_cat_title();
			} elseif (is_home()) {
				echo esc_html__('Our Blog', 'freshio');
			} elseif (is_post_type_archive('product')) {
				woocommerce_page_title();
			} elseif (is_post_type_archive()) {
				$tax_object = get_queried_object();
				echo esc_html($tax_object->label);
			} elseif (is_tag()) {
				// Get tag information
				$term_id  = get_query_var('tag_id');
				$taxonomy = 'post_tag';
				$args     = 'include=' . esc_attr($term_id);
				$terms    = get_terms($taxonomy, $args);
				// Display the tag name
				if (isset($terms[0]->name)) {
					echo esc_html($terms[0]->name);
				}
			} elseif (is_day()) {
				echo esc_html__('Day Archives', 'freshio');
			} elseif (is_month()) {
				echo get_the_time('F') . esc_html__(' Archives', 'freshio');
			} elseif (is_year()) {
				echo get_the_time('Y') . esc_html__(' Archives', 'freshio');
			} elseif (is_search()) {
				esc_html_e('Search Results', 'freshio');
			} elseif (is_author()) {
				global $author;
				if (!empty($author)) {
					$usermetadata = get_userdata($author);
					echo esc_html__('Author', 'freshio') . ': ' . esc_html($usermetadata->display_name);
				}
			}
			?>
		</h1>

		<?php
		if (freshio_is_woocommerce_activated()) {
			woocommerce_breadcrumb();
		} elseif (freshio_is_bcn_nav_activated()) {
			?>
			<div class="woocommerce-breadcrumb">
				<?php bcn_display(); ?>
			</div>
			<?php
		}
		?>
	</div>
</div>
