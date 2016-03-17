<?php

use \Exporter\Exporter_Content as Exporter_Content;
use \Exporter\Settings as Settings;
use \Exporter\Builders\Component_Layouts as Component_Layouts;
use \Exporter\Builders\Component_Text_Styles as Component_Text_Styles;

abstract class Component_TestCase extends PHPUnit_Framework_TestCase {

	protected $prophet;

	protected function setup() {
		$this->prophet  = new \Prophecy\Prophet;
		$this->settings = new Settings();
		$this->content  = new Exporter_Content( 1, __( 'My Title', 'apple-news' ), '<p>' . __( 'Hello, World!', 'apple-news' ) . '</p>' );
		$this->styles   = new Component_Text_Styles( $this->content, $this->settings );
		$this->layouts  = new Component_Layouts( $this->content, $this->settings );
	}

	protected function tearDown() {
		$this->prophet->checkPredictions();
	}

	protected function build_node( $html ) {
		// Because PHP's DomDocument doesn't like HTML5 tags, ignore errors.
		$dom = new \DOMDocument();
		libxml_use_internal_errors( true );
		$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html );
		libxml_clear_errors( true );

		// Find the first-level nodes of the body tag.
		return $dom->getElementsByTagName( 'body' )->item( 0 )->childNodes->item( 0 );
	}

}
