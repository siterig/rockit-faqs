<?php
namespace SiteRig\Rockit;

class FAQs extends Core
{
    public $css_cdn_sources;

    public $javascript_cdn_sources;

    /**
     * Create a new instance
     *
     * @since 1.0.0
     */
    public function __construct()
    {

        $this->add_cdn_sources();

        register_activation_hook( __FILE__, array( $this, 'activation_tasks' ) );

        add_filter( 'init', array( $this, 'create_cpt' ) );
        add_filter( 'init', array( $this, 'create_cpt_taxonomy' ), 0 );
        add_filter( 'plugin_action_links', array( $this, 'add_settings_link' ), 10, 2 );

        add_action( 'gettext', array( $this, 'change_title_placeholder' ) );
        add_action( 'admin_menu', array( $this, 'add_settings_menu' ) );
        add_action( 'admin_init', array( $this, 'register_plugin_settings' ) );

    }

    /**
     * Add sources for cdn's
     *
     * @since 1.0.0
     */
    private function add_cdn_sources()
    {

        $this->css_cdn_sources = array(
            'tailwindcss' => 'https://unpkg.com/tailwindcss@2.2.15/dist/tailwind.min.css',
            'bootstrap' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css',
            'foundation' => 'https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation.min.css',
        );

        $this->javascript_cdn_sources = array(
            'alpinejs' => 'https://unpkg.com/alpinejs@3.3.3/dist/cdn.min.js',
        );

    }

    /**
     * Plugin activation tasks
     *
     * @since 1.0.0
     */
    public function activation_tasks()
    {

        add_option( 'Activated_Plugin', 'rockit-faqs' );

    }

    /**
     * Frequently Asked Question CPT
     *
     * @since 1.0.0
     */
    public function create_cpt()
    {

        $labels = array(
            'name'                  => _x( 'FAQs', 'Post Type General Name', 'rockit' ),
            'singular_name'         => _x( 'FAQ', 'Post Type Singular Name', 'rockit' ),
            'menu_name'             => __( 'FAQs', 'rockit' ),
            'name_admin_bar'        => __( 'FAQs', 'rockit' ),
            'archives'              => __( 'FAQ Archives', 'rockit' ),
            'attributes'            => __( 'FAQ Attributes', 'rockit' ),
            'parent_item_colon'     => __( 'Parent FAQ:', 'rockit' ),
            'all_items'             => __( 'All FAQs', 'rockit' ),
            'add_new_item'          => __( 'Add New FAQ', 'rockit' ),
            'add_new'               => __( 'Add New', 'rockit' ),
            'new_item'              => __( 'New FAQ', 'rockit' ),
            'edit_item'             => __( 'Edit FAQ', 'rockit' ),
            'update_item'           => __( 'Update FAQ', 'rockit' ),
            'view_item'             => __( 'View FAQ', 'rockit' ),
            'view_items'            => __( 'View FAQs', 'rockit' ),
            'search_items'          => __( 'Search FAQ', 'rockit' ),
            'not_found'             => __( 'Not found', 'rockit' ),
            'not_found_in_trash'    => __( 'Not found in Bin', 'rockit' ),
            'featured_image'        => __( 'Featured Image', 'rockit' ),
            'set_featured_image'    => __( 'Set featured image', 'rockit' ),
            'remove_featured_image' => __( 'Remove featured image', 'rockit' ),
            'use_featured_image'    => __( 'Use as featured image', 'rockit' ),
            'insert_into_item'      => __( 'Insert into FAQ', 'rockit' ),
            'uploaded_to_this_item' => __( 'Uploaded to this FAQ', 'rockit' ),
            'items_list'            => __( 'FAQs list', 'rockit' ),
            'items_list_navigation' => __( 'FAQs list navigation', 'rockit' ),
            'filter_items_list'     => __( 'Filter FAQs list', 'rockit' ),
        );
        $args = array(
            'label'                 => __( 'FAQ', 'rockit' ),
            'description'           => __( 'Frequently Asked Questions', 'rockit' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor' ),
            'taxonomies'            => array( 'faq_category' ),
            'hierarchical'          => false,
            'public'                => false,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 25,
            'menu_icon'             => 'dashicons-info-outline',
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => false,
            'can_export'            => true,
            'has_archive'           => false,
            'exclude_from_search'   => true,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => false,
        );
        register_post_type( 'rockit_faq', $args );

    }

    /**
     * Frequently Asked Questions Taxonomy
     *
     * @since 1.0.0
     */
    public function create_cpt_taxonomy()
    {

        $labels = array(
            'name'                       => _x( 'Categories', 'Taxonomy General Name', 'rockit' ),
            'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'rockit' ),
            'menu_name'                  => __( 'Categories', 'rockit' ),
            'all_items'                  => __( 'All FAQ Categories', 'rockit' ),
            'parent_item'                => __( 'Parent FAQ Category', 'rockit' ),
            'parent_item_colon'          => __( 'Parent FAQ Category:', 'rockit' ),
            'new_item_name'              => __( 'New FAQ Category Name', 'rockit' ),
            'add_new_item'               => __( 'Add New FAQ Category', 'rockit' ),
            'edit_item'                  => __( 'Edit FAQ Category', 'rockit' ),
            'update_item'                => __( 'Update FAQ Category', 'rockit' ),
            'view_item'                  => __( 'View FAQ Category', 'rockit' ),
            'separate_items_with_commas' => __( 'Separate FAQ Categories with commas', 'rockit' ),
            'add_or_remove_items'        => __( 'Add or remove FAQ Categories', 'rockit' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'rockit' ),
            'popular_items'              => __( 'Popular FAQ Categories', 'rockit' ),
            'search_items'               => __( 'Search FAQ Categories', 'rockit' ),
            'not_found'                  => __( 'Not Found', 'rockit' ),
            'no_terms'                   => __( 'No FAQ Categories', 'rockit' ),
            'items_list'                 => __( 'FAQ Categories list', 'rockit' ),
            'items_list_navigation'      => __( 'FAQ Categories list navigation', 'rockit' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
        );
        register_taxonomy( 'rockit_faq_category', array( 'rockit_faq' ), $args );

    }

    /**
     * Add this plugin's type to the rockit shortcode
     *
     * @since 1.0.0
     */
    private function add_faqs_to_shortcode()
    {

        add_option_to_shortcode();

    }

    /**
     * Add a settings link to the plugin page entry
     *
     * @since 1.0.0
     *
     * @param array $links
     * @param string $file
     * @return array
     */
    public static function add_settings_link( array $links, string $file ) : array
    {

        if ( $file === 'rockit-faqs/rockit-faqs.php' && current_user_can( 'manage_options' ) ) {
            $url = admin_url( 'edit.php?post_type=rockit_faq&page=rockit-faqs-settings' );

            // Prevent warnings in PHP 7.0+ when a plugin uses this filter incorrectly.
            $links = (array) $links;
            $links[] = sprintf( '<a href="%s">%s</a>', $url, __( 'Settings', 'rockit' ) );
        }
        return $links;

    }

    /**
     * Change post title placeholder text for custom post type
     *
     * @global array $post
     * @param string $translation
     * @return string Customized string for title
     */
    public function change_title_placeholder( string $translation ) : string
    {

        global $post;
        if ( isset( $post ) ) {
            switch( $post->post_type ){
                case 'rockit_faq' :
                    if ( $translation == 'Add title' ) return 'Add Question (Add Answer below)';
                    break;
            }
        }
        return $translation;

    }

    /**
     * Enqueue css library from CDN
     *
     * @since 1.0.0
     */
    public function enqueue_css_from_cdn() {


        /*<script defer src="https://unpkg.com/alpinejs@3.3.3/dist/cdn.min.js"></script>*/

    }

    /**
     * Enqueue javascript library from CDN
     *
     * @since 1.0.0
     */
    public function enqueue_javascript_from_cdn() {


        /*<script defer src="https://unpkg.com/alpinejs@3.3.3/dist/cdn.min.js"></script>*/

    }

    /**
     * Add sub-menus for the plugin
     */
    public function add_settings_menu()
    {

        add_submenu_page( 'edit.php?post_type=rockit_faq', 'Rockit FAQs Settings', 'Settings', 'manage_options', 'rockit-faqs-settings', array( $this, 'settings_page' ) );
        add_submenu_page( 'edit.php?post_type=rockit_faq', 'Rockit FAQs Shortcode Generator', 'Shortcode', 'manage_options', 'rockit-faqs-shortcode', array( $this, 'shortcode_page' ) );

    }

    /**
     * Register individual plugin settings
     */
    public function register_plugin_settings()
    {

        register_setting( 'rockit_faqs_plugin_settings_group', 'rockit_faqs_display_mode', array( 'default' => 'collapse-expand') );
        register_setting( 'rockit_faqs_plugin_settings_group', 'rockit_faqs_css_library', array( 'default' => 'tailwindcss') );
        register_setting( 'rockit_faqs_plugin_settings_group', 'rockit_faqs_css_cdn', array( 'default' => 'yes') );
        register_setting( 'rockit_faqs_plugin_settings_group', 'rockit_faqs_javascript_library', array( 'default' => 'alpinejs') );
        register_setting( 'rockit_faqs_plugin_settings_group', 'rockit_faqs_javascript_cdn', array( 'default' => 'yes') );

    }

    /**
     * Create an options page
     */
    public function settings_page()
    {

        ?>
        <div class="wrap">
            <h1>Rockit FAQs Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'rockit_faqs_plugin_settings_group' ); ?>
                <?php do_settings_sections( 'rockit_faqs_plugin_settings_group' ); ?>
                <h2>Display</h2>
                <p>Collapse/Expand will show questions with answers hidden until clicked. List will show questions and answers in one long list.</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Mode</th>
                        <td>
                            <?php
                            $display_mode = get_option('rockit_faqs_display_mode');
                            ?>
                            <p>
                                <input type="radio" name="rockit_faqs_display_mode" id="rockit_faqs_display_mode_collapse_expand" value="collapse-expand"<?php if ( $display_mode == 'collapse-expand' ) { ?> checked<?php } ?>>
                                <label for="display_mode_collapse_expand">Collapse/Expand</label>
                            </p>
                            <p>
                                <input type="radio" name="rockit_faqs_display_mode" id="rockit_faqs_display_mode_list" value="list"<?php if ( $display_mode == 'list' ) { ?> checked<?php } ?>>
                                <label for="display_mode_list">List</label>
                            </p>
                        </td>
                    </tr>
                </table>
                <h2>CSS</h2>
                <p>Select the library you want to use and whether to load it from a CDN source, or you can select <strong>none</strong> and use your own styles.</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Library</th>
                        <td>
                            <?php
                            $css_library = get_option('rockit_faqs_css_library');
                            ?>
                            <select name="rockit_faqs_css_library" id="rockit_faqs_css_library">
                                <option value="tailwindcss"<?php if ( $css_library == 'tailwindcss' || $css_library == '' ) { ?> selected<?php } ?>>TailwindCSS</option>
                                <option value="bootstrap"<?php if ( $css_library == 'bootstrap' ) { ?> selected<?php } ?>>Bootstrap</option>
                                <option value="foundation"<?php if ( $css_library == 'foundation' ) { ?> selected<?php } ?>>Foundation</option>
                                <option value="none"<?php if ( $css_library == 'none' ) { ?> selected<?php } ?>>None</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Enqueue from CDN?</th>
                        <td>
                            <?php
                            $css_cdn = get_option('rockit_faqs_css_cdn');
                            ?>
                            <p>
                                <input type="radio" name="rockit_faqs_css_cdn" id="rockit_faqs_css_cdn_yes" value="yes"<?php if ( $css_cdn == 'yes' ) { ?> checked<?php } ?>>
                                <label for="rockit_faqs_css_cdn_yes">Yes</label>
                            </p>
                            <p>
                                <input type="radio" name="rockit_faqs_css_cdn" id="rockit_faqs_css_cdn_no" value="no"<?php if ( $css_cdn == 'no' ) { ?> checked<?php } ?>>
                                <label for="rockit_faqs_css_cdn_no">No</label>
                            </p>
                        </td>
                    </tr>
                </table>
                <h2>Javascript</h2>
                <p>Select the library you want to use and whether to load it from a CDN source, or you can select <strong>none</strong> and use your own styles.</p>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Library</th>
                        <td>
                            <?php
                            $javascript_library = get_option('rockit_faqs_javascript_library');
                            ?>
                            <select name="rockit_faqs_javascript_library" id="rockit_faqs_javascript_library">
                                <option value="jquery"<?php if ( $css_library == 'jquery' || $css_library == '' ) { ?> selected<?php } ?>>jQuery (WordPress)</option>
                                <option value="alpinejs"<?php if ( $css_library == 'alpinejs' ) { ?> selected<?php } ?>>AlpineJS</option>
                                <option value="none"<?php if ( $css_library == 'none' ) { ?> selected<?php } ?>>None</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Enqueue from CDN?</th>
                        <td>
                            <?php
                            $javascript_cdn = get_option('rockit_faqs_javascript_cdn');
                            ?>
                            <p>
                                <input type="radio" name="rockit_faqs_javascript_cdn" id="rockit_faqs_javascript_cdn_yes" value="yes"<?php if ( $javascript_cdn == 'yes' ) { ?> checked<?php } ?>>
                                <label for="rockit_faqs_javascript_cdn_yes">Yes</label>
                            </p>
                            <p>
                                <input type="radio" name="rockit_faqs_javascript_cdn" id="rockit_faqs_javascript_cdn_no" value="no"<?php if ( $javascript_cdn == 'no' ) { ?> checked<?php } ?>>
                                <label for="rockit_faqs_javascript_cdn_no">No</label>
                            </p>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php

    }

    /**
     * Create a shortcode generator page
     */
    public function shortcode_page()
    {

        ?>
        <div class="wrap">
            <h1>Rockit FAQs Shortcode Generator</h1>
            <p>Change the settings below to create a shortcode to output your FAQs and then copy it to wherever you need a shortcode.</p>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Number of FAQs</th>
                    <td>
                        <input type="number" name="sc_number_of_faqs" id="sc_number_of_faqs" step="1" min="1" value="0">
                        <p class="description">Limit how many FAQs to display, setting to <strong>0</strong> will show all available results</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Random order?</th>
                    <td>
                        <p>
                            <input type="radio" name="sc_random_order" id="sc_random_order_yes" value="yes">
                            <label for="sc_random_order_yes">Yes</label>
                        </p>
                        <p>
                            <input type="radio" name="sc_random_order" id="sc_random_order_no" value="no" checked>
                            <label for="sc_random_order_no">No</label>
                        </p>
                        <p class="description">By default FAQs are ordered by <strong>date ascending</strong> (oldest first)</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Show category filter?</th>
                    <td>
                        <p>
                            <input type="radio" name="sc_show_category_filter" id="sc_show_category_filter_yes" value="yes" checked>
                            <label for="sc_show_category_filter_yes">Yes</label>
                        </p>
                        <p>
                            <input type="radio" name="sc_show_category_filter" id="sc_show_category_filter_no" value="no">
                            <label for="sc_show_category_filter_no">No</label>
                        </p>
                        <p class="description">Hidden if <strong>Use Specific Category</strong> is set to <strong>Yes</strong></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Category</th>
                    <td>
                        <?php
                        $faq_categories = get_categories(
                            array(
                                'taxonomy' => 'faq_category',
                                'include_children' => false,
                            ),
                        );
                        ?>
                        <select name="sc_category" id="sc_category"<?php if ( count( $faq_categories ) == 0 ) { ?> disabled<?php } ?>>
                            <option value="0" selected><?php if ( count( $faq_categories ) == 0 ) { ?>No categories yet<?php } else { ?>All categories<?php } ?></option>

                        </select>
                        <p class="description">Select a <strong>specific category</strong> to filter FAQs to</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Shortcode</th>
                    <td>
                        <textarea id="sc_shortcode" class="large-text" rows="3" cols="50">[rockit option=faqs]</textarea>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">&nbsp;</th>
                    <td>
                        <button type="button" class="button button-secondary" aria-label="Copy to clipboard">Copy to clipboard</button>
                    </td>
                </tr>

            </table>
        </div>
        <?php

    }
}
