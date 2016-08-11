<?php
/**
 * @package custom-dashboard-widgets
 * @version 1.1.2
 */
/*
Plugin Name: Custom Dashboard Widgets
Plugin URI: http://wordpress.org/plugins
Description: Customize Your Dashboard Main Page, New Layouts, you can simplisity customize your dashboard links to access quickly to your dashboard pages.
You can add new row (access link), edit rows and delete row.
Version: 1.1.2
Author: AboZain,O7abeeb,UnitOne
Author URI: http://unitone.ps
tags: Dashboard, Widget, Layout, layouts, widgets, posts, links, settings, plugins, dashboard layout, dashboard widgets, custom dashboard, customize dashboard
*/


add_action( 'admin_menu', 'cdw_reg_menu' );

function cdw_reg_menu(){
	add_options_page( __('Dashboard Widgets', 'DashboardWidgets'), __('Dashboard Widgets', 'DashboardWidgets'), 'administrator', 'dashboard-widgets', 'cdw_DashboardWidgets'); 
}


# Load plugin text domain
add_action( 'init', 'cdw_plugin_textdomain' );
# Text domain for translations
function cdw_plugin_textdomain() {
    $domain = 'DashboardWidgets';
    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );
    load_textdomain( $domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo' );
    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
}
//////////////////////////
function cdw_DashboardWidgets(){
	echo '<link rel="stylesheet" type="text/css" href="'.plugins_url( 'dw_style.css', __FILE__ ).'" />';

	?>
	
			<div class="modalDialog">
				<div>
					<a href="#" title="Close" class="close"><i class="fa fa-times"></i></a>
					<table class="table table-bordered">
						<tr>
							<th width="30%"> <?php _e('Title', 'DashboardWidgets') ?> </th>
							<th width="30%"> <?php _e('icon', 'DashboardWidgets') ?>  </th>
							<th width="40%"> <?php _e('preview', 'DashboardWidgets') ?>  </th>
						</tr>
						<tr>
							<td><?php _e('Testimonials', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-quote-left"></i></td>
							<td>fa fa-quote-left</td>
						</tr>
						<tr>
							<td><?php _e('Products', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-shopping-basket"></i></td>
							<td>fa fa-shopping-basket</td>
						</tr>
						<tr>
							<td><?php _e('Clients', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-users"></i></td>
							<td>fa fa-users</td>
						</tr>
						<tr>
							<td><?php _e('Slider', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-sliders"></i></td>
							<td>fa fa-sliders</td>
						</tr>
						<tr>
							<td><?php _e('Videos', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-caret-square-o-right"></i></td>
							<td>fa fa-caret-square-o-right</td>
						</tr>
						<tr>
							<td><?php _e('Gallery', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-picture-o"></i></td>
							<td>fa fa-picture-o</td>
						</tr>
						<tr>
							<td><?php _e('Services', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-usb"></i></td>
							<td>fa fa-usb</td>
						</tr>
						<tr>
							<td><?php _e('FAQ', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-question-circle"></i></td>
							<td>fa fa-question-circle</td>
						</tr>
						<tr>
							<td><?php _e('Team', 'DashboardWidgets') ?></td>
							<td><i style="font-size:22px;" class="fa fa-users"></i></td>
							<td>fa fa-users</td>
						</tr>
					</table>
				</div>
			</div>

        <div class="wrap">
            <?php screen_icon('edit-pages'); ?>
			<h2><?php _e('Dashboard Widgets', 'DashboardWidgets') ?></h2>
			<div style="background-color:#fff;border:1px solid #e1e1e1; padding:10px 20px;">
            <p style="font-weight:bold;"><?php _e('Customize Your Dashboard Main Page, New Layouts, you can simplisity customize your dashboard links to access quickly to your dashboard pages. You can add new row (access link), edit rows and delete row. ', 'DashboardWidgets') ?></p>
			<p  style="font-weight:bold;"><a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/"> 
			<?php _e('You can Choose the icons from this link ', 'DashboardWidgets') ?>  </a></p>
			<p style="font-weight:bold;"><?php _e('We have collected the most common wordpress post types and their icons to make it easy for you to choose the right icon for it,', 'DashboardWidgets') ?> <a href="#" class="open"><?php _e('Click Here', 'DashboardWidgets') ?></a> <?php _e('to open the window', 'DashboardWidgets') ?>.</p>
			<p style="font-weight:bold;"><?php _e('You Must enter the link after','DashboardWidgets'); ?> wp-admin/ <span> <?php _e(' For Example: ','DashboardWidgets'); ?> http://domain.com/wp-admin/<strong style="padding:3px;background-color:#8E8400;color:#fff;border-radius:5px;">edit.php</strong><?php _e(' Copy the highlight text ','DashboardWidgets'); ?> (edit.php).</span></p>
	
			<?php if(isset($_POST['data']) && isset($_POST['submit'])){
				
				$data = $_POST['data'];
				foreach($data as $k=>$dd){
					$res2[$k] = $dd['order'] ;
				}
				asort($res2);
				foreach($res2 as $k=>$val){
					$sorted[] = $data[$k];
				}
				$data = $sorted;
				
				
						update_option('dashboard-widgets', $data);		
				echo '<br> <h2 style="
				  color: green;
				  background-color:#f1f1f1;
				  height:15px;
				  margin:0 auto;
				  padding: 20px 50px;">'.__('Saved Successfully', 'DashboardWidgets').'</h2>';
			}else{
				$data =  get_option('dashboard-widgets'); 
				if(empty($data)  || isset($_POST['reset_default']) ){
					$data = cdw_get_default_data();
					if(isset($_POST['reset_default'])){
						 update_option('dashboard-widgets', $data);	
					}
				}
			
			} ?>
			</div>
	
            <form method="post" action="">
				<?php settings_fields( 'disable-settings-group' ); ?>
            	<?php do_settings_sections( 'disable-settings-group' );  ?>
			<br/>
			<table class="cdw-table table table-bordered">
				<tr>
					<th width="20%"> <?php _e('Title', 'DashboardWidgets') ?> </th>
					<th width="20%">  <?php _e('icon', 'DashboardWidgets') ?>  </th>
					<th width="20%">  <?php _e('link', 'DashboardWidgets') ?> </th>
					<th width="5%"> <?php _e('Active', 'DashboardWidgets') ?>  </th>
					<th > <?php _e('Administrator', 'DashboardWidgets') ?>  </th>
					<th > <?php _e('Editor', 'DashboardWidgets') ?>  </th>
					<th > <?php _e('Author', 'DashboardWidgets') ?>  </th>
					<th > <?php _e('Contributor', 'DashboardWidgets') ?>  </th>
					<th > <?php _e('Order', 'DashboardWidgets') ?>  </th>
					<th > <?php _e('Remove', 'DashboardWidgets') ?>  </th>
				</tr>		
				
			<?php foreach($data as $k=>$item){  ?>
			<tr data-id="<?= $k ?>">
				<td><input type="text" name="data[<?= $k ?>][title]"  value="<?php echo $item['title'] ?>" /></td>
				<td><input type="text" name="data[<?= $k ?>][icon]" value="<?php echo $item['icon']  ?>" /></td>
				<td><input type="text" name="data[<?= $k ?>][link]" value="<?php echo $item['link']  ?>" /></td>
				<td><input type="checkbox" name="data[<?= $k ?>][status]" value="checked"  <?php echo $item['status']  ?>/></td>
				<td><input type="checkbox" name="data[<?= $k ?>][administrator]" value="checked"  <?php echo $item['administrator']  ?>/></td>
				<td><input type="checkbox" name="data[<?= $k ?>][editor]" value="checked"  <?php echo $item['editor']  ?>/></td>
				<td><input type="checkbox" name="data[<?= $k ?>][author]" value="checked"  <?php echo $item['author']  ?>/></td>
				<td><input type="checkbox" name="data[<?= $k ?>][contributor]" value="checked"  <?php echo $item['contributor']  ?>/></td>
				<td><input type="number" name="data[<?= $k ?>][order]" value="<?= $k ?>"/></td>
				<td><a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i></a></td>
			</tr>
			<?php } ?>
			</table>
				<div class="add-new"><a href="javascript:void(0);" class="addCF"><i class="fa fa-plus"></i><?php _e('Add Row', 'DashboardWidgets') ?></a></div>
                <?php submit_button(); ?>
				<p class="submit">
					<input type="submit" name="reset_default" class="button button-danger def-button" value="<?php _e('Set Defaults', 'DashboardWidgets') ?>">
				</p>
            </form>
        </div>	
		
		<br/>

<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
$(document).ready(function(){
	$(".addCF").click(function(){
		var key = $(".cdw-table tr:last-child").data('id');
		key = key+1;
		$(".cdw-table").append('<tr data-id="'+key+'"><td><input type="text" name="data['+key+'][title]" value="Title" /></td><td><input type="text" name="data['+key+'][icon]" value="fa fa-wordpress" /></td><td><input type="text" name="data['+key+'][link]" value="Link" /></td><td><input type="checkbox" name="data['+key+'][status]" value="checked"  checked/></td><td><input type="checkbox" name="data['+key+'][administrator]" value="checked"  checked/></td><td><input type="checkbox" name="data['+key+'][editor]" value="checked"  checked/></td><td><input type="checkbox" name="data['+key+'][author]" value="checked" /></td><td><input type="checkbox" name="data['+key+'][contributor]" value="checked" /></td><td><input type="number" name="data['+key+'][order]" value="'+key+'" /></td><td><a href="javascript:void(0);" class="remCF"><i class="fa fa-times"></i></a></td></tr>');
		});
		$(".cdw-table").on('click','.remCF',function(){
			$(this).parent().parent().remove();
		});
	$(".open").click(function(e){
		e.preventDefault();
		$('.modalDialog').fadeToggle();
	});
	$(".close").click(function(e){
		e.preventDefault();
		$('.modalDialog').fadeToggle();
	});
		
});
</script>
				
		<?php
}

///////////////// Delete Default Widgets ////////////////
remove_action( 'welcome_panel', 'wp_welcome_panel' );
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
function remove_dashboard_widgets() {
    global $wp_meta_boxes;
    unset($wp_meta_boxes['dashboard']);
}
////////////////////////////////////////////////////////////

function cdw_get_default_data(){
	echo '<link rel="stylesheet" type="text/css" href="'.plugins_url( 'dw_style.css', __FILE__ ).'" />';

				$items = $item = array();
				$item['title'] = __('View Site');
				$item['icon'] = 'fa fa-home';
				$item['link'] = 'site_url';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = 'checked';
				$item['author'] = 'checked';
				$item['contributor'] = 'checked';
				$item['order'] = 0;
				$items[] = $item;

				$item['title'] = __('Profile');
				$item['icon'] = 'fa fa-user';
				$item['link'] = 'profile.php';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = 'checked';
				$item['author'] = 'checked';
				$item['contributor'] = 'checked';
				$item['order'] = 0;
				$items[] = $item;
				 
				$item['title'] = __('Posts');
				$item['icon'] = 'fa fa-pencil-square-o';
				$item['link'] = 'edit.php';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = 'checked';
				$item['author'] = 'checked';
				$item['contributor'] = 'checked';
				$item['order'] = 0;
				$items[] = $item;
					
				$item['title'] = __('Media');
				$item['icon'] = 'fa fa-picture-o';
				$item['link'] = 'upload.php';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = 'checked';
				$item['author'] = 'checked';
				$item['contributor'] = '';
				$item['order'] = 0;
				$items[] = $item;
				
				$item['title'] = __('Users');
				$item['icon'] = 'fa fa-users';
				$item['link'] = 'users.php';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = '';
				$item['author'] = '';
				$item['contributor'] = '';
				$item['order'] = 0;
				$items[] = $item;
				
				$item['title'] = __('Pages');
				$item['icon'] = 'fa fa-th';
				$item['link'] = 'edit.php?post_type=page';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = 'checked';
				$item['author'] = '';
				$item['contributor'] = '';
				$item['order'] = 0;
				$items[] = $item;
				
				$item['title'] = __('Plugins');
				$item['icon'] = 'fa fa-plug';
				$item['link'] = 'plugins.php';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = '';
				$item['author'] = '';
				$item['contributor'] = '';
				$item['order'] = 0;
				$items[] = $item;
				
				$item['title'] = __('Settings');
				$item['icon'] = 'fa fa-cogs';
				$item['link'] = 'options-general.php';
				$item['status'] = 'checked';
				$item['administrator'] = 'checked';
				$item['editor'] = '';
				$item['author'] = '';
				$item['contributor'] = '';
				$item['order'] = 0;
				$items[] = $item;
			return $items;
}

/////////////// Add Custome Widget //////////////////////
function custom_dashboard_widget(){
	echo '<link rel="stylesheet" type="text/css" href="'.plugins_url( 'dw_style.css', __FILE__ ).'" />';

    echo '<h4>'.__('Welcome To your Dashboard', 'DashboardWidgets').'</h4>';

    global $current_user; // Use global
    get_currentuserinfo(); // Make sure global is set, if not set it.
    $website_url = get_bloginfo('url');
    $admin_url = site_url()."/wp-admin/";
    $widget_button_class = "main_bashboard_widget_button";
    
		$data =  get_option('dashboard-widgets'); 
		if(empty($data)){
			$data = cdw_get_default_data();
		}
		foreach($data as $item){ 
			if($item['status'] != 'checked') continue;
			$userRole = array_values($current_user->roles);
			$role = $userRole[0];
			if(!isset($item[$role]) ||  ($item[$role] != 'checked') ) continue;
						
				if(strpos($item['link'] , 'http') ===false){ //not full link
					$link = ($item['link'] != 'site_url')? $admin_url.$item['link'] : home_url();
				}else{
					$link = $item['link'];
				} 
				
				
				echo '<div class="'.$widget_button_class.'">
					<a href="'.$link.'">
						<i class="'.$item['icon'].'"></i>
						<h3>'.__($item['title']).'</h3>
					</a>
				</div>';
		}
    echo '</div>';
}
function add_custom_dashboard_widget(){
	
	error_reporting(0);
	echo '<link rel="stylesheet" type="text/css" href="'.plugins_url( 'dw_style.css', __FILE__ ).'" />';

    wp_add_dashboard_widget('custom_dashboard_widget',__('Dashboard', 'DashboardWidgets'),'custom_dashboard_widget','rc_mdm_configure_my_rss_box');
}
add_action('wp_dashboard_setup', 'add_custom_dashboard_widget');

?>
