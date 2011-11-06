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
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
?>
<h1><?php echo __('Layouts'); ?></h1>

<div id="site-map-def" class="index-def">
    <div class="layout">
        <?php echo __('Layout'); ?> (<a href="#" id="reorder-toggle"><?php echo __('reorder'); ?></a>)
    </div>
    <div class="modify"><?php echo __('Modify'); ?></div>
</div>

<ul id="layouts" class="index">
<?php foreach($layouts as $layout): ?>
  <li id="layout_<?php echo $layout->id; ?>" class="layout node <?php echo odd_even(); ?>">
    <img align="middle" alt="layout-icon" src="<?php echo URI_PUBLIC;?>wolf/admin/images/layout.png" title="Layout icon" />
    <a href="<?php echo get_url('layout/edit/'.$layout->id); ?>"><?php echo $layout->name; ?></a>
    <img class="handle" src="<?php echo URI_PUBLIC;?>wolf/admin/images/drag.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" />
    <div class="remove"><a href="<?php echo get_url('layout/delete/'.$layout->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete'); ?> <?php echo $layout->name; ?>?');"><img alt="<?php echo __('delete layout icon'); ?>" title="<?php echo __('Delete layout'); ?>" src="<?php echo URI_PUBLIC;?>wolf/admin/images/icon-remove.gif" /></a></div>
  </li>
<?php endforeach; ?>
</ul>

<script type="text/javascript">
// <![CDATA[
    
    $(document).ready(function() {
        $('ul#layouts').sortableSetup('layout');
        $('#reorder-toggle').toggle(
            function(){
                $('ul#layouts').sortable('option', 'disabled', false);
                $('.handle').show();
                $('#reorder-toggle').text('<?php echo __('disable reorder');?>');
            },
            function() {
                $('ul#layouts').sortable('option', 'disabled', true);
                $('.handle').hide();
                $('#reorder-toggle').text('<?php echo __('reorder');?>');
            }
        )
    });

// ]]>
</script>