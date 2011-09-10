<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * ExpressionEngine - by EllisLab
 *
 * @package		ExpressionEngine
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2003 - 2011, EllisLab, Inc.
 * @license		http://expressionengine.com/user_guide/license.html
 * @link		http://expressionengine.com
 * @since		Version 2.0
 * @filesource
 */
 
// ------------------------------------------------------------------------
 
/**
 * Simple Preview Accessory
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Accessory
 * @author		Trevor Davis
 * @link		http://trevordavis.net
 */
 
class Simple_preview_acc {
	
	public $name			= 'Simple Preview';
	public $id				= 'simple_preview';
	public $version			= '1.0';
	public $description		= 'Adds a preview link onto the "preview" page.';
	public $sections		= array();
	
	/**
	 * Set Sections
	 */
	public function set_sections()
	{
		$EE =& get_instance();
		$previewJs = '';
		
		if($EE->input->get('C') === 'content_publish' && $EE->input->get('M') === 'view_entry') {
			$channel_id = $EE->input->get('channel_id');
			$entry_id = $EE->input->get('entry_id');
			
			if($channel_id && $entry_id) {
				$query = $EE->db->select('channel_url')
								       ->from('channels')
									   ->where('channel_id', $channel_id)
								       ->get();

				foreach ($query->result() AS $row) {
					$previewUrl = $row->channel_url;

					if($previewUrl !== '') {
						$query = $EE->db->select('url_title')
										       ->from('channel_titles')
											   ->where('entry_id', $entry_id)
										       ->get();

						foreach ($query->result() AS $row) {
							$previewUrl .= $row->url_title . '/preview';
						
							$previewJs = '$("#view_content_entry_links").find(".bullets").prepend("<li><a href=\'' . $previewUrl . '\' target=\'_blank\'>Preview</a></li>")';
						}
					}
				}
			}
		}
		
		//Remove the tab
		$this->sections[] = '<script type="text/javascript">$("#accessoryTabs a.simple_preview").parent().remove();' . $previewJs . '</script>';
		
	}
	
	// ----------------------------------------------------------------
	
}
 
/* End of file acc.simple_preview.php */
/* Location: /system/expressionengine/third_party/simple_preview/acc.simple_preview.php */