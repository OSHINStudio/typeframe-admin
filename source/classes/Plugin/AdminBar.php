<?php
class Plugin_AdminBar extends Plugin {
	public function __construct($name, array $attributes = array(), \Pagemill_Tag $parent = null, \Pagemill_Doctype $doctype = null) {
		parent::__construct($name, $attributes, $parent, $doctype);
		$this->pluginTemplate = '/admin/adminbar.plug.html';
	}
	public function output(Pagemill_Data $data, Pagemill_Stream $stream) {
		$data = $data->fork();
		$apps = array();
		foreach (Typeframe::Registry()->pages() as $page) {
			if ($page->siteid() == Typeframe::CurrentPage()->siteid()) {
				if (strpos($page->uri(), '/admin/') !== false) {
					$apps[] = array(
						'title' => $page->title(),
						'icon' => $page->icon(),
						'uri' => $page->uri()
					);
				}
			}
		}
		$data['applications'] = $apps;
		$data->sortNodes(array('applications', 'title'));
		parent::output($data, $stream);
	}
}
