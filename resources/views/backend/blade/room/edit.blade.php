@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Edit Room') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/custom.css') }}">
@endpush
@push('page_css')
    <style>
        .loader-box {
            height: auto;
            padding: 10px 0px;
        }

        .loader-box .loader-35:after {
            height: 20px;
            width: 10px;
        }

        .loader-box .loader-35:before {
            width: 20px;
            height: 10px;
        }

    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Edit Room') }}</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('admin.room.store') }}" method="POST" id="edit_room_form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="room_id" id="room_id" value="{{ $room->id }}">
                            <div class="row">
                                 <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Hostel') }} *</label>
                                    <select class="form-control" name="hostel" id="hostel" disabled>
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $hostels = \App\Models\Admin\Hostel::where([['status',1],['delete',0]])->get();
                                        @endphp
                                        @foreach ($hostels as $hostel)
                                            <option value="{{ $hostel->id }}" {{ $hostel->id==$room->hostel->id?'selected':'' }}>{{ $hostel->hostel_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger err-mgs"></span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Floor') }} *</label>
                                    <select class="form-control" name="floor" id="floor" required disabled>
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $formatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
                                        @endphp
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $formatter->format($i) }}" {{ $formatter->format($i)==$room->floor?'selected':'' }}>{{ $formatter->format($i) }}</option>
                                        @endfor
                                    </select>
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="form-group col-md-4" id="building_number_div" @if(!$room->building) style="display:none" @endif>
                                    <label for="">{{ __('admin_local.Building Number') }} *</label>
                                    <select class="form-control" name="building_number" id="building_number" required disabled>
                                            <option value="{{ $room->building }}">{{ $room->building->building_number }}</option>
                                    </select>
                                    <span class="text-danger err-mgs"></span>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_multiple_block" id="has_multiple_block" {{ $room->block!='N/A'?'checked':''}} disabled> &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has multiple block ?') }}</strong></label>
                                </div>
                            </div>
                            @if($room->block!='N/A')
                            <div id="append_block_room_div" >
                                <div class="row">
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Room Number') }}</label>
                                        <input type="text" class="form-control" id="room_number" name="room_number" value="{{ $room->room_number }}" placeholder="{{ __('admin_local.Example') }} : 101">
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Block') }}</label>
                                        <select class="form-control" id="block" name="block">
                                            <option value="">{{ __('admin_local.Select Please') }}</option>
                                            <option value="A" {{ $room->block=='A'?'selected':'' }}>A</option>
                                            <option value="B" {{ $room->block=='B'?'selected':'' }}>B</option>
                                            <option value="C" {{ $room->block=='C'?'selected':'' }}>C</option>
                                            <option value="D" {{ $room->block=='D'?'selected':'' }}>D</option>
                                            <option value="E" {{ $room->block=='E'?'selected':'' }}>E</option>
                                        </select>
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Room Type') }} *</label>
                                        <select class="form-control" name="room_type" id="room_type">
                                            <option value="">{{ __('admin_local.Select Please') }}</option>
                                            <option value="AC" {{ $room->room_type=='AC'?'selected':'' }}>{{ __('admin_local.AC') }}</option>
                                            <option value="NON-AC" {{ $room->room_type=='NON-AC'?'selected':'' }}>{{ __('admin_local.NON-AC') }}</option>
                                        </select>
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Room Dimension') }} (sqf)</label>
                                        <input type="text" class="form-control" id="room_dimension" name="room_dimension" value="{{ $room->room_dimension }}" placeholder="{{ __('admin_local.Example') }} : 1200">
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div id="append_wblock_room_div">
                                <div class="row">
                                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Room Number') }}</label>
                                        <input type="text" class="form-control" id="room_number" name="room_number"  value="{{ $room->room_number }}"  placeholder="{{ __('admin_local.Example') }} : 101">
                                        <span class="text-danger err-mgs"></span>
                                    </div>

                                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Room Type') }} *</label>
                                        <select class="form-control" name="room_type" id="room_type">
                                            <option value="">{{ __('admin_local.Select Please') }}</option>
                                            <option value="AC" {{ $room->room_type=='AC'?'selected':'' }}>{{ __('admin_local.AC') }}</option>
                                            <option value="NON-AC" {{ $room->room_type=='NON-AC'?'selected':'' }}>{{ __('admin_local.NON-AC') }}</option>
                                        </select>
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Room Dimension') }} (sqf)</label>
                                        <input type="text" class="form-control" id="room_dimension" name="room_dimension" value="{{ $room->room_dimension }}" placeholder="{{ __('admin_local.Example') }} : 1200">
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <input type="checkbox" name="is_full_room_bookable" id="is_full_room_bookable" {{ $room->is_full_bookable==1?'checked':''}}> &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Is full room bookable ?') }}</strong></label>
                                </div>
                                <div class="form-group col-md-3 col-xs-6 col-sm-6" id="append_max_price" @if($room->is_full_bookable==0) style="display:none" @endif>
                                    <label for="">{{ __('admin_local.Room Price') }}</label>
                                    <input type="text" class="form-control" id="room_max_price" name="room_max_price" value="{{ $room->is_full_bookable==1?$room->full_room_max_price:0 }}">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="form-group col-md-3 col-xs-6 col-sm-6" id="append_min_price"@if($room->is_full_bookable==0) style="display:none" @endif>
                                    <label for="">{{ __('admin_local.Room Minumm Price') }}</label>
                                    <input type="text" class="form-control" id="room_min_price" name="room_min_price" value="{{ $room->is_full_bookable==1?$room->full_room_min_price:0 }}">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_attached_bathroom" id="has_attached_bathroom" {{ $room->has_attached_bath_room==1?'checked':''}}> &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has attached bathroom ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_attached_balcony" id="has_attached_balcony" {{ $room->has_attached_balcony==1?'checked':''}}> &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has attached balcony ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="is_smoking_allowed" id="is_smoking_allowed" {{ $room->is_smoking_allowed==1?'checked':''}}> &nbsp;
                                    <label for="is_smoking_allowed"><strong>{{ __('admin_local.Is smoking allowed ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2" id="has_seats_div">
                                    <input type="checkbox" name="has_seats" id="has_seats" {{ $room->has_seats==1?'checked':''}}> &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has seats ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Window') }}</label>
                                    <input type="number" class="form-control" id="total_window" name="total_window" value="{{ $room->total_window }}">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Fan') }}</label>
                                    <input type="number" class="form-control" id="total_fan" name="total_fan" value="{{ $room->total_fan }}">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Light') }}</label>
                                    <input type="number" class="form-control" id="total_light" name="total_light" value="{{ $room->total_light }}">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                            </div>

                            <div id="append_seat_div">

                            </div>
                            <div class="row">
                                 <div class="col-lg-12 mt-2">
                                    <button class="btn btn-success" type="submit" id="submit_btn" style="float:right"><strong>{{ __('admin_local.Update') }}</strong></button>
                                 </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('public/admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-language-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-language-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable();

        var translate_url = `{{ route('admin.translateString') }}`;
        var submit_btn_after = `<strong>{{ __('admin_local.Updating') }} &nbsp; <i class="fa fa-rotate-right fa-spin"></i></strong>`;
        var submit_btn_before = `<strong><i class="fa fa-paper-plane"></i> &nbsp; {{ __('admin_local.Update') }}</strong>`;
        var baseUrl = `{{ \URL::to('/') }}`;

    </script>
    <script src="{{ asset('public/admin/custom/rooms/room_list.js') }}"></script>
@endpush
