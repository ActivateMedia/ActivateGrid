<?php
/**
 * @package     Joomla.Platform
 * @subpackage  Form
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('JPATH_PLATFORM') or die;

/**
 * Form Field class for the Joomla Platform.
 * Supports a generic list of options.
 *
 * @package     Joomla.Platform
 * @subpackage  Form
 * @since       11.1
 */
class JFormFieldCategoryColorPicker extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.1
	 */
	protected $type = 'categorycolorpicker';

	/**
	 * Method to get the field input markup for a generic list.
	 * Use the multiple attribute to enable multiselect.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.1
	 */
	protected function getInput()
	{
            require_once 'categorycolorpickertool.php';
		$html = array();
		$attr = '';
                
                 $db = JFactory::getDBO();
                 $query = "SELECT cat.id, cat.title FROM #__categories as cat WHERE extension='com_content'";
                 $db->setQuery($query);
                 $db->query();
                 $categories = $db->loadObjectList();
                 $i=0;
                 foreach($categories as $category)
                 {
                     $fieldName = "category_color_".$category->id;
                     $color = new JFormFieldCategorycolorpickertool($fieldName, "jform_".$fieldName, "#FF0000");
                     
                     //print_r($color);
                     
                     $htmlElem  = "<fieldset id='jform_".$fieldName."'>\n";
                     $htmlElem .= "<div class='span2'>".$category->title."</div>\n";
                     $htmlElem .= "<div class='span2 controls'>".$color->getInput()."</div>\n";
                     $htmlElem .= "</fieldset>\n\n";
                     /*$htmlElem .= '<div class="span2"><span class="minicolors minicolors-theme-bootstrap minicolors-swatch-position-left minicolors-swatch-left minicolors-position-right minicolors-focus">';
                     $htmlElem .= '<span class="minicolors-swatch"><span style="background-color: rgb(82, 37, 28);"></span></span>';
                     $htmlElem .= '<input type="text" name="jform['.$fieldName.']" id="jform_'.$fieldName.'" value="#1" class="minicolors radio btn-group required minicolors-input " data-position="right" aria-required="true" required="required" size="7" maxlength="7" aria-invalid="false">';
                     $htmlElem .= '<span class="minicolors-panel minicolors-slider-hue" style="display: inline;"><span class="minicolors-slider"><span class="minicolors-picker" style="top: 146px;"></span></span><span class="minicolors-opacity-slider"><span class="minicolors-picker"></span></span><span class="minicolors-grid" style="background-color: rgb(255, 43, 0);"><span class="minicolors-grid-inner"></span><span class="minicolors-picker" style="top: 102px; left: 100px;"><span></span></span></span></span></span>';
                     $htmlElem .= "</div><br/>";*/
                     $html[] = $htmlElem;
                 }
                 //print_r($response);
                 
/*
		// Initialize some field attributes.
		$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';
		$attr .= $this->required ? ' required="required" aria-required="true"' : '';

		// Initialize JavaScript field attributes.
		$attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		// Get the field options.
		$options = (array) $this->getOptions();

		// Create a read-only list (no name) with a hidden input to store the value.
		if ((string) $this->element['readonly'] == 'true')
		{
			$html[] = JHtml::_('select.genericlist', $options, '', trim($attr), 'value', 'text', $this->value, $this->id);
			$html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '"/>';
		}
		// Create a regular list.
		else
		{
			$html[] = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		}
                */
		return implode($html);
	}

	/**
	 * Method to get the field options.
	 *
	 * @return  array  The field option objects.
	 *
	 * @since   11.1
	 */
	protected function getOptions()
	{
		$options = array();
                
		foreach ($this->element->children() as $option)
		{

			// Only add <option /> elements.
			if ($option->getName() != 'option')
			{
				continue;
			}

			// Create a new option object based on the <option /> element.
			$tmp = JHtml::_(
				'select.option', (string) $option['value'],
				JText::alt(trim((string) $option), preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)), 'value', 'text',
				((string) $option['disabled'] == 'true')
			);

			// Set some option attributes.
			$tmp->class = (string) $option['class'];

			// Set some JavaScript option attributes.
			$tmp->onclick = (string) $option['onclick'];

			// Add the option object to the result set.
			$options[] = $tmp;
		}

		reset($options);

		return $options;
	}
}
