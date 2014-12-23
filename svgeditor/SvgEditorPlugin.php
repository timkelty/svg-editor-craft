<?php
namespace Craft;

class SvgEditorPlugin extends BasePlugin
{
	function getName()
	{
		$pluginName	= Craft::t('SVG Editor');
		$pluginNameOverride	= $this->getSettings()->pluginNameOverride;

		return ($pluginNameOverride) ? $pluginNameOverride : $pluginName;
	}

	function getVersion()
	{
		return '1.0.0';
	}

	function getDeveloper()
	{
		return 'Tim Kelty';
	}

	function getDeveloperUrl()
	{
		return 'http://fusionary.com';
	}

	public function hasCpSection()
	{
		return false;
	}

	/**
	 * Define plugin settings
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'pluginNameOverride' => AttributeType::String,
		);
	}
}
