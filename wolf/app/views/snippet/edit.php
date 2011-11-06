<?php

/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009-2011 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */


/**
 * @package Views
 *
 * @author Martijn van der Kleijn <martijn.niji@gmail.com>
 * @copyright Martijn van der Kleijn, 2011
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 License
 */
?>
<h1><?php echo __(':action snippet', array(':action' => ucfirst($action))); ?></h1>

<form method="post" action="<?php echo $action=='edit' ? get_url('snippet/edit/'.$snippet->id): get_url('snippet/add'); ; ?>">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <fieldset>
        <legend><?php echo __('Metadata'); ?></legend>
        <ol>
            <li>
                <label for="snippet_name"><?php echo __('Name'); ?></label>
                <input id="snippet_name" name="snippet[name]" type="text" placeholder="<?php echo __('Snippet name');?>" maxlength="100" value="<?php echo $snippet->name; ?>" />
            </li>
        </ol>
    </fieldset>
    <fieldset id="body">
        <label for="snippet_filter_id"><?php echo __('Filter'); ?></label>
        <select id="snippet_filter_id" class="filter-selector" name="snippet[filter_id]">
            <option value=""<?php if($snippet->filter_id == '') echo ' selected="selected"'; ?>>&#8212; <?php echo __('none'); ?> &#8212;</option>
            <?php foreach ($filters as $filter): ?>
            <option value="<?php echo $filter; ?>"<?php if($snippet->filter_id == $filter) echo ' selected="selected"'; ?>><?php echo Inflector::humanize($filter); ?></option>
            <?php endforeach; ?>
        </select>
        <legend><?php echo __('Body'); ?></legend>
        <ol>
            <li>
                <textarea id="snippet_content" name="snippet[content]"><?php echo htmlentities($snippet->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
            </li>
        </ol>
    </fieldset>
    <div class="buttons">
        <p id="lastUpdated">
        <?php if (isset($snippet->updated_on)) { ?>
            <?php echo __('Last updated by'); ?> <?php echo $snippet->updated_by_name; ?> <?php echo __('on'); ?> <?php echo date('D, j M Y', strtotime($snippet->updated_on)); ?>
        <?php } ?>
        </p>
        <button id="commit" name="commit" type=submit accesskey="s"><?php echo __('Save'); ?></button>
        <button id="continue" name="continue" type=submit accesskey="e"><?php echo __('Save and Continue Editing'); ?></button>
        <?php echo __('or'); ?> <a href="<?php echo get_url('snippet'); ?>"><?php echo __('Cancel'); ?></a>
    </div>
</form>