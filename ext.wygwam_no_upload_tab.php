<?php if ( ! defined('APP_VER')) exit('No direct script access allowed');


/**
 * Wygwam No Upload Tab
 * 
 * @author    Brandon Kelly <brandon@pixelandtonic.com>
 * @copyright Copyright (c) 2010 Brandon Kelly
 * @license   http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 */

class Wygwam_no_upload_tab_ext {

	var $name           = 'Wygwam No Upload Tab';
	var $version        = '1.0';
	var $description    = 'Removes the “Upload” tabs from the Link, Image, and Flash dialogs, forcing authors to click the “Browse Server” buttons and upload files via CKFinder';
	var $settings_exist = 'n';
	var $docs_url       = 'http://github.com/brandonkelly/wygwam_no_upload_tab';

	/**
	 * Class Constructor
	 */
	function __construct()
	{
		// Make a local reference to the ExpressionEngine super object
		$this->EE =& get_instance();
	}

	// --------------------------------------------------------------------

	/**
	 * Activate Extension
	 */
	function activate_extension()
	{
		// add the row to exp_extensions
		$this->EE->db->insert('extensions', array(
			'class'    => 'Wygwam_no_upload_tab_ext',
			'hook'     => 'wygwam_config',
			'method'   => 'wygwam_config',
			'priority' => 10,
			'version'  => $this->version,
			'enabled'  => 'y'
		));
	}

	/**
	 * Update Extension
	 */
	function update_extension($current = '')
	{
		// Nothing to change...
		return FALSE;
	}

	/**
	 * Disable Extension
	 */
	function disable_extension()
	{
		// Remove all Wygwam_no_upload_tab_ext rows from exp_extensions
		$this->EE->db->query('DELETE FROM exp_extensions WHERE class = "Wygwam_no_upload_tab_ext"');
	}

	// --------------------------------------------------------------------

	/**
	 * wygwam_config hook
	 */
	function wygwam_config($config, $settings)
	{
		// If another extension shares the same hook,
		// we need to get the latest and greatest config
		if ($this->EE->extensions->last_call !== FALSE)
		{
			$config = $this->EE->extensions->last_call;
		}

		// remove the UploadUrl settings that CKEditor uses to power the Upload tabs
		if (isset($config['filebrowserImageUploadUrl'])) unset($config['filebrowserImageUploadUrl']);
		if (isset($config['filebrowserUploadUrl']))      unset($config['filebrowserUploadUrl']);
		if (isset($config['filebrowserFlashUploadUrl'])) unset($config['filebrowserFlashUploadUrl']);

		return $config;
	}
}

// End of file ext.wygwam_no_upload_tab.php */
// Location: ./system/expressionengine/third_party/wygwam_no_upload_tab/ext.wygwam_no_upload_tab.php
