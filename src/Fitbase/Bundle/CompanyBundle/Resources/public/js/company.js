jQuery(function ($) {

    $(document).bind('company_logo', function (event) {

        jQuery('#company_logo').val(event.src)
        jQuery('.company_logo_widget img').attr('src', event.src)
        console.info(event.src);
    });


    $(document).on("click", "#company_logo", function () {

        jQuery.data(document.body, 'prevElement', $(this));

        window.send_to_editor = function (html) {

            $(document).trigger({
                type: 'company_logo',
                src: jQuery('img', html).attr('src')
            })

            tb_remove();
        };

        tb_show('Select Image', 'media-upload.php?type=image&TB_iframe=true');
        return false;
    });
});