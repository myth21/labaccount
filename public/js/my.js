/**
 * Config params are required: selector, event(e), ...
 * @param conf
 */
function DeleteModel(conf) {

    if (!conf) return;
    let self = this;
    let isConfirm = conf.confirm && conf.confirm.is || false;
    let confirmMessage = conf.confirm && conf.confirm.message || '';

    self.onReady = function () {

        $(conf.selector).on(conf.e, function (e) {

            if (isConfirm && confirm(confirmMessage)) {
                e.preventDefault();
                let model = $(this).data('model'); // TODO pass via conf
                $.ajax({
                    url: conf.route,
                    type: 'post',
                    data: {_method: 'DELETE', _token: conf.token, 'id': model.id},
                    success: function(response){

                        if (conf.deleteId) {
                            $(conf.deleteId + model.id).fadeOut('slow', function () {
                                $(this).remove();
                            });
                        }
                    },
                    error: function(error){
                        console.warn(error);
                    }
                });

            }

            return false;
        });
    };
}

function DropdownList(conf) {

    if (!conf) return;
    let self = this;

    self.onReady = function () {

        $(conf.selector).on(conf.e, function (e) {

            $.ajax({
                url: conf.route,
                type: 'get',
                data: {'onModelId': $(this).val()},
                success: function(response){

                    let targetList = $(conf.appendToSelector);
                    targetList.empty();
                    $.each(response, function(key, value) {
                        targetList.append("<option value='"+ key +"'>" + value + "</option>");
                    });

                },
                error: function(error){
                    console.warn(error);
                }
            });

        });
    };

    self.runEvent = function(e){
        $(conf.selector).trigger(e);
    };
}

function ShowModal(conf) {

    if (!conf) return;
    let self = this;

    self.onReady = function () {

        $(conf.selector).on(conf.e, function (e) {

            $.ajax({
                url: conf.route,
                type: 'get',
                data: {'onModelId': $(this).val()},
                success: function(response){

                    let target = $(conf.appendToSelector);
                    target.empty();
                    target.append(response);

                },
                error: function(error){
                    console.warn(error);
                }
            });

        });
    };
}