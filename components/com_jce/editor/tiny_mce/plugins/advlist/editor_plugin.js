/**
 * editor_plugin_src.js
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under LGPL License.
 *
 * License: http://tinymce.moxiecode.com/license
 * Contributing: http://tinymce.moxiecode.com/contributing
 */

(function() {
    var each = tinymce.each, undef;

    tinymce.create('tinymce.plugins.AdvListPlugin', {
        init: function(ed, url) {
            var t = this;

            t.editor = ed;

            function buildFormats(str) {
                var formats = [];

                each(str.split(/,/), function(type) {
                    var title = type.replace(/-/g, '_');

                    if (type === 'default') {
                        title = 'def';
                    }

                    formats.push({
                        title: 'advlist.' + title,
                        styles: {
                            listStyleType: type === 'default' ? '' : type
                        }
                    });
                });

                return formats;
            }

            // Setup number formats from config or default
            var numlist = ed.getParam("advlist_number_styles", "default,lower-alpha,lower-greek,lower-roman,upper-alpha,upper-roman");

            if (numlist) {
                t.numlist = buildFormats(numlist);
            }

            var bullist = ed.getParam("advlist_bullet_styles", "default,circle,disc,square");

            if (bullist) {
                t.bullist = buildFormats(bullist);
            }
        },
        createControl: function(name, cm) {
            var t = this, btn, format, editor = t.editor;

            if (name == 'numlist' || name == 'bullist') {

                if (t[name] && t[name][0].title === 'advlist.def') {
                    format = t[name][0];
                }

                function hasFormat(node, format) {
                    var state = true;

                    each(format.styles, function(value, name) {
                        // Format doesn't match
                        if (editor.dom.getStyle(node, name) != value) {
                            state = false;
                            return false;
                        }
                    });

                    return state;
                }

                function applyListFormat() {
                    var list, dom = editor.dom, sel = editor.selection;

                    // Check for existing list element
                    list = dom.getParent(sel.getNode(), 'ol,ul');

                    // Switch/add list type if needed
                    if (!list || list.nodeName == (name == 'bullist' ? 'OL' : 'UL') || !format || hasFormat(list, format)) {
                        editor.execCommand(name == 'bullist' ? 'InsertUnorderedList' : 'InsertOrderedList');
                    }

                    // Append styles to new list element
                    if (format) {
                        list = dom.getParent(sel.getNode(), 'ol,ul');
                        if (list) {
                            dom.setStyles(list, format.styles);
                            list.removeAttribute('data-mce-style');
                        }
                    }

                    editor.focus();
                }

                // disabled
                if (!t[name]) {
                    btn = cm.createButton(name, {
                        title: 'advanced.' + name + '_desc',
                        'class': 'mce_' + name,
                        onclick: function() {
                            applyListFormat();
                        }
                    });

                    return btn;
                }

                btn = cm.createSplitButton(name, {
                    title: 'advanced.' + name + '_desc',
                    'class': 'mce_' + name,
                    onclick: function() {
                        applyListFormat();
                    }
                });

                btn.onRenderMenu.add(function(btn, menu) {
                    menu.onHideMenu.add(function() {
                        if (t.bookmark) {
                            editor.selection.moveToBookmark(t.bookmark);
                            t.bookmark = 0;
                        }
                    });

                    menu.onShowMenu.add(function() {
                        var dom = editor.dom, list = dom.getParent(editor.selection.getNode(), 'ol,ul'), fmtList;

                        if (list || format) {
                            fmtList = t[name];

                            // Unselect existing items
                            each(menu.items, function(item) {
                                var state = true;

                                item.setSelected(0);

                                if (list && !item.isDisabled()) {
                                    each(fmtList, function(fmt) {
                                        if (fmt.id == item.id) {
                                            if (!hasFormat(list, fmt)) {
                                                state = false;
                                                return false;
                                            }
                                        }
                                    });

                                    if (state)
                                        item.setSelected(1);
                                }
                            });

                            // Select the current format
                            if (!list)
                                menu.items[format.id].setSelected(1);
                        }

                        editor.focus();

                        // IE looses it's selection so store it away and restore it later
                        if (tinymce.isIE) {
                            t.bookmark = editor.selection.getBookmark(1);
                        }
                    });

                    each(t[name], function(item) {
                        item.id = editor.dom.uniqueId();

                        var style = item.styles.listStyleType, icon = style.replace(/-/g, '_');

                        menu.add({
                            id: item.id, 
                            title: item.title,
                            icon: 'list_' + icon,
                            onclick: function() {
                                format = item;
                                applyListFormat();
                            }});
                    });
                });

                return btn;
            }
        },
        getInfo: function() {
            return {
                longname: 'Advanced lists',
                author: 'Moxiecode Systems AB',
                authorurl: 'http://tinymce.moxiecode.com',
                infourl: 'http://wiki.moxiecode.com/index.php/TinyMCE:Plugins/advlist',
                version: tinymce.majorVersion + "." + tinymce.minorVersion
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('advlist', tinymce.plugins.AdvListPlugin);
})();