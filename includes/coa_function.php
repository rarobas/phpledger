<?php
if ( (isset($_SESSION['is_logged'])) AND ($_SESSION['is_logged'] == 1)) {
					$username = get_user_name($_SESSION['user_id']);
					$role_id = getUserRoleID($_SESSION['user_id']);
				}
if(isset($_GET['coa_id'])){
						$coa_id = $_GET['coa_id'];
						$group_id = $_GET['group_id'];
					}
	$group_id = "";
	$from_account_code='';
	$to_account_code='';
if (isset($_GET['group_id'])) {
							$group_id = $_GET['group_id']; 
							$from_account_code = get_from_account_code($group_id, 'group');
							$to_account_code = get_to_account_code($group_id, 'group');
						}
if (isset($_GET['parent_account_id'])) {
									$parent_account_id = $_GET['parent_account_id']; 
									//$from_account_code = get_from_account_code($parent_account_id , 'account');
									//$to_account_code = get_to_account_code($parent_account_id, 'account');
								}

$now=date("Y-m-d h:i:sa");
	$message= "";

// Function to Add a new Record
function add_coa($account_code,$account_group,$account_desc_short, $account_desc_long, $parent_account_id,$account_status){
$insert	= DB::Insert(DB_PREFIX.$_SESSION['co_prefix'].'coa',array(
			'account_code' => $account_code,
			'account_group' => $account_group,
			'account_desc_short' => $account_desc_short,
			'account_desc_long' => $account_desc_long,
			'parent_account_id' => $parent_account_id,
			'last_modified_by' => $username,
			'last_modified_on' => $now,
			'created_by' => $username,
			'created_on' => $now,
			'account_status' => $account_status)  );
			$new_coa_id =DB::insertId();
			return $new_coa_id;
}
//// Function to update a record
function update_coa($account_code,$account_group,$account_desc_short, $account_desc_long, $parent_account_id,$account_status){
	$edit	= DB::UPDATE(DB_PREFIX.$_SESSION['co_prefix'].'coa',array(
				'account_code' => $account_code,
				'account_group' => $account_group,
				'account_desc_short' => $account_desc_short,
				'account_desc_long' => $account_desc_long,
				'parent_account_id' => $parent_account_id,
				'last_modified_by' => $user_name,
				'last_modified_on' => $now,
				'account_status' => $account_status), "account_id =%s", $coa_id );
				$coa_id =DB::insertId();
				return $coa_id;
}			
///////Add New  			
if(isset($_POST['add'])){
							$account_code= $_POST['account_code'];
							$account_group = $_POST['account_group'];
							$account_desc_short = $_POST['account_desc_short'];
							$account_desc_long = $_POST['account_desc_long'];
							$parent_account_id = $_POST['parent_account_id'];
							$account_status = $_POST['account_status'];
							$new_coa_id	=add_coa($account_code,$account_group,$account_desc_short, $account_desc_long, $parent_account_id,$account_status);
							if ($new_coa_id) {
							$message = "Successfully Added Chart Of Account";
 							echo '<div id="success-alert" class="alert alert-success">
   							<a href="#" class="close" data-dismiss="alert">
      							&times;
   							</a>
   							<strong>Updated!</strong> Data Saved Succesfully.
						 	</div>';
											}
										else {
												$erro_message = "Unable to create , Check your Input!";
											}
						}
						else {

								/* Retrive logged in user data */
								$account_code= '';
								$account_group = '';
								$account_desc_short = '';
								$account_desc_long = '';
								$parent_account_id = '';
								$account_status = '';
							}
if(isset($_POST['update'])){	
								$coa_id	=$_GET['id'];
								$account_code	= 	$_POST['account_code'];
								$account_group 	= 	$_POST['account_group'];
								$account_desc_short = $_POST['account_desc_short'];
								$account_desc_long 	= $_POST['account_desc_long'];
								$parent_account_id 	= $_POST['parent_account_id'];
								$account_status 	= 	$_POST['account_status'];
								$update = update_coa($account_code,$account_group,$account_desc_short, $account_desc_long, $parent_account_id,$account_status);
								if ($update) {
								echo '<div id="success-alert" class="alert alert-success">
										<a href="#" class="close" data-dismiss="alert">
										&times;
										</a>
									  Created Successfully.
									</div>';
											} 
								else {
								$erro_message = "Unable to create , Check your Input!";
									}		
		
							}
							 else {

							/* Retrive logged in user data */
								$sql_coa = "SELECT * FROM ".DB_PREFIX.$_SESSION['co_prefix']."coa WHERE account_id ='".$coa_id."'";
								$coa_info = DB::queryFirstRow($sql_coa);
								$account_code= $coa_info['account_code'];
								$account_group = $coa_info['account_group'];
								$account_desc_short = $coa_info['account_desc_short'];
								$account_desc_long = $coa_info['account_desc_long'];
								$parent_account_id = $coa_info['parent_account_id'];
								$account_status = $coa_info['account_status'];
							}							
		

		
	
?>