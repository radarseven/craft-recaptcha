# Google reCAPTCHA for Craft CMS
Craft plugin to dispaly Google's new reCaptcha form widget and validate responses.

##Install
1. Upload entire recaptcha directory to craft/plugins on your server.
2. Navigate to your site's Plugin settings from the Control Panel.
3. Click Install
4. Click on the 'reCAPTCHA for Craft' link to enter in your reCAPTCHA site key and secret key. You can get both keys from the [Google reCaptcha console](http://www.google.com/recaptcha/intro/index.html). 

##Usage
###Templates
#### `render`
##### Render a Single Widget
To display a reCAPTCHA widget in any template, use `{{craft.recaptcha.render()}}`.

#### `renderMultiple`
##### [Render Multiple Widgets Explicitly](https://developers.google.com/recaptcha/docs/display#explicit_render)
If you need to render multiple unique widgets on a page, use the `renderMultiple` method. This method takes one argument, which is an array of HTML element ID's that should be rendered as widgets.
 
In the example below, the three `<div>`s will be rendered as widgets.

    <div id="widget-1"></div>
    <div id="widget-2"></div>
    <div id="widget-3"></div>
    {{ craft.recaptcha.renderMultiple(['widget-1', 'widget-2', 'widget-3']) }}
    
**Note:** The `render` and `renderMultiple` methods should not be used on the same page/template. The API script is automatically injected with each method.

#### `getSiteKey`
##### Plugin Settings
In some cases, you may need to manually render widget(s) using the Javascript [API](https://developers.google.com/recaptcha/docs/display#js_api). To do this, you'll need the API `sitekey`. You can use the `getSiteKey` method to return the `sitekey` from the plugin's settings.

    {{ craft.recaptcha.getSiteKey }}

###User Registration Form
To use the Recaptcha in a front-end [User Registration](http://buildwithcraft.com/docs/templating/user-registration-form) form, simply do this:

	<form method="post" accept-charset="UTF-8" >
	    {{ getCsrfInput() }}
	    <input type="hidden" name="action" value="recaptcha/service/saveUser">

...and assuming it passes Recaptcha validation, the user registration will be passed along to `users/saveUser`

###Verification
To verify a user's input, call the plugin's verify service from your own plugin: 
	
	$captcha = craft()->request->getPost('g-recaptcha-response');
	$verified = craft()->recaptcha_verify->verify($captcha);
	if($verified)
	{
		//User is a person, not a robot. Go on and process the form!
	} else {
		//Uh oh...its a robot. Don't process this form! 
	}

##Roadmap
Currently this only supports the standard reCAPTCHA widget, but I hope to add some capabilities to adjust the styling and functionality.
