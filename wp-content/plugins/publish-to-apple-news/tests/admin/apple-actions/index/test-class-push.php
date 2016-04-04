<?php

use \Apple_Actions\Index\Push as Push;
use \Apple_Actions\Action_Exception as Action_Exception;
use \Apple_Exporter\Settings as Settings;
use \Prophecy\Argument as Argument;

class Admin_Action_Index_Push_Test extends WP_UnitTestCase {

	private $prophet;

	private $original_user_id;

	private $component_message = 'The following components are unsupported by Apple News and were removed: iframe';

	public function setup() {
		parent::setup();

		$this->prophet = new \Prophecy\Prophet;
		$this->settings = new Settings();
		$this->settings->set( 'api_key', 'foo' );
		$this->settings->set( 'api_secret', 'bar' );
		$this->settings->set( 'api_channel', 'baz' );

		$this->original_user_id = get_current_user_id();
	}

	public function tearDown() {
		wp_set_current_user( $this->original_user_id );
		$this->prophet->checkPredictions();
	}

	protected function dummy_response() {
		$response = new stdClass;
		$response->data = new stdClass;
		$response->data->id = uniqid();
		$response->data->createdAt = time();
		$response->data->modifiedAt = time();
		$response->data->shareUrl = 'http://test.url/some-path';
		$response->data->revision = uniqid();
		return $response;
	}

	protected function set_admin() {
		$user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );
		if ( function_exists( 'grant_super_admin' ) ) {
			grant_super_admin( $user_id );
		}
		wp_set_current_user( $user_id );
		return $user_id;
	}

	public function testCreate() {
		$response = $this->dummy_response();
		$api = $this->prophet->prophesize( '\Apple_Push_API\API' );
		$api->post_article_to_channel( Argument::cetera() )
			->willReturn( $response )
			->shouldBeCalled();

		// Create post
		$post_id = $this->factory->post->create();

		$action = new Push( $this->settings, $post_id );
		$action->set_api( $api->reveal() );
		$action->perform();

		$this->assertEquals( $response->data->id, get_post_meta( $post_id, 'apple_news_api_id', true ) );
		$this->assertEquals( $response->data->createdAt, get_post_meta( $post_id, 'apple_news_api_created_at', true ) );
		$this->assertEquals( $response->data->modifiedAt, get_post_meta( $post_id, 'apple_news_api_modified_at', true ) );
		$this->assertEquals( $response->data->shareUrl, get_post_meta( $post_id, 'apple_news_api_share_url', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_deleted', true ) );
	}

	public function testUpdate() {
		$response = $this->dummy_response();
		$api = $this->prophet->prophesize( '\Apple_Push_API\API' );
		$api->update_article( "123", Argument::Any(), Argument::Any(), array() )
			->willReturn( $response )
			->shouldBeCalled();

		$api->get_article( "123" )
			->willReturn( $response )
			->shouldBeCalled();

		// Create post, simulate that the post has been synced
		$post_id = $this->factory->post->create();
		update_post_meta( $post_id, 'apple_news_api_id', 123 );

		$action = new Push( $this->settings, $post_id );
		$action->set_api( $api->reveal() );
		$action->perform();

		$this->assertEquals( $response->data->id, get_post_meta( $post_id, 'apple_news_api_id', true ) );
		$this->assertEquals( $response->data->createdAt, get_post_meta( $post_id, 'apple_news_api_created_at', true ) );
		$this->assertEquals( $response->data->modifiedAt, get_post_meta( $post_id, 'apple_news_api_modified_at', true ) );
		$this->assertEquals( $response->data->shareUrl, get_post_meta( $post_id, 'apple_news_api_share_url', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_deleted', true ) );
	}

	public function testComponentErrorsNone() {
		$this->settings->set( 'component_alerts', 'none' );

		$response = $this->dummy_response();
		$api = $this->prophet->prophesize( '\Apple_Push_API\API' );
		$api->post_article_to_channel( Argument::cetera() )
			->willReturn( $response )
			->shouldBeCalled();

		// We need to create an iframe, so run as administrator
		$user_id = $this->set_admin();

		// Create post
		$post_id = $this->factory->post->create( array(
			'post_content' => '<p><iframe width="460" height="460" src="http://unsupportedservice.com/embed.html?video=1232345&autoplay=0" frameborder="0" allowfullscreen></iframe></p>',
		) );

		$action = new Push( $this->settings, $post_id );
		$action->set_api( $api->reveal() );
		$action->perform();

		// The post was still quietly sent to Apple News despite the removal of the iframe
		$this->assertEquals( $response->data->id, get_post_meta( $post_id, 'apple_news_api_id', true ) );
		$this->assertEquals( $response->data->createdAt, get_post_meta( $post_id, 'apple_news_api_created_at', true ) );
		$this->assertEquals( $response->data->modifiedAt, get_post_meta( $post_id, 'apple_news_api_modified_at', true ) );
		$this->assertEquals( $response->data->shareUrl, get_post_meta( $post_id, 'apple_news_api_share_url', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_deleted', true ) );
	}

	public function testComponentErrorsWarn() {
		$this->settings->set( 'component_alerts', 'warn' );

		$response = $this->dummy_response();
		$api = $this->prophet->prophesize( '\Apple_Push_API\API' );
		$api->post_article_to_channel( Argument::cetera() )
			->willReturn( $response )
			->shouldBeCalled();

		// We need to create an iframe, so run as administrator
		$user_id = $this->set_admin();

		// Create post
		$post_id = $this->factory->post->create( array(
			'post_content' => '<p><iframe width="460" height="460" src="http://unsupportedservice.com/embed.html?video=1232345&autoplay=0" frameborder="0" allowfullscreen></iframe></p>',
		) );

		$action = new Push( $this->settings, $post_id );
		$action->set_api( $api->reveal() );
		$action->perform();

		// An admin error notice was created
		$notices = get_user_meta( $user_id, 'apple_news_notice', true );
		$this->assertNotEmpty( $notices );

		$component_notice = end( $notices );
		$this->assertEquals( $this->component_message, $component_notice['message'] );

		// The post was still sent to Apple News
		$this->assertEquals( $response->data->id, get_post_meta( $post_id, 'apple_news_api_id', true ) );
		$this->assertEquals( $response->data->createdAt, get_post_meta( $post_id, 'apple_news_api_created_at', true ) );
		$this->assertEquals( $response->data->modifiedAt, get_post_meta( $post_id, 'apple_news_api_modified_at', true ) );
		$this->assertEquals( $response->data->shareUrl, get_post_meta( $post_id, 'apple_news_api_share_url', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_deleted', true ) );
	}

	/**
	 * @expectedException \Apple_Actions\Action_Exception
	 */
	public function testComponentErrorsFail() {
		$this->settings->set( 'component_alerts', 'fail' );

		$response = $this->dummy_response();
		$api = $this->prophet->prophesize( '\Apple_Push_API\API' );
		$api->post_article_to_channel( Argument::cetera() )
			->willReturn( $response )
			->shouldNotBeCalled();

		// We need to create an iframe, so run as administrator
		$user_id = $this->set_admin();

		// Create post
		$post_id = $this->factory->post->create( array(
			'post_content' => '<p><iframe width="460" height="460" src="http://unsupportedservice.com/embed.html?video=1232345&autoplay=0" frameborder="0" allowfullscreen></iframe></p>',
		) );

		$action = new Push( $this->settings, $post_id );
		$action->set_api( $api->reveal() );
		$action->perform();

		// An admin error notice was created
		$notices = get_user_meta( $user_id, 'apple_news_notice', true );
		$this->assertNotEmpty( $notices );

		$component_notice = end( $notices );
		$this->assertEquals( $this->component_message, $component_notice['message'] );

		// The post was not sent to Apple News
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_id', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_created_at', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_modified_at', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_share_url', true ) );
		$this->assertEquals( null, get_post_meta( $post_id, 'apple_news_api_deleted', true ) );
	}

}

