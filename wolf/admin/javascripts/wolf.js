/*
 * Wolf CMS - Content Management Simplified. <http://www.wolfcms.org>
 * Copyright (C) 2009-2011 Martijn van der Kleijn <martijn.niji@gmail.com>
 *
 * This file is part of Wolf CMS. Wolf CMS is licensed under the GNU GPLv3 license.
 * Please see license.txt for the full license text.
 *
 * @todo Needs further cleanup
 */

function toSlug(value) {
    // Test for non western characters
    // Need to do this in a better way
    var rx=/[a-z]|[A-Z]|[0-9]|[áàâąбćčцдđďéèêëęěфгѓíîïийкłлмñńňóôóпúùûůřšśťтвýыžżźзäæчöøüшщßåяюж]/;

    if (!rx.test(value)) {
        return value;
    }
    else {
        value = $.trim(value);
        value = value.toLowerCase();
        value = value
        .replace(/[áàâą]/g,"a")
        .replace(/[б]/g,"b")
        .replace(/[ćčçц]/g,"c")
        .replace(/[дđď]/g,"d")
        .replace(/[éèêëęě]/g,"e")
        .replace(/[ф]/g,"f")
        .replace(/[гѓ]/g,"g")
        .replace(/[íîïи]/g,"i")
        .replace(/[й]/g,"j")
        .replace(/[к]/g,"k")
        .replace(/[łл]/g,"l")
        .replace(/[м]/g,"m")
        .replace(/[ñńň]/g,"n")
        .replace(/[óôó]/g,"o")
        .replace(/[п]/g,"p")
        .replace(/[úùûů]/g,"u")
        .replace(/[ř]/g,"r")
        .replace(/[šś]/g,"s")
        .replace(/[ťт]/g,"t")
        .replace(/[в]/g,"v")
        .replace(/[ýы]/g,"y")
        .replace(/[žżźз]/g,"z")
        .replace(/[äæ]/g,"ae")
        .replace(/[ч]/g,"ch")
        .replace(/[öø]/g,"oe")
        .replace(/[ü]/g,"ue")
        .replace(/[ш]/g,"sh")
        .replace(/[щ]/g,"shh")
        .replace(/[ß]/g,"ss")
        .replace(/[å]/g,"aa")
        .replace(/[я]/g,"ya")
        .replace(/[ю]/g,"yu")
        .replace(/[ж]/g,"zh")
        .replace(/[^-a-z0-9~\s\.:;+=_]/g, '')
        .replace(/[\s\.:;=+]+/g, '-');

        return value.replace(/[-]+/g, '-');
    }
}

function page_id() {
    if(/(\d+)/.test(window.location.pathname)){
        return RegExp.$1;
    } else if (/(\d+)/.test(window.location.href)) {
        return RegExp.$1;
    }
}

// When object is available, do function fn.
function when(obj, fn) {
    if (Object.isString(obj)) obj = /^[\w-]+$/.test(obj) ? $(obj) : $(document.body).down(obj);
    if (Object.isArray(obj) && !obj.length) return;
    if (obj) fn(obj);
}

function part_added() {
    var partNameField = $('part-name-field');
    var partIndexField = $('part-index-field');
    var index = parseInt(partIndexField.value);
    tabControl.addTab('tab-' + index,  partNameField.value, 'page-' + index);
    Element.toggle('busy');
    Element.hide('add-part-popup');
    partNameField.value = '';
    partIndexField.value = (index + 1).toString();
    $('add-part-button').disabled = false;
    Field.focus(partNameField);
    tabControl.select(tab);
}

function part_loading() {
    $('add-part-button').disabled = true;
    Element.toggle('busy');
}

// Updated valid_part_name function for JQuery
function valid_part_name(name) {
    name = name.toLowerCase();
    name = $.trim(name);
    var result = true;

    if (name == '') {
        alert('Part name cannot be empty.');
        return false;
    }

    $('#part-tabs .tabNavigation .tab a').each(function(){
        if (this.text == name) {
            result = false;
            alert('Part name must be unique.');
            throw $break;
        }
    })

    return result;
}

function center(element) {
    var header = $('header')
    element = $(element);
    element.style.position = 'absolute';
    var dim = Element.getDimensions(element);
    var top = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop;
    element.style.top = (top + 200) + 'px';
    element.style.left = ((header.offsetWidth - dim.width) / 2) + 'px';
}

$.fn.sortableSetup = function sortableSetup(itemname) {
    this.sortable({
        disabled:true,
        tolerance:'intersect',
        containment:'#page-content',
        placeholder:'placeholder',
        handle: '.handle',
        cursor:'crosshair',
        distance:'15',
        stop: function(event, ui) {
            var order = $(ui.item.parent()).sortable('serialize', {key: itemname+'s[]'});
            $.post(wolfBaseUrl+itemname+'/reorder/', {data : order});
        }
    })
    .disableSelection();

    return this;
};


$(document).ready(function() {
    
    var toggle_reorder = false;
    
    // Prevent accidentally navigating away
    $(':input').bind('change', function() { window.onbeforeunload = function() { return wolfLeaveWithoutSaveMsg; }; });
    $('form').submit(function() { window.onbeforeunload = function() { return null; }; return true; });
    
    // Allow showing of system messages
    (function showMessages(e) {
        e.fadeIn('slow')
        .animate({
            opacity: 1.0
        }, 1500)
        .fadeOut('slow', function() {
            if ($(this).next().attr('class') == 'message') {
                showMessages($(this).next());
            }
            $(this).remove();
        })
    })( $(".message:first") );

    // Filter system
    // Get the initial values and activate filter but only if .filter-selector exists
    if ($('.filter-selector').length > 0) {
        $('.filter-selector').each(function() {
            var $this = $(this);
            $this.data('oldValue', $this.val());

            if ($this.val() == '') {
                return true;
            }
            var elemId = $this.attr('id').slice(0, -10);
            var elem = $('#'+elemId+'_content');
            $this.trigger('wolfSwitchFilterIn', [$this.val(), elem]);
        });
        $('.filter-selector').live('change',function(){
            var $this = $(this);
            var newFilter = $this.val();
            var oldFilter = $this.data('oldValue');
            $this.data('oldValue', newFilter);
            var elemId = $this.attr('id').slice(0, -10);
            var elem = $('#'+elemId+'_content');
            $(this).trigger('wolfSwitchFilterOut', [oldFilter, elem]);
            $(this).trigger('wolfSwitchFilterIn', [newFilter, elem]);
        });        
    }
    
    // Place input focus on first enabled input field
    $("input:visible:enabled:first").focus();
});