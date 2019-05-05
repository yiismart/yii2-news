var news = {
    init: function() {
        $('#make-url').on('click', this.make_url);
    },
    make_url: function() {
        var $button = $(this), $input = $('#newsform-url');
        if ($input.hasClass('state-loading')) {
            return;
        }
        $input.addClass('state-loading');
        $.get($button.data('url'), {title: $('#newsform-title').val()}, function(data) {
            $input.val(data).removeClass('state-loading');
        }, 'json');
    }
};

news.init();
