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
<h1><?php echo __(':action user', array(':action' => ucfirst($action))); ?></h1>

<form id="user" class="user" method="post" action="<?php echo $action == 'edit' ? get_url('user/edit/'.$user->id) : get_url('user/add'); ?>">
    <input id="csrf_token" name="csrf_token" type="hidden" value="<?php echo $csrf_token; ?>" />
    <aside>
        <?php echo Gravatar::img($user->email, array('class' => 'avatar'), '160'); ?>
        <p id="username">
            <?php echo $user->username; ?>
        </p>
        <p>
            <?php echo __('since :date', array(':date' => date('d-m-Y', strtotime($user->created_on)))); ?>
        </p>
    </aside>
    <table>
        <tr>
            <td>
                <label for="user_name"><?php echo __('Name'); ?></label>
            </td>
            <td>
                <input id="user_name" name="user[name]" type="text" maxlength="100" value="<?php echo $user->name; ?>" />
            </td>
            <td class="help">
                <?php echo __('Required.'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="user_email"><?php echo __('E-mail'); ?></label>
            </td>
            <td>
                <input id="user_email" name="user[email]" type="text" maxlength="255" value="<?php echo $user->email; ?>" />
            </td>
            <td class="help">
                <?php echo __('Optional. Please use a valid e-mail address.'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="user_username"><?php echo __('Username'); ?></label>
            </td>
            <td>
                <input id="user_username" name="user[username]" type="text" maxlength="40" value="<?php echo $user->username; ?>" <?php echo $action == 'edit' ? 'disabled="disabled" ' : ''; ?>/>
            </td>
            <td class="help">
                <?php echo __('At least 3 characters. Must be unique.'); ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="user_password"><?php echo __('Password'); ?></label>
            </td>
            <td>
                <input id="user_password" name="user[password]" type="password" maxlength="40" value="" />
            </td>
            <td class="help" rowspan="2">
                <?php echo __('At least 5 characters.'); ?>
                <?php if ($action == 'edit') {
                echo __('Leave password blank for it to remain unchanged.');
                } ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="user_confirm"><?php echo __('Confirm Password'); ?></label>
            </td>
            <td>
                <input id="user_confirm" name="user[confirm]" type="password" maxlength="40" value="" />
            </td>
        </tr>
        <?php if (AuthUser::hasPermission('user_edit')): ?>
        <tr>
            <td>
                <label for="user_role"><?php echo __('Roles'); ?></label>
            </td>
            <td>
                <ol>
                    <?php $user_roles = ($user instanceof User) ? $user->roles() : array(); ?>
                    <?php foreach ($roles as $role): ?>
                    <li>
                        <label for="user_role-<?php echo $role->name; ?>"><?php echo __(ucwords($role->displayname())); ?></label>
                        <input id="user_role-<?php echo $role->name; ?>" name="user_role[<?php echo $role->name; ?>]" type="checkbox" value="<?php echo $role->id; ?>" <?php if (in_array($role->name, $user_roles)) echo ' checked="checked"'; ?> />
                    </li>
                    <?php endforeach; ?>
                </ol>
            </td>
            <td class="help">
                <?php echo __('Roles restrict user privileges and turn parts of the administrative interface on or off.'); ?>
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <td>
                <label for="user_language"><?php echo __('Language'); ?></label>
            </td>
            <td>
                <select id="user_language" name="user[language]">
                    <?php foreach (Setting::getLanguages() as $code => $label): ?>
                    <option value="<?php echo $code; ?>"<?php if ($code == $user->language)
                    echo ' selected="selected"'; ?>><?php echo __($label); ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td class="help">
                <?php echo __('This will set your preferred language for the backend.'); ?>
            </td>
        </tr>
    </table>
    
    <?php Observer::notify('user_edit_view_after_details', $user); ?>
    
    <div class="buttons">
        <button id="commit" name="commit" type="submit" accesskey="s"><?php echo __('Save'); ?></button>
        <?php echo __('or'); ?> <a href="<?php echo get_url('user'); ?>"><?php echo __('Cancel'); ?></a>
    </div>

</form>