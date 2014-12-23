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
				$iframeSrc = UrlHelper::getResourceUrl('svgeditor/svg-edit/svg-editor.html');
				craft()->templates->includeJsResource('svgeditor/svg-edit/embedapi.js');
				break;

			default:
				$iframeSrc = UrlHelper::getResourceUrl('svgeditor/method-draw/index.html');
				craft()->templates->includeJsResource('svgeditor/method-draw/src/embedapi.js');
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
