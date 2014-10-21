/**
 * Created by sensey on 9/23/14.
 */
jQuery(function (event) {

    jQuery(document).bind('gamification_emotion', function (event) {

        var container = jQuery(event.selector);
        container.on('click', 'a.emotion', function (event) {

            container.find('a').click(function () {
                return false;
            })

            jQuery(document).trigger({
                type: 'gamification_emotion_click',
                element: this
            });

            var association = {
                'anger': 1,
                'sad': 2,
                'normal': 3,
                'gut': 4,
                'happy': 5
            }

            var link = jQuery(this);
            var textField = container.find('input[type=hidden]');
            textField.val(association[link.attr('id')]);

            container.submit();

            return false;
        });
    });
});
