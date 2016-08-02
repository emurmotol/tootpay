<div id="enter_pin_code" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title text-center">toot <i class="fa fa-credit-card"></i></h3>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <div class="input-pin-code">
                        <input type="hidden" id="id" name="id">
                        <input id="pin_code" name="pin_code" type="number" class="form-control input-lg text-center"
                               placeholder="Your Pin Code" pattern="[0-9]{4}" maxlength="4">
                    </div>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="1">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="2">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="3">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="4">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="5">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="6">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="7">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="8">
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="9">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-default btn-lg key" type="button">&nbsp;</button>
                            </td>
                            <td>
                                <input class="btn btn-default btn-lg key" type="button"
                                       value="0">
                            </td>
                            <td>
                                <button class="btn btn-default btn-lg key" type="button">&nbsp;</button>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-danger btn-lg key" type="button"
                                        data-dismiss="modal">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td>
                                <button id="backspace" class="btn btn-warning btn-lg key" type="button">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-success btn-lg key" type="button" id="submit_check">
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