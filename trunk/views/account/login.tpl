{include file='header.tpl'}
<link type="text/css" rel="stylesheet" href="/css/forms.css" />
<div id="content">
<br/>
<br/>
<br/>
<form action="/account/login" method="post">
<fieldset>
<legend>Log In to My Account</legend>
<div class="errorText"{if !$error} style="display: none"{/if}>
An error has occurred in the form below. Please check
the highlighted fields and resubmit the form.
</div>

<input type="hidden" name="redirect" value="{$redirect|escape}" />
<div class="label_element">
<label for="username">Username:</label> <input type="text" id="username" name="username" value="{$formData.username}" />
{include file='error_div.tpl' error=$error.User}
</div>

<div class="label_element">
<label for="password">Password:</label> <input type="password" id="password" name="password" />
{include file='error_div.tpl' error=$error.Paswd}
</div>
<p class="label_radio">
<label for="remember" class="labelradio"><input type="checkbox" id="remember" name="remember" value="1"> Remember Me </label>
</p>
</fieldset>

<p class="para_button">
<input type="submit" id="login" name="login" value="Login" />
<input type="reset" name="Reset" value="Cancel" tabindex="4" onclick="javascript:history.back();">
</p>

<div style="font-size: 14px;margin: 30px 0 0 165px;">
<a href="/account/register">Register</a> | <a href="/account/fetchpassword">Forgot password?</a>
</div>
</form>
<br/>
<br/>
<br/>
<!-- Stop Editing  -->
</div>
{include file='menu.tpl'}
{include file='footer.tpl'}
