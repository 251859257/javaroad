<?php

if (get_stylesheet_directory() == get_template_directory()) {
    define('EVOLVE_URL', get_template_directory() . '/library/functions/');
    define('EVOLVE_DIRECTORY', get_template_directory_uri() . '/library/functions/');
} else {
    define('EVOLVE_URL', get_template_directory() . '/library/functions/');
    define('EVOLVE_DIRECTORY', get_template_directory_uri() . '/library/functions/');
}

/**
 * Get Option.
 * Helper function to return the theme option value.
 * If no value has been saved, it returns $default.
 * Needed because options are
 * as serialized strings.
 */
function evolve_get_option($name, $default = false) {
    $config = get_option('evolve');

    if (!isset($config['id'])) {
        //return $default;
    }
    global $evl_options;

    $options = $evl_options;
    if (isset($GLOBALS['redux_compiler_options'])) {
        $options = $GLOBALS['redux_compiler_options'];
    }

    if (isset($options[$name])) {
        $mediaKeys = array(
            'evl_bootstrap_slide1_img',
            'evl_bootstrap_slide2_img',
            'evl_bootstrap_slide3_img',
            'evl_bootstrap_slide4_img',
            'evl_bootstrap_slide5_img',
            'evl_content_background_image',
            'evl_favicon',
            'evl_footer_background_image',
            'evl_header_logo',
            'evl_scheme_background',
            'evl_slide1_img',
            'evl_slide2_img',
            'evl_slide3_img',
            'evl_slide4_img',
            'evl_slide5_img',
        );
        // Media SHIM
        if (in_array($name, $mediaKeys)) {
            if (is_array($options[$name])) {
                return isset($options[$name]['url']) ? $options[$name]['url'] : false;
            } else {
                return $options[$name];
            }
        }

        return $options[$name];
    }

    return $default;
}

get_template_part('library/functions/basic-functions');
get_template_part('library/admin/admin-init');
function duoshuo_avatar($avatar) {    $avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"gravatar.duoshuo.com",$avatar);    return $avatar;}add_filter( 'get_avatar', 'duoshuo_avatar', 10, 3 );function reset_password_message( $message, $key ) {	if ( strpos($_POST['user_login'], '@') ) {		$user_data = get_user_by('email', trim($_POST['user_login']));	} else {		$login = trim($_POST['user_login']);		$user_data = get_user_by('login', $login);	}	$user_login = $user_data->user_login;	$msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";	$msg .= network_site_url() . "\r\n\r\n";	$msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";	$msg .= __('若这不是您本人要求的，请忽略本邮件，一切如常。') . "\r\n\r\n";	$msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";	$msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;	return $msg;}add_filter('retrieve_password_message', reset_password_message, null, 2);