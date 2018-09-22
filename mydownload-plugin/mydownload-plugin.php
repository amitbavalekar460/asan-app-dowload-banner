<?php
/*
  Plugin Name: Download Fields Plugin
  Description: This is simple download plugins
  Author: Govind
  Text Domain: mydownload-plugin
  Contributors: Govind
  Version: 2.0.0
*/

function download_add_menu() {
	add_submenu_page ( "options-general.php", "Download Plugin", "Download Plugin", "manage_options", "download-plugin-world", "download_plugin_world_page" );
}

add_action ( "admin_menu", "download_add_menu" );

function download_plugin_world_page() {
	?>
	    <div class="wrap">
        <h2>My Download Settings Page</h2>
        <form method="post" action="options.php">
            <?php
                settings_fields( 'download_plugin_world_config' );
                do_settings_sections( 'download-plugin-world' );
                submit_button();
            ?>
        </form>
    </div> <?php
}
function download_plugin_world_settings() {
	add_settings_section ( "download_plugin_world_config", "", null, "download-plugin-world" );
	add_settings_field ( "download-plugin-world-text", "This is sample Textbox", "download_plugin_world_options", "download-plugin-world", "download_plugin_world_config" );
	register_setting ( "download_plugin_world_config", "download-plugin-world-text" );
}
add_action ( "admin_init", "download_plugin_world_settings" );

function download_plugin_world_options() {
	?>
<div class="postbox" style="width: 65%; padding: 30px;">
	<input type="text" name="download-plugin-world-text"
		value="<?php
	echo stripslashes_deep ( esc_attr ( get_option ( '	download-plugin-world-text' ) ) );
	?>" /> Provide any text value here for testing<br />
</div>
<?php
}
add_filter ( 'the_content', 'download_com_content' );
function download_com_content($content) {
	return $content . stripslashes_deep ( esc_attr ( get_option ( 'download-plugin-world-text' ) ) );
}


// register a custom post type called 'banner'
function wptutsplus_create_post_type() {
    $labels = array(
        'name' => __( 'Banners' ),
        'singular_name' => __( 'banner' ),
        'add_new' => __( 'New banner' ),
        'add_new_item' => __( 'Add New banner' ),
        'edit_item' => __( 'Edit banner' ),
        'new_item' => __( 'New banner' ),
        'view_item' => __( 'View banner' ),
        'search_items' => __( 'Search banners' ),
        'not_found' =>  __( 'No banners Found' ),
        'not_found_in_trash' => __( 'No banners found in Trash' ),
    );
    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'custom-fields',
            'thumbnail',
            'page-attributes'
        ),
        'taxonomies' => array( 'post_tag', 'category'),
    );
    register_post_type( 'banner', $args );
}
add_action( 'init', 'wptutsplus_create_post_type' );

// function to show home page banner using query of banner post type
function wptutsplus_home_page_banner() {
 
    // start by setting up the query
    $query = new WP_Query( array(
        'post_type' => 'banner',
    ));
 
    // now check if the query has posts and if so, output their content in a banner-box div
    if ( $query->have_posts() ) { ?>
        <div class="banner-box">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <div id="post-<?php the_ID(); ?>" <?php post_class( 'banner' ); ?>><?php the_content(); ?></div>
            <?php endwhile; ?>
        </div>
    <?php }
    wp_reset_postdata();
 
}
