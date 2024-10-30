<?php
class LinkIconsAdmin{
    public function __construct(){
        if(is_admin()){
			add_action('admin_menu', array($this, 'add_plugin_page'));
			add_action('admin_init', array($this, 'page_init'));
		}
    }
	
    public function add_plugin_page(){
		add_menu_page('Settings Admin', 'Link Icons', 'manage_options', 'link-icons-setting-admin', array($this, 'create_admin_page'));
    }

    public function create_admin_page(){
        ?>
	<div class="wrap">
	    <h2>Link Icons Settings</h2>			
	    <form method="post" action="options.php">
	        <?php
			// This prints out all hidden setting fields
		    settings_fields('link_icons_option_group');	
		    do_settings_sections('link-icons-setting-admin');
			?>
	        <?php submit_button(); ?>
	    </form>
	</div>
	<?php
    }
	
    public function page_init()
	{		
		register_setting('link_icons_option_group', 'use-http', array($this, 'set_http_header'));
		
        add_settings_section(
			'use_http_header',
			'Use HTTP Header?',
			array($this, 'print_http_header_section_info'),
			'link-icons-setting-admin'
		);	
		
		add_settings_field(
			'use_http_yes', 
			'',
			array($this, 'create_http_usage_fields'), 
			'link-icons-setting-admin',
			'use_http_header'		
		);
    }
	
   	public function set_http_header($input){
		
		$set=$input['icon-links-use-http-header'];
		if(get_option('icon-links-use-http-header') === FALSE)
		{
			add_option('icon-links-use-http-header', $set);			
		}
		else
		{
			update_option('icon-links-use-http-header', $set);
		}
		return $set;
    }
	
    public function print_http_header_section_info(){
		?>
		By using HTTP headers Link Icons will take a look at the HTTP headers of the links. <br>
		<p><b>HTTP headers enabled - </b> Link Icons will identify images that is generated by server side code like Imagic and GD-lib. Link Icons will 
		also identify server side generated files that has video as Content-Type.<br />
		<i>This will slow your page down if there is alot of links. So if you enable this it is recomeded that you <b>install a cache plugin</b> for 
		your WordPress site.</i></p>
		
		<p><b>HTTP headers disabled - </b> Link Icons will identify thiese targets:<br>
		Images - jpg, jpeg, gif and png.<br>
		Videos - avi, mpg, mkv, mp4 and mov
		</p>
		<?php
    }
	
	public function create_http_usage_fields(){
		
		// defaultsettings
		$disable="checked";
		$enable="";
		if(get_option('icon-links-use-http-header')==1)
		{
			$disable="";
			$enable="checked";
		}		
		?>
			Disabled <input type="radio" value="0" name="use-http[icon-links-use-http-header]" <?php echo $disable ?>/> &nbsp;
		<?php
		?>
			Enabled <input type="radio" value="1" name="use-http[icon-links-use-http-header]" <?php echo $enable ?>/>
		<?php
    }
	
    
}
?>