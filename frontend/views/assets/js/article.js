window.yii.article = (function ($) {
    var pub = {
        // whether this module is currently active. If false, init() will not be called for this module
        // it will also not be called for all its child modules. If this property is undefined, it means true.
        isActive: true,
        init: function () {
            console.info('init article.');
            $(".article-comment-btn").click(function () {
                var model_id = $(this).data('model_id');
                var to_user_id = $(this).data('to_user_id');
                var content = $("#comment-" + "content-" + model_id).val();
                pub.add_comment(model_id, content, to_user_id);
                $("#comment-content-" + model_id + "").val('');
            });

            $(document).on('click', '[data-target="article-support"]', function (e) {
                var btn_support = $(this);
                var model_id = btn_support.data('model_id');
                var support_num = parseInt(btn_support.data('support_num'));
                $.post("/article/support/create", {model_id: model_id}, function (result) {
                    if (result.status == 'success') {
                        support_num++;
                    }
                    btn_support.html(support_num + ' 已推荐');
                    btn_support.data('support_num', support_num);
                });
            });
        },

        /**
         * 发布评论
         * @param model_id
         * @param content
         * @param to_user_id
         */
        add_comment: function (model_id, content, to_user_id) {
            var postData = {model_id: model_id, content: content};
            if (to_user_id > 0) {
                postData.to_user_id = to_user_id;
            }
            $.post('/article/comment/create', postData, function (html) {
                $("#comments-" + model_id + " .widget-comment-list").append(html);
                $("#comment-" + "content-" + model_id).val('');
            });
        },

        /**
         * 清除评论
         * @param id
         */
        clear_comments: function (id) {
            $("#comments-" + id + " .widget-comment-list").empty();
        },

        load_comments: function (id) {
            $.get('/article/comment/index', {id: id}, function (html) {
                $("#comments-" + id + " .widget-comment-list").append(html);
            });
        }
    };
    return pub;
})(window.jQuery);