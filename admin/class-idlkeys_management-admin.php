<?php
class Idlkeys_management_Admin {
	private $plugin_name;
	private $version;
	private $model;

	public function __construct( $plugin_name, $version ) {
		include 'model/idl_keys_model.php';
		$this->model = new idlkeysmodel();
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	public function enqueue_styles() {
		wp_enqueue_style($this->plugin_name . 'bulma', plugin_dir_url(__FILE__) . 'css/idl_pure.css', array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/idlkeys_management-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/idlkeys_management-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script( $this->plugin_name.'-alpine',"https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js", array(), $this->version, false );
		wp_localize_script($this->plugin_name, 'ajax' , array( 'url' => admin_url( 'admin-ajax.php')) );
		wp_enqueue_script( $this->plugin_name.'jscolor', plugin_dir_url( __FILE__ ) . 'js/jscolor.js', array( 'jquery' ), $this->version, false );
	}

	public function idl_key_manage_menu()
	{
		if (function_exists('add_menu_page')) {
			add_menu_page(__('Keys', 'idlkeysmange_managepage'),
				__('Keys', 'idlkeysmange_manage'), 'manage_options', 'idlkeysmange_managepage',
				array($this, 'idlkeysmange_managemnent'), 'dashicons-backup');
		}
		if (function_exists('add_submenu_page')) {
			add_submenu_page('idlkeysmange_managepage', __('Configuration', 'idlkeysmange_managepage   '),
				__('Configuration', 'idlkeysmange_managepage'), 'manage_options', 'configuration_page',
				array($this, 'configuration_menu'));
			/*add_submenu_page('idlkeysmange_managepage', __('Pending Returns', 'idlkeysmange_managepage'),
				__('Pending Returns', 'idlkeysmange_managepage'), 'manage_options', 'pendingreturns_page',
				array($this, 'pendingreturns_menu'));*/
		}
	}

	public function idlkeysmange_managemnent() {
		include 'partials/main.php';
	}

	public function configuration_menu() {
		include 'partials/configuration.php';
	}

	public function idl_keys_configuration_settings() {
		add_option( 'idl_keys_options_group', 'This is my option value.');
		register_setting( 'idl_keys_options_group', 'keys_reminer_email','delivery_callback' );
	}

	public function get_keys() {
		$get_byuser = sanitize_text_field($_GET['byuser']);
		$keys = $this->model->get_all_keys($get_byuser);
		echo json_encode(array('data' => $keys));
		exit;
	}

	public function getcustomer_emp() {
		$customers = get_users( [ 'role__in' => [ 'customer'] ] );
		$allcustomers = array();
		foreach ($customers as $key => $value) {
			$allcustomers[$key]['id'] = $value->ID;
			$allcustomers[$key]['name'] = $value->display_name;
		}
		$employees = get_users( [ 'role__in' => [ 'donation_employee'] ] );
		$allemployees = array();
		foreach ($employees as $key => $value) {
			$allemployees[$key]['id'] = $value->ID;
			$allemployees[$key]['name'] = $value->display_name;
		}
		echo json_encode(array('customers' => $allcustomers, 'employees' => $allemployees ));
		exit;
	}

	public function update_key() {
		$id = intval($_POST['id']);
		$location = sanitize_text_field($_POST['location']);
		$employee = sanitize_text_field($_POST['employee']);
		$customer = sanitize_text_field($_POST['customer']);

		if ($customer) {
			$data = [ 'location' => $_POST['location'], 'employee' => $employee, 'customer' => $customer, 'reminder_date' => ''];
		}
		else{
			$data = [ 'location' => $_POST['location'], 'employee' => $employee, 'customer' => $customer];
		}
		
		$where = ['id' => $id];
		$this->model->update_key($data, $where);
		exit;
	}

	public function addkey() {
		$id = intval($_POST['id']);
		$title = sanitize_text_field( $_POST['title'] );
		$color = sanitize_text_field( $_POST['color'] );
		if($id) {
			$where = ['id' => $id];
			$data = ['title' => $title, 'key_color' => $color];
			$this->model->update_key($data, $where);
		}
		else {
			$data = ['title' => $title, 'key_color' => $color, 'location' => 'office', 'employee' => '', 'customer' => ''];
			return $this->model->addkey($data);
		}
		exit;
	}
	public function send_cus_mail() {
		$user_id = sanitize_text_field($_GET['user_id']);
		$keyid = sanitize_text_field($_GET['keyid']);
		$date = date("Y/m/d");
		$data = ['reminder_date' => $date];
		$where = ['id' => $keyid];
		$keys_reminder = $this->model->keys_reminder($data, $where);
		//$keys_reminder = keys_reminder($user_id);
		$user_info = get_userdata($user_id);
		$name = $user_info->first_name.' '.$user_info->last_name;
		$email_data = get_option('keys_reminer_email');
		$new_data = explode("/",$email_data);
		$to =  $user_info->user_email;
		$headers = array('Content-Type: text/html; charset=UTF-8');
		$search_val = '[username]';
		$replace_str = $name;
		$use = str_replace($search_val, $replace_str, $new_data);
		$subject = "Erinnerung: Schlüsselrückgabe Stocherkahn";
		ob_start();
		include 'partials/customermail.php';
		$message = ob_get_contents();
		ob_get_clean();
		wp_mail( $to, $subject, $message, $headers);
		exit;
	}

	public function delete_key() {
		$key_id = sanitize_text_field($_GET['key_id']);
		$where  = array('id' => $key_id);
		$delete_key = $this->model->delete_key($where);
		echo json_encode(array('msg' => 'deleted successfully'));
		exit;
	}
}
