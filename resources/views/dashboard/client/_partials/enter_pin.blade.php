<div id="enter_pin" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <i class="fa fa-times fa-2x" aria-hidden="true"></i>
                </button>
                <div class="modal-title huge text-center">{!! trans('toot_card.enter_pin') !!}</div>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="input-pin-code">
                        <input type="hidden" id="last_resort" value="0">
                        <input type="hidden" id="_toot_card_id" name="_toot_card_id">
                        <input id="pin_code" name="pin_code" type="password" class="form-control input-lg text-center huge-md bs-input-unstyled"
                               placeholder="Pin code" pattern="[0-9]{4}" maxlength="4">
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="1">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="2">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="3">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="4">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="5">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="6">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="7">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="8">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="9">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-default btn-lg key btn-block huge" type="button">&nbsp;</button>
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key btn-block huge" type="button"
                                       value="0">
                            </td>
                            <td>
                                <button class="btn btn-default btn-lg key btn-block huge" type="button">&nbsp;</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-danger btn-lg key btn-block huge" type="button"
                                        data-dismiss="modal">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-lg key btn-block huge backspace" type="button">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-success btn-lg key btn-block huge submit-check" type="button"  data-loading-text="<i class='fa fa-spinner fa-pulse'></i>">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>