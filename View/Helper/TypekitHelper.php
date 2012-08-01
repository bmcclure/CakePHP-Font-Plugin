<?php
class TypekitHelper extends AppHelper {
	public $helpers = array('Html');

	public $settings = array(
		'baseUrl' => 'http://use.typekit.com/',
		'kitId' => null,
		'loadCode' => 'Typekit.load();',
		'catchCode' => 'catch(e){}',
		'tryBlock' => true,
		'inline' => true,
	);

	public function __construct(View $View, $settings = array()) {
		$this->settings = array_merge($this->settings, $settings);

		parent::__construct($View, $settings);
	}

	public function loadCode() {
		extract($this->settings);

		$output = '';

		if ($tryBlock && !empty($catchCode)) {
			$output .= 'try{';
		}

		$output .= $loadCode;

		if ($tryBlock && !empty($catchCode)) {
			$output .= '}'.$catchCode;
		}

		return $output;
	}

	public function loadCodeBlock() {
		return $this->Html->codeBlock($this->loadCode(), array('inline' => $inline));
	}

	public function kitUrl() {
		if (is_null($this->settings['kitId']) || !is_string($this->settings['kitId'])) {
			return null;
		}

		return $this->settings['baseUrl'].$this->settings['kitId'].'.js';
	}

	public function kitLink() {
		if (is_null($this->settings['kitId']) || !is_string($this->settings['kitId'])) {
			return null;
		}

		return $this->Html->script($this->kitUrl(), array('inline' => $this->settings['inline']));
	}

	public function setGlobals(&$assets) {
		if (is_null($assets) || !is_array($assets)) {
			return;
		}

		if (!isset($assets['globals'])) {
			$assets['globals'] = array();
		}

		$assets['globals']['typekitUrl'] = $this->kitUrl();
		$assets['globals']['typekitCode'] = $this->loadCode();
	}
}
?>