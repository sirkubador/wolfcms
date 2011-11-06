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
<h1><?php echo __('Snippets'); ?></h1>

<div id="site-map-def" class="index-def">
    <div class="snippet">
        <?php echo __('Snippet'); ?> (<a href="#" id="reorder-toggle"><?php echo __('reorder'); ?></a>)
    </div>
    <div class="modify"><?php echo __('Modify'); ?></div>
</div>

<ul id="snippets" class="index">
<?php foreach($snippets as $snippet): ?>
  <li id="snippet_<?php echo $snippet->id; ?>" class="snippet node <?php echo odd_even(); ?>">
    <img align="middle" alt="snippet-icon" src="<?php echo URI_PUBLIC;?>wolf/admin/images/snippet.png" title="Snippet icon" />
    <a href="<?php echo get_url('snippet/edit/'.$snippet->id); ?>"><?php echo $snippet->name; ?></a>
    <img class="handle" src="<?php echo URI_PUBLIC;?>wolf/admin/images/drag.gif" alt="<?php echo __('Drag and Drop'); ?>" align="middle" />
    <div class="remove"><a href="<?php echo get_url('snippet/delete/'.$snippet->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete?'); ?> <?php echo $snippet->name; ?>?');"><img src="<?php echo URI_PUBLIC;?>wolf/admin/images/icon-remove.gif" alt="<?php echo __('delete snippet icon'); ?>" title="<?php echo __('Delete snippet'); ?>" /></a></div>
  </li>
<?php endforeach; ?>
</ul>

<script type="text/javascript">
// <![CDATA[

    $(document).ready(function() {
        $('ul#snippets').sortableSetup('snippet');
        $('#reorder-toggle').toggle(
            function(){
                $('ul#snippets').sortable('option', 'disabled', false);
                $('.handle').show();
                $('#reorder-toggle').text('<?php echo __('disable reorder');?>');
            },
            function() {
                $('ul#snippets').sortable('option', 'disabled', true);
                $('.handle').hide();
                $('#reorder-toggle').text('<?php echo __('reorder');?>');
            }
        )
    });

// ]]>
</script>