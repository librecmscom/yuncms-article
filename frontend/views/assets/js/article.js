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
                $.post("/article/article/support", {model_id: model_id}, function (result) {
                    if (result.status === 'success') {
                        support_num++;
                    }
                    btn_support.html(support_num + ' 已推荐');
                    btn_support.data('support_num', support_num);
                });
            });

            $(document).on('click', '[data-target="article-collect"]', function (e) {
                $(this).button('loading');
                var collect_btn = $(this);
                var model_id = $(this).data('model_id');
                var show_num = $(this).data('show_num');
                $.post("/article/article/collection", {model_id: model_id}, function (result) {
                    collect_btn.removeClass('disabled');
                    collect_btn.removeAttr('disabled');
                    if (result.status === 'collected') {
                        collect_btn.html('已收藏');
                        collect_btn.addClass('active');
                    } else {
                        collect_btn.html('收藏');
                        collect_btn.removeClass('active');
                    }

                    /*是否操作收藏数*/
                    if (Boolean(show_num)) {
                        var collect_num = collect_btn.nextAll("#collection-num").html();
                        if (result.status === 'collected') {
                            collect_btn.nextAll("#collection-num").html(parseInt(collect_num) + 1);
                        } else {
                            collect_btn.nextAll("#collection-num").html(parseInt(collect_num) - 1);
                        }
                    }
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