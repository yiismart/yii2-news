var news = {
    init: function() {
        $('#make-alias').on('click', this.make_alias);
    },
    make_alias: function() {
        var $button = $(this), $input = $('#newsform-alias');
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
