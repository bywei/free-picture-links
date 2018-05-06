<?php
error_reporting(5);
/*
Plugin Name: 百味免费图库
Plugin URI:  http://www.ByWei.Cn/
Description:  免费云图床插件：在编辑器页面上传图片至免费服务器
Author: 百味博客
Author URI: http://www.ByWei.Cn
Version: 0.4
*/

define('PLUGIN_URL', plugins_url('', __FILE__));
define('PLUGIN_DIR', plugin_dir_path(__FILE__));

//设置菜单
function free_picture_links_menu(){
    add_options_page('free', '百味免费图库', 'manage_options', 'free-picture-links', 'free_picture_links_options');
}
add_action('admin_menu', 'free_picture_links_menu');

function free_picture_links_options(){
?>  
    <h1>图床设置</h1>
    <form method="post" action="options.php">
    <?php 
     settings_fields( 'free_options');
     do_settings_sections( 'free-settings' );
     ?>
	<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>
	</form>
<?php 
}

add_action('admin_init', 'register_free_settings');

function register_free_settings() {
	register_setting('free_options', 'free_options');
	add_settings_section('free_defaults', '默认设置', 'defaults_output', 'free-settings');
	add_settings_field('free-picture-links-host', '免费绑定域名', 'host_output', 'free-settings','free_defaults');
    add_settings_field('free-picture-links-hostprefix', '前缀', 'prefix_output', 'free-settings','free_defaults');
	add_settings_field('free-picture-links-hostbucket', 'bucket', 'bucket_output', 'free-settings','free_defaults');
	add_settings_field('free-picture-links-hostimgurl', '图片链接形式', 'imgurl_output', 'free-settings','free_defaults');
	add_settings_field('free-picture-links-hostaccesskey', 'AccessKey', 'accesskey_output', 'free-settings','free_defaults');
	add_settings_field('free-picture-links-hostsecretkey', 'SecretKey', 'secretkey_output', 'free-settings','free_defaults');
}

function host_output() {
	$options = get_option('free_options');
	echo "<input id='host' name='free_options[host]' size='50' type='text' value='{$options['host']}' />";
    echo "<div>设置为你在免费绑定的域名,没绑定则填写免费域名<br />仅作显示图片的链接使用,注意要域名前面要加上<strong>  http:// </strong></div>";
}
function prefix_output() {
	$options = get_option('free_options');
	echo "<input id='prefix' name='free_options[prefix]' size='50' type='text' value='{$options['prefix']}' />";
	echo "<div>如果你想像免费一样在上传的图片前加前缀则填写<br />例如:<strong>img</strong>,多个前缀:<strong>img/2015</strong>,不想则留空<br/>添加前缀后图片的链接类似于：免费绑定域名/前缀/图片名称 </div>";

}
function bucket_output() {
	$options = get_option('free_options');
	echo "<input id='bucket' name='free_options[bucket]' size='50' type='text' value='{$options['bucket']}' />";
}
function accesskey_output() {
	$options = get_option('free_options');
	echo "<input id='accesskey' name='free_options[accesskey]' size='50' type='text' value='{$options['accesskey']}' />";
    echo "<div>在免费帐号-密钥中查看</div>";
}
function secretkey_output() {
	$options = get_option('free_options');
	echo "<input id='secretkey' name='free_options[secretkey]' size='50' type='text' value='{$options['secretkey']}' />";
    echo "<div>在免费帐号-密钥中查看</div>";
}

function imgurl_output() {
    $options = get_option('free_options');
    if($options['imgurl']) { $checked = ' checked="checked" '; } else { $checked = ''; }
    echo "<input ".$checked." id='imgurl' name='free_options[imgurl]' type='checkbox' />";
    echo "<div>选择后,图片链接原始地址,图片地址类似<strong>&lt;a&gt;&lt;img&gt;&lt;/a&gt;</strong><br/>不选则无链接,类似<strong>&lt;img&gt;</strong></div>";
}

//上传窗口
add_action('submitpost_box', 'free_picture_links_script');
function free_picture_links_script(){
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'plupload-all' );
    wp_enqueue_script( 'free', plugins_url('js/free.js', __FILE__));
    wp_enqueue_script( 'free-main', plugins_url('js/main.js', __FILE__ ),array( 'jquery' ));
}    
 
add_action('submitpost_box', 'free_picture_links_post_box');
function free_picture_links_post_box(){
    add_meta_box('free_picture_links_div', __('百味免费图库'), 'free_picture_links_post_html', 'post', 'side');
}

add_action('submitpost_box', 'free_picture_links_style');
function free_picture_links_style(){
	wp_enqueue_style('free_picture_links_style', plugins_url('css/free_picture_links.css', __FILE__));
}

function free_picture_links_post_html(){
	$options = get_option('free_options');
    $host = $options['host'];
    $bucket = $options['bucket'];
    $prefix = $options['prefix'];
    $accesskey = $options['accesskey'];
    $secretkey = $options['secretkey'];
    $imgurl = $options['imgurl'];
    echo "<script>";
    if (!empty($prefix)) {
        echo 'var savekey = true;';
    }else echo 'var savekey = false;';
    if (!empty($imgurl)) {
        echo 'var imgurl = true;';
    }else echo 'var imgurl = false;';
    echo 'var host =\''.  $host . '\';';
    echo 'var uptokenurl=\''. plugins_url('uptoken.php', __FILE__) . '?sk='. $secretkey . '&ak=' . $accesskey . '&bucket=' . $bucket . '&prefix=' . $prefix .'\';';
    echo 'var imageupurl=\''. plugins_url('imageup.php', __FILE__) . '\';</script>';
    echo '<fieldset><label for="Filedata"><div id="free_picture_links_post"><div id="pickfiles" href="#" ><span id="spantxt">上传图片</span></div></div></label></fieldset><div id="dialogFrame"><iframe name="upimageFrame" id="upimageFrame"></iframe></div>';
}
?>