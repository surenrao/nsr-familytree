<div id="menu">
<h1>Menu</h1>
<p><a href='/index'>Home</a></p>
<p><a href='/display'>Family Tree</a></p>
<p><a href='/account'>My Account</a></p>
{if @$isLoggedIn}
<p><a href='/account/logout'>Logout</a></p>
{else}	
<p><a href='/account/login'>Login</a></p>
{/if}

</div>
