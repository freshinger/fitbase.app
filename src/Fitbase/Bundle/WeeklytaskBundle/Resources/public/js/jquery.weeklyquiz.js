$(function () {

    var container = $(document);

    container.bind('weeklyquiz_user_notice', function (event) {

        var id = event.id;
        var text = event.text;
        var correct = event.correct;

        var noticeHTML = '<p class="alert %class%">%text%</p>';
        var noticeClass = correct ? 'alert-success' : 'alert-warning';
        var notice = $(noticeHTML.replace('%text%', text).replace('%class%', noticeClass));

        notice.insertAfter($('input[value=' + id + ']').closest('label'));
    });

});