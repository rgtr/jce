<?php

/**
 * @package    JCE
 * @copyright    Copyright (c) 2009-2016 Ryan Demmer. All rights reserved.
 * @license    GNU/GPL 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * JCE is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined('_JEXEC') or die('RESTRICTED');
?>
    <div class="ui-form-row ui-grid">
        <label class="ui-form-label ui-width-2-10" for="cols">
            <?php echo WFText::_('WF_TABLE_COLS'); ?></label>
        <div class="ui-form-controls ui-width-3-10">
            <input id="cols" type="number" min="1" value="" required />
        </div>

        <label class="ui-form-label ui-width-2-10" for="rows">
            <?php echo WFText::_('WF_TABLE_ROWS'); ?></label>
        <div class="ui-form-controls ui-width-3-10">
            <input id="rows" type="number" value="" required />
        </div>
    </div>

<div class="ui-form-row ui-grid">
    <label class="ui-form-label ui-width-2-10" for="cellpadding">
        <?php echo WFText::_('WF_TABLE_CELLPADDING'); ?></label>
    <div class="ui-form-controls ui-width-3-10">
        <input id="cellpadding" type="number" value="" />
    </div>

    <label class="ui-form-label ui-width-2-10" for="cellspacing">
        <?php echo WFText::_('WF_TABLE_CELLSPACING'); ?></label>
    <div class="ui-form-controls ui-width-3-10">
        <input id="cellspacing" type="number" value="" />
    </div>
</div>
<div class="ui-form-row ui-grid">
    <label class="ui-form-label ui-width-2-10" for="align">
        <?php echo WFText::_('WF_TABLE_ALIGN'); ?></label>
    <div class="ui-form-controls ui-width-3-10">
        <select id="align">
            <option value="">{#not_set}</option>
            <option value="center"><?php echo WFText::_('WF_TABLE_ALIGN_MIDDLE'); ?></option>
            <option value="left"><?php echo WFText::_('WF_TABLE_ALIGN_LEFT'); ?></option>
            <option value="right"><?php echo WFText::_('WF_TABLE_ALIGN_RIGHT'); ?></option>
        </select>
    </div>

    <label class="ui-form-label ui-width-2-10" for="border">
        <?php echo WFText::_('WF_TABLE_BORDER'); ?></label>
    <div class="ui-form-controls ui-width-3-10">
        <input id="border" type="number" value="" onchange="TableDialog.changedBorder();" />
    </div>
</div>
<div class="ui-form-row ui-grid">
    <label class="ui-form-label ui-width-2-10" for="width">
        <?php echo WFText::_('WF_TABLE_WIDTH'); ?></label>
    <div class="ui-form-controls ui-width-3-10">
        <input type="text" id="width" value=""
               onchange="TableDialog.changedSize();" />
    </div>

    <label class="ui-form-label ui-width-2-10" for="height">
        <?php echo WFText::_('WF_TABLE_HEIGHT'); ?></label>
    <div class="ui-form-controls ui-width-3-10">
        <input type="text" id="height" value=""
               onchange="TableDialog.changedSize();" />
    </div>
</div>
<div class="ui-form-row">
    <input id="caption" type="checkbox" />
    <label for="caption">
        <?php echo WFText::_('WF_TABLE_CAPTION'); ?></label>
</div>
