<?php
/**
 * @package MerchiPlugin
 */

namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
	public $settings;

	public $callbacks;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setPages();

		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Settings' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() 
	{
        $icon = $this->plugin_url . 'images/merchi-icon.svg';
		$this->pages = array(
			array(
				'page_title' => 'Merchi Plugin', 
				'menu_title' => 'Merchi', 
				'capability' => 'manage_options', 
				'menu_slug' => 'merchi_plugin', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => $icon, 
				'position' => 110
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'merchi_plugin', 
				'page_title' => 'Fetch page', 
				'menu_title' => 'Fetch', 
				'capability' => 'manage_options', 
				'menu_slug' => 'merchi_fetch', 
				'callback' => array( $this->callbacks, 'adminCpt' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'merchi_options_group',
				'option_name' => 'merchi_url',
				'callback' => array( $this->callbacks, 'merchiOptionsGroup' )
			),
			array(
				'option_group' => 'merchi_options_group',
				'option_name' => 'merchi_mount_point_id',
				'callback' => array( $this->callbacks, 'merchiOptionsGroup' )
			),
			array(
				'option_group' => 'merchi_options_group',
                'option_name' => 'woo_k_s',
                'callback' => array( $this->callbacks, 'merchiOptionsGroup' )
            ),
            array(
				'option_group' => 'merchi_options_group',
                'option_name' => 'woo_k_p',
                'callback' => array( $this->callbacks, 'merchiOptionsGroup' )
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'merchi_admin_index',
				'title' => 'Settings',
				'callback' => array( $this->callbacks, 'merchiAdminSection' ),
				'page' => 'merchi_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
            array(
				'id' => 'merchi_url',
				'title' => 'Merchi URL',
				'callback' => array( $this->callbacks, 'merchiStoreUrl' ),
				'page' => 'merchi_plugin',
				'section' => 'merchi_admin_index',
				'args' => array(
					'label_for' => 'merchi_url',
					'class' => 'example-class'
				)
			),
			array(
				'id' => 'merchi_mount_point_id',
				'title' => 'Mount point class',
				'callback' => array( $this->callbacks, 'merchiMountPointId' ),
				'page' => 'merchi_plugin',
				'section' => 'merchi_admin_index',
				'args' => array(
					'label_for' => 'merchi_mount_point_id',
					'class' => 'example-class'
				)
            ),
            array(
				'id' => 'woo_k_p',
				'title' => 'Woocommerce Public Key',
				'callback' => array( $this->callbacks, 'wooPublic' ),
				'page' => 'merchi_plugin',
				'section' => 'merchi_admin_index',
				'args' => array(
					'label_for' => 'woo_k_p',
					'class' => 'example-class'
				)
                ),
			array(
				'id' => 'woo_k_s',
				'title' => 'Woocommerce Secret Key',
				'callback' => array( $this->callbacks, 'wooSecret' ),
				'page' => 'merchi_plugin',
				'section' => 'merchi_admin_index',
				'args' => array(
					'label_for' => 'woo_k_s',
					'class' => 'example-class'
				)
			),
		);

		$this->settings->setFields( $args );
	}
}