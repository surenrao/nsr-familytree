{include file='header.tpl'}
{literal}
<style>
label
{
	display: block;  		
	margin: 0 5px 0 0;	
	color: #000000;	
}

input[type=text], input[type=password]
{
	width: 200px;
	margin: 0 5px 0 0;	
} 

.errorText
{
	font-family:courier;
	color:red;	
}

ul 
{
	margin: 0;
	padding: 0;
	display: inline;
} 

ul li 
{
	margin: 5px 0  0 12px;
	padding-left:0;	
}

fieldset
{
	border:none;
}

</style>
{/literal}

<div id="content">
<!-- Start Editing -->
<h1>Forgot Password?</h1>
<div id="fetchpassword">
<form action="/account/fetchpassword" method="post">
<fieldset>
<p class="errorText"{if !$error} style="display: none"{/if}>
An error has occurred in the form below. Please check
the highlighted fields and resubmit the form.
</p>

<fieldset>
<label for="email">Email:</label>
<input type="text" name="email" id="email" />
{include file='error_div.tpl' error=$error.email}
</fieldset>

<fieldset>
<input type="submit" id="submit" name="submit" value="Submit" />
<input type="reset" name="Reset" value="Cancel" tabindex="4" onclick="javascript:document.location.href='/account/login';">
</fieldset>

</fieldset>
</form>
</div>
<br/>
<br/>
<br/>


<!-- Stop Editing  -->
</div>
{include file='menu.tpl'}
{include file='footer.tpl'}