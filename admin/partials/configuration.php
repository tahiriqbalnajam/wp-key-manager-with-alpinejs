<h2><?php echo __("Configuration", $this->plugin_name)?></h2>
<div class="SettingDetails" >
  <div class="PluginSettings">
    <form method="post" action="options.php">
    <?php settings_fields( 'idl_keys_options_group' ); ?>
      <table class="form-table">
        <tbody>
          <tr>
            <th><label for="Day_Delivery"><?php echo __("Visitor Admin Email", $this->plugin_name)?></label></th> 
            <td>
              <div class="onoffswitch"> 
                <textarea rows="6" cols="50" name="keys_reminer_email" value="<?php $title = get_option('keys_reminer_email'); if(empty($title)){ echo ""; }else{echo $title; }?>"><?php $title = get_option('keys_reminer_email'); if(empty($title)){ echo ""; }else{echo $title; }?></textarea>
              </div>  
            </td>
          </tr>
        </tbody>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
</div>