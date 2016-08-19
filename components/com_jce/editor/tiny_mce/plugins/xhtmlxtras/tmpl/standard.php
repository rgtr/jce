<?php
/**
 * @package   	JCE
 * @copyright 	Copyright (c) 2009-2016 Ryan Demmer. All rights reserved.
 * @license   	GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_JEXEC') or die('RESTRICTED');

$element = $this->plugin->getElementName();

if ($element == 'del' || $element == 'ins') :
    echo $this->loadTemplate('datetime');
endif;
?>
    <div class="ui-form-row">
        <label class="ui-form-label ui-width-3-10" for="title"><?php echo WFText::_('WF_XHTMLXTRAS_ATTRIBUTE_LABEL_TITLE'); ?></label>
        <div class="ui-form-controls ui-width-7-10"><input id="title" type="text" value="" /></div>
    </div>
    <div class="ui-form-row">
        <label class="ui-form-label ui-width-3-10" for="id"><?php echo WFText::_('WF_XHTMLXTRAS_ATTRIBUTE_LABEL_ID'); ?></label>
        <div class="ui-form-controls ui-width-7-10"><input id="id" type="text" value="" /></div>
    </div>
    <div class="ui-form-row">
        <label for="classlist" class="ui-form-label ui-width-3-10 hastip" title="<?php echo WFText::_('WF_LABEL_CLASSES_DESC'); ?>"><?php echo WFText::_('WF_LABEL_CLASSES'); ?></label>
        <div class="ui-form-controls ui-width-7-10 ui-datalist">
            <input type="text" id="classes" />
            <select id="classlist">
              <option value=""><?php echo WFText::_('WF_OPTION_NOT_SET'); ?></option>
            </select>
        </div>
    </div>
    <div class="ui-form-row">
        <label class="ui-form-label ui-width-3-10" for="dir"><?php echo WFText::_('WF_XHTMLXTRAS_ATTRIBUTE_LABEL_LANGDIR'); ?></label>
        <div class="ui-form-controls ui-width-7-10"><select id="dir">
                <option value="">{#not_set}</option>
                <option value="ltr"><?php echo WFText::_('WF_XHTMLXTRAS_ATTRIBUTE_OPTION_LTR'); ?></option>
                <option value="rtl"><?php echo WFText::_('WF_XHTMLXTRAS_ATTRIBUTE_OPTION_RTL'); ?></option>
            </select></div>
    </div>
    <div class="ui-form-row">
        <label class="ui-form-label ui-width-3-10" for="lang"><?php echo WFText::_('WF_XHTMLXTRAS_ATTRIBUTE_LABEL_LANGCODE'); ?></label>
        <div class="ui-form-controls ui-width-7-10"><input id="lang" type="text" value="" />
        </div>
    </div>
    <?php
    if ($this->plugin->isHTML5()) :
        echo $this->loadTemplate('html5');
    endif;
    ?>
