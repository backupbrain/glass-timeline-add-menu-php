<?php
// oauth2callback/index.php


require('../settings.php');

require_once('../classes/Google_OAuth2_Token.class.php');
require_once('../classes/Google_Timeline_Item.class.php');
	
/**
 * the OAuth server should have brought us to this page with a $_GET['code']
 */
if(isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
 
	// authenticate the user
	$Google_OAuth2_Token = new Google_OAuth2_Token();
	$Google_OAuth2_Token->code = $code;
	$Google_OAuth2_Token->client_id = $settings['oauth2']['oauth2_client_id'];
	$Google_OAuth2_Token->client_secret = $settings['oauth2']['oauth2_secret'];
	$Google_OAuth2_Token->redirect_uri = $settings['oauth2']['oauth2_redirect'];
	$Google_OAuth2_Token->grant_type = "authorization_code";

	try {
		$Google_OAuth2_Token->authenticate();
	} catch (Exception $e) {
		// handle this exception
		print_r($e);
	}

	// A user just logged in.  Let's insert a menu item with a timeline card
	if ($Google_OAuth2_Token->authenticated) {
		
		$Google_Timeline_Item = new Google_Timeline_Item($Google_OAuth2_Token);
		$Google_Timeline_Item->html = "<article><section>
			<p class=\"text-auto-size\">
				Good News!
			</p></section></article>";
			
		// add a "reply" menu item			
		$MenuItem = new Google_Menu_Item();
		$MenuItem->action = Google_Menu_Item::ACTION_REPLY;
		$Google_Timeline_Item->menuItems[] = $MenuItem;
		
		// add a custom menu item
		$MenuItem = new Google_Menu_Item();
		$MenuItem->action = Google_Menu_Item::ACTION_CUSTOM;
		$MenuItem->id = "like";
		$Value = new Google_Menu_Item_Value();
		$Value->displayName = "Like";
		$Value->iconUrl = "http://tonygaitatzis.com/glassware/bitcointicker/assets/img/like.png";
		$Value->state = Google_Menu_Item_Value::STATE_DEFAULT;
		$MenuItem->values[] = $Value;
		$Google_Timeline_Item->menuItems[] = $MenuItem;
		
		// insert the timeline item
		$Google_Timeline_Item->insert();
		
		
		
		
		
	}
}
?>
<h2>Timeline Item</h2>
<dl>
	<dt>ID</dt>
	<dd><?= $Google_Timeline_Item->id; ?></dd> 
	
	<dt>Created</dt>
	<dd><?= $Google_Timeline_Item->created; ?></dd>
	
	<dt>HTML Content</dt>
	<? if ($Google_Timeline_Item->html) { ?>
		<dd><?= $Google_Timeline_Item->html; ?></dd>
	<? } ?>
	
	<? if ($Google_Timeline_Item->attachments) { ?>
	<dt>Attachments</dt>
	<? $numAttachments = count($Google_Timeline_Item->attachments); ?>
	Found <?= $numAttachments; ?> attachment<? if ($numAttachments !== 1) { ?>s<? } ?>:
	<? foreach ($Google_Timeline_Item->attachments as $Attachment) { ?>	
		<dd><?= $Attachment->id; ?>: <?= $Attachment->contentType; ?></dd>
	<? } ?>
	<? } ?>
</dl>