@if(\App\Models\Merchandise::availableEvery(date('w'))->get()->count())
    @foreach($merchandise_category as $category)
        @if(in_array($category->id, collect(\App\Models\Merchandise::availableEvery(date('w'))->get())->pluck('merchandise_category_id')->toArray()))
            <div class="category-name"><strong>{{ $category->name }}</strong></div>
            <div class="merchandise-category-list">
                <ul class="list-inline">
                    @foreach(\App\Models\Merchandise::availableEvery(date('w'))->get() as $merchandise)
                        @if($merchandise->merchandiseCategory->id == $category->id)
                            <li class="merchandise-item">
                                <a href="#merchandise-item-{{ $merchandise->id }}"
                                   data-toggle="modal">
                                    <img class="img-responsive img-rounded"
                                         src="{{ $merchandise->image($merchandise->id) }}"
                                         alt="{{ $merchandise->name }}">
                                </a>

                                <div id="merchandise-item-{{ $merchandise->id }}" class="modal fade"
                                     role="dialog">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close"
                                                        data-dismiss="modal">
                                                    <i class="fa fa-times fa-2x"
                                                       aria-hidden="true"></i>
                                                </button>
                                                <div class="modal-title huge">
                                                    <strong>{{ $merchandise->name }}</strong>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <img class="img-responsive img-rounded"
                                                             src="{{ $merchandise->image($merchandise->id) }}"
                                                             alt="{{ $merchandise->name }}">
                                                    </div>
                                                    <div class="col-md-6 huge">
                                                        Qty:
                                                        <button class="btn btn-default btn-lg minus">
                                                            <i class="fa fa-minus"></i>
                                                        </button>
                                                        <span class="qty">1</span>
                                                        <button class="btn btn-default btn-lg plus">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-info btn-lg pull-left huge"
                                                        data-dismiss="modal">Back
                                                </button>
                                                <button type="button"
                                                        class="btn btn-primary btn-lg pull-right btn-add-order huge"
                                                        data-dismiss="modal"
                                                        data-id="merchandise-item-{{ $merchandise->id }}"
                                                        data-name="{{ $merchandise->name }}"
                                                        data-price="{{ $merchandise->price }}">Add
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
@else
    <div class="row">
        @include('_partials.empty')
    </div>
@endif

