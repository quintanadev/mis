"use strict";

// Class Definition
var IncidentDetail = function() {

    var InitIncident = function (query) {
        $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('support/incident/get-incident-detail'),
            async: true,
            data: {id: query.get('id')},
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var res = JSON.parse(result);
                
                $('#id_incident').html(res.id_incident);
                $('#user_created').val(res.user_created);
                $('#created_at').val(res.created_at + ' ' + res.created_hour);
                $('#email').val(res.email);
                $('#operation').val(res.operation);
                $('#request_type').val(res.request_type);
                $('#request').val(res.request);
                $('#dstatus').val(res.status);
                $('#sla_solution').val(res.sla_solution);

                var description = JSON.parse(res.description);
                var quill = new Quill("#description", {readOnly: true});
                quill.setContents(description.ops);
                
                MetApp.stopPageLoading();
            }
        });
    };

    var InitComment = function (query) {
        $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('support/incident/get-incident-comment'),
            async: true,
            data: {id: query.get('id')},
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var res = JSON.parse(result);

                for (var i = 0; i < res.length; i++) {
                    var comemnt = ' \
                        <li class="clearfix ' + (res[i].is_mod_support_incident ? 'odd' : '') + '"> \
                            <div class="chat-avatar"> \
                                <img src="' + MetApp.getSiteUrl('assets/media/users/' + res[i].avatar) + '" alt="' + res[i].user_name + '"> \
                                <i> ' + res[i].created_at + ' </i> \
                                <i> ' + res[i].created_hour + ' </i> \
                            </div> \
                            <div class="conversation-text"> \
                                <div class="ctext-wrap"> \
                                    <i> ' + res[i].user_name + ' ( ' + res[i].status + ' ) </i> \
                                    <p> ' + res[i].comment + ' </p> \
                                </div> \
                            </div> \
                        </li>';

                    $('.conversation-list').append(comemnt);
                }
                
                MetApp.stopPageLoading();
            }
        });
    };

    // Public Functions
    return {
        init: function() {

            var query = new URLSearchParams(window.location.search);

            InitIncident(query);
            InitComment(query);

            $('[data-toggle="input-mask"]').each(function(a, e) {
                var t=$(e).data("maskFormat"), n=$(e).data("reverse");
                null!=n ? $(e).mask(t,{reverse:n}) : $(e).mask(t);
            });

            var quillComment = new Quill("#comment", {
                theme: "snow",
                placeholder: 'Descreva sua resposta ou comentário.',
                modules: {
                    toolbar: [
                        [{ font: [] }],
                        ["bold", "italic", "link"],
                        [{ color: [] }, { background: [] }],
                        [{ header: [!1,1,2,3,4,5,6] }, "blockquote", "code-block"],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            });

        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    IncidentDetail.init();
});
