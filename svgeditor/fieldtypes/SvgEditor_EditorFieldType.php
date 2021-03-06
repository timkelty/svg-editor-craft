<?php
namespace Craft;

class SvgEditor_EditorFieldType extends BaseFieldType
{
	public function getName()
	{
		return Craft::t('SVG Editor');
	}

	public function getInputHtml($name, $value)
	{
		$settings = $this->getSettings();
		$id = craft()->templates->formatInputId($name);
		$namespacedId = craft()->templates->namespaceInputId($id);

		switch ($settings->editorPlugin) {
			case 'svg-edit':
				$iframeSrc = UrlHelper::getResourceUrl('svgeditor/editors/svg-edit/svg-editor.html');
				craft()->templates->includeJsResource('svgeditor/editors/svg-edit/embedapi.js');
				break;

			default:
				$iframeSrc = UrlHelper::getResourceUrl(sprintf('svgeditor/editors/%s/index.html', $settings->editorPlugin));
				craft()->templates->includeJsResource(sprintf('svgeditor/editors/%s/src/embedapi.js', $settings->editorPlugin));
				break;
		}

		// Include our JS
		craft()->templates->includeJsResource('svgeditor/js/svg-edit.js');
		craft()->templates->includeJs("$('#{$namespacedId}').svgEdit();");

		return craft()->templates->render('svgeditor/_cp/editor/field', array(
			'name'  => $name,
			'value' => $value,
			'id' 	=> $id,
			'iframeSrc' => $iframeSrc,
			'iframeHeight' => $settings->editorHeight,
		));
	}

	protected function defineSettings()
	{
	    return array(
	        'editorPlugin' => array(
	        	'type' => AttributeType::String,
	        	'required' => true
	        ),
	        'editorHeight' => array(
	        	'type' => AttributeType::Number,
	        	'default' => 800
	        ),
	    );
	}

	public function getSettingsHtml()
	{
	    return craft()->templates->render('svgeditor/_cp/editor/settings', array(
	        'settings' => $this->getSettings()
	    ));
	}

	public function defineContentAttribute()
	{
		return array(AttributeType::String, 'column' => 'mediumtext');
	}

}
