<?php
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
// include the helper file
require_once(dirname(__FILE__).DS.'helper.php');
 
$user =& JFactory::getUser();

if ($user->guest) 
{
	$loginURL = '/index.php?option=com_user&view=login';
	$myurl = $_SERVER['REQUEST_URI'];
	$myurl = base64_encode($myurl);
	$myurl = '&return='.$myurl;
	header("Location: ".$loginURL.$myurl);
}
else
{
	$submitted = $_GET["submit"];
	$submitted2 = $_GET["submit2"];

	if (!empty($submitted2))
	{	
		$error = ModStarDust_LandHelper::ValidateForm();
		if (empty($error))
		{
			$STARDUST_SERVICE_URL = $params->get('STARDUST_SERVICE_URL');
			$PAYPAL_URL = $params->get('PAYPAL_URL');
			$NOTIFY_URL = $params->get('NOTIFY_URL');
			$PAYPAL_ACCOUNT = $params->get('PAYPAL_ACCOUNT');
			$RETURN_URL = $params->get('RETURN_URL');
			$DO_NOTIFICATION = $params->get('DO_NOTIFICATION');
			$NOTIFICATION_EMAIL = $params->get('NOTIFICATION_EMAIL');
			$error = ModStarDust_LandHelper::SendToPayPal($user, $PAYPAL_URL,$NOTIFY_URL,$PAYPAL_ACCOUNT,$RETURN_URL,$DO_NOTIFICATION,$NOTIFICATION_EMAIL,$STARDUST_SERVICE_URL);
			if (!empty($error))
			{
				$submitted = "yes";
			}
		}
		else $submitted = "yes";
	}
	
	$tos = $params->get('tos');
	if (empty($submitted))
	{
		$items = ModStarDust_LandHelper::GetItemsForSale();
	}
	require(JModuleHelper::getLayoutPath('mod_stardust_land'));
}


?>