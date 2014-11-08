<?php

// display the admin options page
function jslider_options_page() {
?>
<div>
<h2>Justin Maurer's Fantastic CPT Slider</h2>
Options
<form action="options.php" method="post">
<?php settings_fields('jslider_options'); ?>
<?php do_settings_sections('jslider'); ?>
 
<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
</form>
<p>The current post type is set to "<?php
$options = get_option('post_kind');
echo $options['text_string']; ?>
"</p>
</div>
 
<?php
}

function main_section_text() {
	echo '<p>Choose a post type</p>';
}

function jslider_setting_post_type() {
$options = get_option('post_kind');
echo "<input id='jslider_post_type' name='post_kind[text_string]' size='40' type='text' value='{$options['text_string']}' />";
}

function jslider_options_validate($input) {
	$newinput['text_string'] = sanitize_text_field($input['text_string']);
	// if(!preg_match('/[^a-z0-9 _]+/i', $newinput['text_string'])) {
	// 	$newinput['text_string'] = 'profile';
	// 	echo '<p>Failure!</p>';
	// } else {
	// 	echo '<p>You did it!</p>';
	// }
	return $newinput;
}

// add the admin settings and such
add_action('admin_init', 'jslider_admin_init');
function jslider_admin_init(){
register_setting( 'jslider_options', 'post_kind', 'jslider_options_validate' );
add_settings_section('jslider_main', 'Main Settings', 'main_section_text', 'jslider');
add_settings_field('jslider_post_type', 'Post Type', 'jslider_setting_post_type', 'jslider', 'jslider_main');
}


?>