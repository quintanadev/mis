var AppConfig = function() {

    var setSiteSkin = function() {
        $('input[name="site-skin"]').click(function() {
            var skin = $(this).val();
            $.ajax({
                type: 'post',
                data: {'site-skin': skin},
                url: MetApp.getSiteUrl('user/set-skin'),
                beforeSend: function () {
                    MetApp.startPageLoading();
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    if (res.type === 'success') {
                        $(location).attr('href', location);
                    } else {
                        MetApp.alert({
                            container: '',
                            place: 'prepend',
                            message: res.msg,
                            type: res.type + ' text-center'
                        });
                    }
                    MetApp.stopPageLoading();
                }
            });
        });
    };

    return {

        init: function() {
            setSiteSkin();
        }

    };
}();

jQuery(document).ready(function() {    
    AppConfig.init();
});