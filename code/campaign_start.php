<?php
    $sessObj = new session();

	if (!$sessObj->state) {
    	redirect_to("index.php");
	}

	$id = session::getUserID();
	$newuser = new user($id);

	//check if addding a campaign is a right
	/*
	if (!isset($newuser->access[ADD_CAMPAIGN])) {
		redirect_to("_404.php");
	}

	*/

	//validate the call
	if(isset($_POST['from']) && trim($_POST['from'])!="")
		$from = $_POST['from'];
	else
	{
		//get the default value
	}
	if(isset($_POST['subject'])&& trim($_POST['subject'])!="")
	{
		$subject = $_POST['subject'];
	}
	else
	{
		//get the default subject
	}
	$success = true;
	$err = "";
	if(isset($_POST['secret_key']))
	{
		//validate the secret key
		$result = database::SQL("SELECT `secret` FROM `admin` where `id` = ?" , array('i' , $id));
		if($result[0]['secret']!=$_POST['secret_key'])
		{
			$err = "Invalid secret key";
			$success = false;
		}
		else
		{
			$secret_key = $_POST['secret_key'];
		}
	}
	
	$api = $_POST['api'];
	//redirect if there is an error
	$noOfMails = $_POST['NO_Mails'];
	if(!$success)
		redirect_to('campaign_create.php?err='.$err);
	// get the template id
	$result = database::SQL("SELECT `template_id` FROM  `api` WHERE `code` = ? LIMIT 1" , array('s' , $api));
	$template_id = $result[0]['template_id'];
	//get the parameters
	$params = database::SQL("SELECT `name` FROM  `api_params` WHERE `template_id` = ?" , array('i' , $template_id));

	$_CAMPAIGN_START_ = true;
?>