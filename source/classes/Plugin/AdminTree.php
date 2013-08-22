<?php
class Plugin_AdminTree extends Plugin {
	public function output(\Pagemill_Data $data, \Pagemill_Stream $stream) {
		$this->pluginTemplate = '/admin/admintree.plug.html';
		$data = $data->fork();
		$apps = array();
		foreach (Typeframe::Registry()->pages() as $page) {
			if (strpos($page->uri(), TYPEF_WEB_DIR . '/admin/') === 0) {
				$category = ($page->application()->category() ? $page->application()->category() : 'Other');
				if (!isset($apps[$category])) $apps[$category] = array();
				$apps[$category][] = array(
					'title' => $page->title(),
					'icon' => $page->icon(),
					'uri' => $page->uri()
				);
			}
		}
		ksort($apps);
		$categories = array();
		foreach ($apps as $category => $applications) {
			$categories[] = array(
				'name' => $category,
				'applications' => $applications
			);
		}
		$data['categories'] = $categories;
		parent::output($data, $stream);
	}
}
