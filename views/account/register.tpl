{include file='header.tpl'}
<div id="content">
<!-- Start Editing -->
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

<h1>Register</h1>
<div id="register">
<form action="/account/register" method="post">
<fieldset>
<p class="errorText"{if !$error} style="display: none"{/if}>
An error has occurred in the form below. Please check
the highlighted fields and resubmit the form.
</p>
<fieldset>
<label for="username">*Username:</label>
<input type="text" name="username" id="username" value="{$formData.username}"/>
{include file='error_div.tpl' error=$error.username}
</fieldset>

<fieldset>
<label for="password">*Password:</label>
<input type="password" name="password" id="password" />
{include file='error_div.tpl' error=$error.password}
</fieldset>

<fieldset>
<label for="confirmpassword">*Confirm Password:</label>
<input type="password" name="confirmpassword" id="confirmpassword" />
{include file='error_div.tpl' error=$error.confirmpassword}
</fieldset>

<fieldset>
<label for="firstname">*Firstname:</label>
<input type="text" name="firstname" id="firstname" value="{$formData.firstname}"/>
{include file='error_div.tpl' error=$error.firstname}
</fieldset>

<fieldset>
<label for="lastname">*Lastname:</label>
<input type="text" name="lastname" id="lastname" value="{$formData.lastname}"/>
{include file='error_div.tpl' error=$error.lastname}
</fieldset>

<fieldset>
<label for="email">*Email:</label>
<input type="text" name="email" id="email" value="{$formData.email}"/>
{include file='error_div.tpl' error=$error.email}
</fieldset>

<fieldset>
<label for="dobMonth">*Birthday:</label>
{html_select_date prefix='dob' start_year='-40' reverse_years=true time=$dob
month_extra='id="dobMonth"' day_extra='id="dobDay"' year_extra='id="dobYear"'}
{include file='error_div.tpl' error=$error.dob}
</fieldset>

<fieldset>
<img src="/utility/captcha" alt="CAPTCHA image" />
<label for="form_captcha">Enter Above Phrase:</label>
<input type="text" id="captcha" name="captcha" value="{$formData.captcha}" />
{include file='error_div.tpl' error=$error.captcha}
</fieldset>

<fieldset>
<input type="submit" id="submit" name="submit" value="Register" />
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