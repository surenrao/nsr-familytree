<?php
class UtilityController extends CustomControllerAction
{
	public function captchaAction()
	{
		// check for existing phrase in session
		$session = new Zend_Session_Namespace('captcha');
		$phrase = null;
//		commented to change phrase 
//		if (isset($session->phrase) && strlen($session->phrase) > 0)
//			$phrase = $session->phrase;
		
		$captcha = Text_CAPTCHA::factory('Image');
		$opts = array('font_size' => 20,
			'font_path' => Zend_Registry::get('config')->paths->data,
			'font_file' => 'VeraBd.ttf',
			'text_color'       => '#DDFF99',
    		'lines_color'      => '#CCEEDD',
    		'background_color' => '#555555');
		
		$captcha->init(120, 60, $phrase, $opts);
		// write the phrase to session
		$session->captcha_phrase = $captcha->getPhrase();
//		$_SESSION['captcha']['captcha_phrase'] = $captcha->getPhrase();
		// disable auto-rendering since we're outputting an image
		$this->_helper->viewRenderer->setNoRender();
		header('Content-type: image/png');
		echo $captcha->getCAPTCHAAsPng();
	}
	

}
?>