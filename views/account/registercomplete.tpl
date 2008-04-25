{include file='header.tpl'}
<div id="content">
<!-- Start Editing -->

<h1>{$userProfile->first_name}, Thank You For Your Registration</h1>
<pre>
Dear {$userProfile->first_name},

Note: this should be sent as email.

Thank you for your registration. Your login details are as follows:

	Login URL: <a href="http://{$smarty.server.SERVER_NAME}/account/activate/username/{$user->username}/passcode/{$user->activationCode}">http://{$smarty.server.SERVER_NAME}/account/activate/username/{$user->username}/passcode/{$user->activationCode}</a>
	Username : {$user->username}
	Password : ****

Sincerely,

Web Site Administrator
</pre>
<br/>
<br/>
<br/>

<!-- Stop Editing  -->
</div>
{include file='menu.tpl'}
{include file='footer.tpl'}