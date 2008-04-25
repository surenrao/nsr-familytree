{include file='header.tpl'}
<div id="content">
<!-- Start Editing -->

<ul id="internal_menu">
<li><a href="/admin/">Administrator</a></li>
<li><a href="/account/">Change Password</a></li>
<li><a href="/account/">Update Profile</a></li>
</ul>

<h1>My Account</h1>
<h2>Welcome {$user->username}</h2>

<p> First Name: {$userInfo->firstName}<br/>
Last Name: {$userInfo->lastName}<br/>
Date of Birth: {$userInfo->dateOfBirth}<br/>
Email: {$userInfo->email}<br/>
Phone: {$userInfo->phone}<br/>
Address: {$userInfo->address}<br/>
City: {$userInfo->city}<br/>
State: {$userInfo->state}<br/>
Zip: {$userInfo->pinCode}<br/>
Country: {$userInfo->country}
</p>

<!-- Stop Editing  -->
</div>
{include file='menu.tpl'}
{include file='footer.tpl'}