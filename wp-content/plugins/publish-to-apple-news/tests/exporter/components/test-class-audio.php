<?php

require_once __DIR__ . '/class-component-testcase.php';

use \Exporter\Components\Audio as Audio;

class Audio_Test extends Component_TestCase {

	public function testGeneratedJSON() {
		$workspace = $this->prophet->prophesize( '\Exporter\Workspace' );

		// Pass the mock workspace as a dependency
		$component = new Audio( '<audio><source src="http://someurl.com/audio-file.mp3?some_query=string"></audio>',
			$workspace->reveal(), $this->settings, $this->styles, $this->layouts );

		$json = $component->to_array();
		$this->assertEquals( 'audio', $json['role'] );
		$this->assertEquals( 'http://someurl.com/audio-file.mp3?some_query=string', $json['URL'] );
	}

}

