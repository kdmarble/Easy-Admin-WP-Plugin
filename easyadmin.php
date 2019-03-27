<?php
/**
 * Plugin Name:       Easy Admin
 * Description:       Easy Admin Customization
 * Version:           1.0.0
 * Author:            Keith Marble
 * Author URI:        http://kdmarble.github.io
 * License:           GPL-2.0+
 * GitHub Plugin URI: http://kdmarble.github.io
 */

class Easy_Admin
{


    public function __construct() {
        add_action('login_head', array($this, 'custom_login_logo'));
        add_action('admin_head', array($this, 'remove_admin_logo'));
        add_filter('admin_footer_text', array($this, 'change_footer_admin'));
        add_filter('show_admin_bar', array($this, 'toggle_admin_bar'));
        add_action( 'admin_menu', array($this, 'ea_add_admin_menu' ));
        add_action( 'admin_init', array($this, 'ea_settings_init' ));
    }

    // Custom login page logo
    function custom_login_logo() {
        $options = get_option('ea_settings');
        echo '<style>' . $options['ea_textarea_field_0'] . '</style>'; 
    }

    // Remove admin page header logo
    function remove_admin_logo() {
        $options = get_option('ea_settings');
        if ( isset($options['ea_checkbox_field_1']) ){
            echo '<style> li#wp-admin-bar-wp-logo { display: none; }</style>';
        }
    }

    // Change admin panel footer
    function change_footer_admin() {
        $options = get_option('ea_settings');
        echo trim($options['ea_textarea_field_2']);
    }

    // Toggle Admin Bar
    function toggle_admin_bar() {
        $options = get_option('ea_settings');
        if( isset($options['ea_checkbox_field_3']) )  {
            return '__return_false';
        }
    }

    function ea_add_admin_menu(  ) { 

        add_options_page( 'Easy Admin', 'Easy Admin', 'manage_options', 'easy_admin', array($this, 'ea_options_page' ));

    }


    function ea_settings_init(  ) { 

        register_setting( 'pluginPage', 'ea_settings' );

        add_settings_section(
            'ea_pluginPage_section', 
            __( 'Customize Your Wordpress', 'wordpress' ), 
            array($this, 'ea_settings_section_callback'), 
            'pluginPage'
        );

        add_settings_field( 
            'ea_textarea_field_0', 
            __( 'Custom Login Logo: Please provide valid CSS to customize your Login page', 'wordpress' ), 
            array($this, 'ea_textarea_field_0_render'), 
            'pluginPage', 
            'ea_pluginPage_section' 
        );

        add_settings_field( 
            'ea_checkbox_field_1', 
            __( 'Check to remove admin logo', 'wordpress' ), 
            array($this, 'ea_checkbox_field_1_render'), 
            'pluginPage', 
            'ea_pluginPage_section' 
        );

        add_settings_field( 
            'ea_textarea_field_2', 
            __( 'Add your own custom admin footer text', 'wordpress' ), 
            array($this, 'ea_textarea_field_2_render'), 
            'pluginPage', 
            'ea_pluginPage_section' 
        );

        add_settings_field( 
            'ea_checkbox_field_3', 
            __( 'Check to show admin bar on front-end site', 'wordpress' ), 
            array($this, 'ea_checkbox_field_3_render'), 
            'pluginPage', 
            'ea_pluginPage_section' 
        );


    }


    function ea_textarea_field_0_render(  ) { 

        $options = get_option( 'ea_settings' );
        ?>
        <textarea cols='40' rows='5' name='ea_settings[ea_textarea_field_0]'> 
            <?php echo trim($options['ea_textarea_field_0']); ?>
        </textarea>
        <?php

    }


    function ea_checkbox_field_1_render(  ) { 

        $options = get_option( 'ea_settings' );
        if( !isset($options['ea_checkbox_field_1']) ) {
            $options['ea_checkbox_field_1'] = false;
        }
        ?>
        <input type='checkbox' name='ea_settings[ea_checkbox_field_1]' <?php checked( $options['ea_checkbox_field_1'], 1 ); ?> value='1'>
        <?php

    }


    function ea_textarea_field_2_render(  ) { 

        $options = get_option( 'ea_settings' );
        ?>
        <textarea cols='40' rows='5' name='ea_settings[ea_textarea_field_2]'> 
            <?php echo trim($options['ea_textarea_field_2']); ?>
        </textarea>
        <?php

    }


    function ea_checkbox_field_3_render(  ) { 

        $options = get_option( 'ea_settings' );
        if( !isset($options['ea_checkbox_field_3']) ) {
            $options['ea_checkbox_field_3'] = false;
        }
        ?>
        <input type='checkbox' name='ea_settings[ea_checkbox_field_3]' <?php checked( $options['ea_checkbox_field_3'], 1 ); ?> value='1'>
        <?php

    }


    function ea_settings_section_callback(  ) { 

        echo __( '', 'wordpress' );

    }


    function ea_options_page(  ) { 

        ?>
        <form action='options.php' method='post'>

            <h2>Easy Admin</h2>

            <?php
            settings_fields( 'pluginPage' );
            do_settings_sections( 'pluginPage' );
            submit_button();
            ?>

        </form>
        <?php

    }


}


// Creates new instance
new Easy_Admin();