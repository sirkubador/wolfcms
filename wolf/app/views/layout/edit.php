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
<h1><?php echo __(':action layout', array(':action' => ucfirst($action))); ?></h1>

<style>


</style>

<form action="<?php echo $action=='edit' ? get_url('layout/edit/'. $layout->id): get_url('layout/add'); ; ?>" method="post">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <fieldset>
        <legend><?php echo __('Metadata'); ?></legend>
        <ol>
            <li>
                <label for="layout_name"><?php echo __('Name'); ?></label>
                <input id="layout_name" name="layout[name]" type="text" placeholder="<?php echo __('Layout name');?>" maxlength="100" value="<?php echo $layout->name; ?>" required autofocus />
            </li>
            <li>
                <label for="layout_content_type"><?php echo __('Content-type'); ?></label>
                <input id="layout_content_type" name="layout[content_type]" type="text" placeholder="<?php echo __('Eg. text/html');?>" maxlength="40" value="<?php echo $layout->content_type; ?>" required />
            </li>
        </ol>
    </fieldset>
    <fieldset id="body">
        <legend><?php echo __('Body'); ?></legend>
        <ol>
            <li>
                <textarea id="layout_content" name="layout[content]"><?php echo htmlentities($layout->content, ENT_COMPAT, 'UTF-8'); ?></textarea>
            </li>
        </ol>
    </fieldset>
    <div class="buttons">
        <?php if (isset($layout->updated_on)) { ?>
        <p id="lastUpdated">
            <?php echo __('Last updated by'); ?> <?php echo $layout->updated_by_name; ?> <?php echo __('on'); ?> <?php echo date('D, j M Y', strtotime($layout->updated_on)); ?>
        </p>
        <?php } ?>
        <button id="commit" name="commit" type=submit accesskey="s"><?php echo __('Save'); ?></button>
        <button id="continue" name="continue" type=submit accesskey="e"><?php echo __('Save and Continue Editing'); ?></button>
        <?php echo __('or'); ?> <a href="<?php echo get_url('layout'); ?>"><?php echo __('Cancel'); ?></a>
    </div>
</form>