/**
 * Created by sensey on 9/24/14.
 */
(function ($) {

    function Chat(container) {
        this.init(container)
    }

    $.extend(Chat.prototype, {

        onSubmitForm: function (form, callback) {
            jQuery.post(fitbase.gamification, form.serialize(), callback);
        },

        init: function (container) {

            var self = this;

            jQuery.get(fitbase.gamification, function (data) {
                container.append(jQuery(data));
                container.scrollTop(container.prop('scrollHeight'));
            });


            jQuery(document).bind('gamification_emotion_click', function (event) {
                var element = jQuery(event.element);
                var form = element.closest('form');
                form.slideUp('fast', function () {

                    var elementContainer = jQuery('<div />');
                    elementContainer.append(element.find('img'));

                    var container = element.closest('div.chat-message');
                    container.append(elementContainer);

                    form.remove();
                });
                return false;
            });


            container
                .on('click', '#gamification_dialog_user_answer_true', function (event) {
                    // Get clicked element
                    // to extract a text
                    var element = jQuery(this);
                    // Get form element
                    // exact for clicked control
                    var form = element.closest('form');
                    // Set answer value as true
                    // to store in database
                    form.find('#gamification_dialog_user_answer_value').val(1);

                    self.onSubmitForm(form, function (data) {
                        // Show new form element
                        container.append(jQuery(data));
                        container.scrollTop(container.prop('scrollHeight'));

                        var elementText = jQuery('<span />');
                        elementText.text(element.text());
                        elementText.hide('fast');

                        // Remove control elements
                        // from form, only one answer possibility
                        form.find('button').slideUp('fast', function () {
                            form.append(elementText);
                            elementText.slideDown('fast', function () {
                                form.find('button').remove();
                            })
                        });
                    });

                    return false;
                })
                .on('click', '#gamification_dialog_user_answer_false', function (event) {
                    // Get clicked element
                    // to extract a text
                    var element = jQuery(this);
                    // Get form element
                    // exact for clicked control
                    var form = element.closest('form');
                    // Set answer value as false
                    // to store in database
                    form.find('#gamification_dialog_user_answer_value').val(0);

                    self.onSubmitForm(form, function (data) {
                        // Show new form element
                        container.append(jQuery(data));
                        container.scrollTop(container.prop('scrollHeight'));

                        var elementText = jQuery('<span />');
                        elementText.text(element.text());
                        elementText.hide('fast');

                        // Remove control elements
                        // from form, only one answer possibility
                        form.find('button').slideUp('fast', function () {
                            form.append(elementText);
                            elementText.slideDown('fast', function () {
                                form.find('button').remove();
                            })
                        });
                    });

                    return false;

                }).on('click', '#gamification_dialog_user_answer_submit', function () {
                    // Get form element
                    // exact for clicked control
                    var form = jQuery(this).closest('form');

                    self.onSubmitForm(form, function (data) {
                        // Show new form element
                        container.append(jQuery(data));
                        container.scrollTop(container.prop('scrollHeight'));

                        var buttons = form.find('button');
                        buttons.slideUp('fast', function () {
                            buttons.remove();
                        });

                        var textarea = form.find('textarea');
                        textarea.hide('fast', function () {
                            var elementText = jQuery('<span />');
                            elementText.text(textarea.val());
                            form.append(elementText);
                            textarea.remove()
                        });
                    });

                    return false;
                }).on('click', '#gamification_dialog_user_answer_trash', function () {
                    // Get form element
                    // exact for clicked control
                    var form = jQuery(this).closest('form');

                    var messages = container.find('.chat-message');
                    messages.slideUp('fast', function () {
                        messages.remove();
                    });

                    self.onSubmitForm(form, function (data) {
                        // Show new form element
                        container.append(jQuery(data));
                        container.scrollTop(container.prop('scrollHeight'));
                    });

                    return false;
                })
                .on('submit', 'form[name=gamification_user_emotion]', function (event) {

                    // Get form element
                    // exact for clicked control
                    var form = jQuery(this);

                    self.onSubmitForm(form, function (data) {
                        // Show new form element
                        container.append(jQuery(data));
                        container.scrollTop(container.prop('scrollHeight'));
                    });

                    return false;
                });
        }

    })


    $.fn.chat = function (options) {

        var option = $.extend({
            'width': '100%',
            'padding': '8px',
            'height': '385px',
            'overflow-y': 'scroll'
        }, options);

        var container = $(this);
        for (style in options) {
            container.css(style, options[style]);
        }

        return new Chat(container);
    }

})(jQuery);
