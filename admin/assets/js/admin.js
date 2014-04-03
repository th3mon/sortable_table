(function ( g, d, $, u ) {
	'use strict';

	$(function () {
        var
            $form,
            $g,
            $inputs,
            $inputSiteName,
            $inputSiteUrl,
            $butonAdd,
            $table,
            $buttonsDelete,
            $checkbox,
            $buttonDeleteSelected,
            $checkboxDeleteAll,

            keyCodes = {
                'enter': 13
            },

            elements,

            uid = 0,

            cache = function() {
                $g = $(g);
                $inputSiteName = $('#site-name');
                $inputSiteUrl = $('#site-url');
                $inputs = $inputSiteName.add($inputSiteUrl);
                $butonAdd = $('#button-add');
                $buttonsDelete = $('.button-delete');
                $buttonDeleteSelected = $('#button-delete-selected');
                $checkboxDeleteAll = $('#deleteAll');
                $table = $('#table');
                $form = $('#form');

                elements = _.zipObject([
                    'wrapper',
                    'inputs',
                    'inputSiteName',
                    'inputSiteUrl',
                    'butonAdd',
                    'table',
                    'buttonsDelete',
                    'buttonDeleteSelected',
                    'checkbox',
                    'checkboxDeleteAll',
                    'form'
                ],
                [
                    $('#Sortable_Table'),
                    $inputs,
                    $inputSiteName,
                    $inputSiteUrl,
                    $butonAdd,
                    $table,
                    $buttonsDelete,
                    $buttonDeleteSelected,
                    $table.find('input[type="checkbox"]'),
                    $checkboxDeleteAll,
                ]);
            },

            getUid = function() {
                return parseInt(elements.buttonsDelete.last().attr('id').split('-')[2], 10);
            },

            updateUid = function() {
                if (elements.buttonsDelete.length) {
                    uid = getUid();
                }

                if ($('#button-delete-' + uid).length) {
                    uid += 1;
                }
            },

            update = function() {
                updateElements();
                updateEvents();
            },

            updateElements = function() {
                elements.checkbox = $table.find('input[type="checkbox"]');
                elements.buttonsDelete = $('.buttons-delete');
            },

            updateEvents = function() {
                elements.buttonsDelete
                    .off('click', deleteSite)
                    .on('click', deleteSite);
            },

            bindEvents = function() {
                elements.buttonsDelete.on('click', deleteSite);
                elements.buttonDeleteSelected.on('click', deleteSelected);
                elements.checkboxDeleteAll.on('click', toggleSelectAll);

                $form
                    .on('keydown', bindAddSiteOnEnterKey)
                    .on('submit', onFormSubmit);
            },

            sendData = function() {
                var 
                    data = {
                        action: 'action_save_data'
                    },

                    getSitesData = function() {
                        var sites = [];

                        elements.table.find('tbody tr.site--new').each(function() {
                            var
                                $this = $(this),
                                name = $this.find('.site-name').text(),
                                url = $this.find('.site-url').text();

                            sites.push({
                                name: name,
                                url: url
                            });

                            $this.removeClass('site--new');
                        });

                        return sites;
                    };

                data.sites = JSON.stringify(getSitesData());

                $.ajax({
                    url: 'admin-post.php',
                    type: 'POST',
                    data: $.param(data)
                }).then(function(data) {
                    console.dir(JSON.parse(data));
                });
            },

            validate = function(callback) {
                var
                    $errors = $(''),

                    validateInput = function() {
                        var
                            $o = $(this),
                            regexUrl = /[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)/ig;

                        if ( ( 'url' === $o.data('validate') ) && (!regexUrl.test( $o.val() )) ) {
                            console.log((regexUrl.test( $o.val() )));
                            $o.addClass('invalid');
                        }

                        else if (_.isEmpty($o.val())) {
                            $o.addClass('invalid');
                        }

                        else {
                            $o.removeClass('invalid');
                        }
                    };

                $inputs.each(validateInput);

                if (!($inputs.hasClass('invalid')) && _.isFunction(callback)) {
                    callback();
                }

                else {
                    $inputs.filter(function() {
                        return $(this).hasClass('invalid');
                    }).first().focus();
                }
            },

            addSite = function() {
                var
                    $newRow = $('<tr>', {
                        'class': 'site site--new'
                    }),
                    $checkbox,
                    $name = $('<td>', {
                        'class': 'site-name',
                        text: $inputSiteName.val()
                    }),
                    $url = $('<td>',{
                        'class': 'site-url'
                    }).append($('<a>', {
                        text: $inputSiteUrl.val(),
                        href: (function (){
                            var
                                url = $inputSiteUrl.val(),
                                regexHttp = /https?:\/\//i;

                            if (!regexHttp.test(url)) {
                                url = 'http://' + url;
                            }

                            return url;
                        }())
                    })),
                    $newButtonsDelete;

                updateUid();

                $checkbox = $('<td>').append($('<input>', {
                    id: 'checkbox-' + uid,
                    type: 'checkbox'
                }));

                $newButtonsDelete = $('<td>').append($('<input>', {
                    id: 'button-delete-' + uid,
                    'class': 'buttons-delete',
                    type: 'button',
                    value: 'delete'
                }));

                $newRow.append($checkbox, $name, $url, $newButtonsDelete);
                $table.append($newRow);

                clearInputs();
                elements.inputSiteName.focus();
                update();
            },

            deleteSite = function() {
                var
                    $site = $(this).parents('tr.site'),
                    data = {
                        action: 'action_delete_data'
                    },
                    site = {
                        id: $site.data('id'),
                        name: $site.find('.site-name').text(),
                        url: $site.find('.site-url').text()
                    };

                data.site = JSON.stringify(site);

                $.ajax({
                    url: 'admin-post.php',
                    type: 'POST',
                    data: $.param(data)
                }).then(function(data) {
                    console.log(data);
                });

                $site.remove();
                update();
            },

            deleteSelected = function() {
                var $selected = elements.checkbox.filter(':checked');

                $selected.each(function() {
                    deleteSite.call(this);
                });
            },

            bindAddSiteOnEnterKey = function(e) {
                if (keyCodes.enter === e.keyCode) {
                    $form.trigger('submit');
                }
            },

            onFormSubmit = function() {
                validate(function() {
                    addSite();
                    sendData();
                });

                return false;
            },

            toggleSelectAll = function() {
                if ($(this).is(':checked')) {
                    elements.checkbox.attr('checked', 'checked');
                }

                else {
                    elements.checkbox.removeAttr('checked');
                }
            },

            clearInputs = function() {
                elements.inputs.val('');
            };

        cache();
        updateUid();
        bindEvents();
	});

}(window, document, jQuery));