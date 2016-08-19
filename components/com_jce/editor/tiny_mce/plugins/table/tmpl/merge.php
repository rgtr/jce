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
<div class="ui-form-row">
    <label class="ui-form-label ui-width-7-10"><?php echo WFText::_('WF_TABLE_COLS'); ?>:</label>
    <div class="ui-form-controls ui-width-3-10">
        <input type="number" min="1" id="numcols" value=""/>
    </div>
</div>
<div class="ui-form-row">
    <label class="ui-form-label ui-width-7-10"><?php echo WFText::_('WF_TABLE_ROWS'); ?>:</label>
    <div class="ui-form-controls ui-width-3-10">
        <input type="number" min="1" id="numrows" value=""/>
    </div>
</div>