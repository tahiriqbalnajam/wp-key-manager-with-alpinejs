<?php
class idlkeysmodel
{
	private $table;
	
	public function __construct(){
		global $wpdb;
		$this->table = $wpdb->prefix.'idl_keys'; 
	}
	
	public function get_all_keys($get){
		global $wpdb;
		$user = wp_get_current_user();
		$current_user_id = $user->ID;
		if ($get == "byuser") {   
			$visit_type = $wpdb->get_results("SELECT * FROM ".$this->table." where employee = ".$current_user_id." OR customer = ".$current_user_id, OBJECT);
		}
		else if ($get == "pending") {   
			$visit_type = $wpdb->get_results("SELECT * FROM ".$this->table." where location = 'customer' AND customer != '' ", OBJECT);
		}
		else{
			$visit_type = $wpdb->get_results("SELECT * FROM ".$this->table, OBJECT);
		}
		
		//echo $wpdb->last_query;
		return $visit_type;
	}
	public function update_key($data, $where) {
		global $wpdb;
		$updated = $wpdb->update( $this->table, $data, $where );
		return $updated;
	}

	public function addkey($data) {
		global $wpdb;
		$wpdb->insert($this->table, $data);
		return $wpdb->insert_id;
	}

	public function delete_key($where) {
		global $wpdb;
        $wpdb->delete($this->table ,$where);
        //echo $wpdb->last_query;
	}

	public function keys_reminder($data, $where) {
		global $wpdb;
		$updated = $wpdb->update( $this->table, $data, $where );
		return $updated;
	}
	
}