@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Add Room') }}
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
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Add Rooms') }}</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" action="">
                            <div class="row">
                                 <div class="form-group col-md-2 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Hostel') }} *</label>
                                    <select class="form-control" name="hostel" id="hostel">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $hostels = \App\Models\Admin\Hostel::where([['status',1],['delete',0]])->get();
                                        @endphp
                                        @foreach ($hostels as $hostel)
                                            <option value="{{ $hostel->id }}">{{ $hostel->hostel_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Room Type') }} *</label>
                                    <select class="form-control" name="room_type" id="room_type">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="AC">{{ __('admin_local.AC') }}</option>
                                        <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">{{ __('admin_local.Floor') }} *</label>
                                    <select class="form-control" name="floor" id="floor" required>
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $formatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
                                        @endphp
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $formatter->format($i) }}-{{ $i }}">{{ $formatter->format($i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Room') }}</label>
                                    <input type="text" class="form-control" id="total_room" value="0" readonly>
                                </div>
                                 <div class="form-group col-md-2 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Block') }}</label>
                                    <select class="form-control" name="block" id="block">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Room Number') }}</label>
                                    <input type="text" class="form-control" id="room_number" name="room_number" value="0" readonly>
                                </div>
                                <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Room Dimension') }} (sqf)</label>
                                    <input type="text" class="form-control" id="room_dimension" name="room_dimension" placeholder="{{ __('admin_local.Example') }} : 1200">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <input type="checkbox" name="is_full_room_bookable" id="is_full_room_bookable" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Is full room bookable ?') }}</strong></label>
                                </div>
                                <div class="form-group col-md-3 col-xs-6 col-sm-6" id="append_max_price" style="display:none">
                                    <label for="">{{ __('admin_local.Room Price') }}</label>
                                    <input type="text" class="form-control" id="room_max_price" name="room_max_price">
                                </div>
                                <div class="form-group col-md-3 col-xs-6 col-sm-6" id="append_min_price" style="display:none">
                                    <label for="">{{ __('admin_local.Room Minumm Price') }}</label>
                                    <input type="text" class="form-control" id="room_min_price" name="room_min_price">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_attached_bathroom" id="has_attached_bathroom" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has attached bathroom ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_attached_balcony" id="has_attached_balcony" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has attached balcony ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Window') }}</label>
                                    <input type="text" class="form-control" id="total_window" name="total_window">
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Fan') }}</label>
                                    <input type="text" class="form-control" id="total_fan" name="total_fan">
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Light') }}</label>
                                    <input type="text" class="form-control" id="total_light" name="total_light">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <input type="checkbox" name="has_seats" id="has_seats" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has seats ?') }}</strong></label>
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6" id="append_total_seats" style="display:none">
                                    <label for="">{{ __('admin_local.Total Seats') }}</label>
                                    <input type="number" class="form-control" id="total_seats" name="total_seats">
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6 pt-4" id="append_total_seats_button" style="display:none">
                                    <button type="button" class="btn btn-primary form-control mt-2" id="append_seats_btn" >{{ __('admin_local.Click here to add seat') }}</button>
                                </div>
                            </div>
                            <div id="append_seat_div">

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

        var form_url = "{{ route('admin.language.store') }}";
        var translate_url = `{{ route('admin.translateString') }}`;
    </script>
    <script src="{{ asset('public/admin/custom/rooms/add_room.js') }}"></script>
@endpush
