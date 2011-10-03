<?php
/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009-2010 Martijn van der Kleijn <martijn.niji@gmail.com>
 * Copyright (C) 2008 Philippe Archambault <philippe.archambault@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 */

/**
 * @package Views
 *
 * @author Philippe Archambault <philippe.archambault@gmail.com>
 * @copyright Philippe Archambault, 2008
 * @license http://www.gnu.org/licenses/gpl.html GPLv3 license
 */
use_helper('Gravatar');
?>
<h1><?php echo __('Administration').' - '.__('Users'); ?></h1>

<table id="users" class="index">
    <thead>
        <tr>
            <th><?php echo __('Name'); ?> / <?php echo __('Username'); ?></th>
            <th><?php echo __('Email'); ?></th>
            <th><?php echo __('Roles'); ?></th>
            <th><?php echo __('Modify'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?> 
            <tr class="<?php echo odd_even(); ?>">
                <td class="user">
                    <?php
                    $args = array('class' => 'avatar', 'alt' => __('User icon'));
                    if (defined('USE_HTTPS') && USE_HTTPS)
                        echo Gravatar::img($user->email, $args);
                    else
                        echo Gravatar::simg($user->email, $args);
                    ?>
                    <a href="<?php echo get_url('user/edit/'.$user->id); ?>"><?php echo $user->name; ?></a>
                    <small><?php echo $user->username; ?></small>
                </td>
                <td class="email"><?php echo $user->email; ?></td>
                <td class="roles"><?php echo implode(', ', $user->roles()); ?></td>
                <td class="actions">
                    <?php if ($user->id > 1): ?>
                        <a href="<?php echo get_url('user/delete/'.$user->id); ?>" onclick="return confirm('<?php echo __('Are you sure you wish to delete').' '.$user->name.'?'; ?>');"><img src="<?php echo URI_PUBLIC; ?>wolf/admin/images/icon-remove.gif" alt="<?php echo __('delete user icon'); ?>" title="<?php echo __('Delete user'); ?>" /></a>
                    <?php else: ?>
                        <img src="<?php echo URI_PUBLIC; ?>wolf/admin/images/icon-remove-disabled.gif" alt="<?php echo __('delete user icon disabled'); ?>" title="<?php echo __('Delete user unavailable'); ?>" />
    <?php endif; ?>
                </td>
            </tr>
<?php endforeach; ?> 
    </tbody>
</table>
