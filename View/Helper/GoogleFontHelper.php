<?php
class GoogleFontHelper extends AppHelper {
	public $helpers = array('Html');

	public $defaults = array();

	public $baseUrl = 'http://fonts.googleapis.com/css';

	public function __construct(View $View, $settings = array()) {
		foreach (array('defaults', 'baseUrl') as $setting) {
			if (isset($settings[$setting])) {
				$this->$setting = $settings[$setting];
			}
		}

		parent::__construct($View, $settings);
	}

	public function link($family, $params = array()) {
        $result = '';

        foreach ((array) $family as $fam) {
            $result .= $this->Html->css($this->url($fam, $params), null, array('inline' => true));
        }

		return $result;
	}

	public function url($family, $params = array(), $mergeDefaults = true) {
		if ($mergeDefaults) {
			$params = array_merge($this->defaults, $params);
		}

		$url = $this->baseUrl;

		$url .= '?family='.str_replace(' ', '+', $family);

		foreach ($params as $key => $val) {
			$url .= '&';

			if (!is_numeric($key)) {
				$url .= $key . '=';
			}

			$url .= $val;
		}

		return $url;
	}
}
?>