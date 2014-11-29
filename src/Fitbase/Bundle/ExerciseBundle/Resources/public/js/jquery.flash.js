(function ($) {

    $.fn.flash = function () {
        try {
            var ActiveXFlash = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
            if (ActiveXFlash) {
                return true;
            }
        } catch (e) {
            var MimeTypes = navigator.mimeTypes;
            if (MimeTypes["application/x-shockwave-flash"] != undefined) {
                console.info(MimeTypes["application/x-shockwave-flash"]);

                if (MimeTypes["application/x-shockwave-flash"].enabledPlugin) {
                    return true;
                }
            }
        }
        return false;
    }
})($)