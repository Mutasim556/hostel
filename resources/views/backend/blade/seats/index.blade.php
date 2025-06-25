@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Add Seats') }}
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
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Add Seats') }}</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('admin.seat.store') }}" method="POST" id="add_seat_form">
                            @csrf
                            <div class="row">
                                 <div class="form-group col-md-4 col-xs-6 col-sm-6">
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
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label for="">{{ __('admin_local.Floor') }} *</label>
                                    <select class="form-control" name="floor" id="floor" required>
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $formatter = new \NumberFormatter('en_US', \NumberFormatter::ORDINAL);
                                        @endphp
                                        @for ($i = 1; $i <= 20; $i++)
                                            <option value="{{ $formatter->format($i) }}">{{ $formatter->format($i) }}</option>
                                        @endfor
                                    </select>
                                    <span class="text-danger err-mgs"></span>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_multiple_block" id="has_multiple_block" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has multiple block ?') }}</strong></label>
                                </div>
                            </div>
                            <div id="append_block_seats_div" style="display:none">
                                <div class="row">
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.seats Number') }}</label>
                                        <input type="text" class="form-control" id="seats_number" name="seats_number"  placeholder="{{ __('admin_local.Example') }} : 101">
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.Block') }}</label>
                                        <select class="form-control" id="block" name="block">
                                            <option value="">{{ __('admin_local.Select Please') }}</option>  
                                            <option value="A">A</option>  
                                            <option value="B">B</option>  
                                            <option value="C">C</option>  
                                            <option value="D">D</option>  
                                            <option value="E">E</option>  
                                        </select>
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.seats Type') }} *</label>
                                        <select class="form-control" name="seats_type" id="seats_type">
                                            <option value="">{{ __('admin_local.Select Please') }}</option>
                                            <option value="AC">{{ __('admin_local.AC') }}</option>
                                            <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
                                        </select>
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-3 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.seats Dimension') }} (sqf)</label>
                                        <input type="text" class="form-control" id="seats_dimension" name="seats_dimension" placeholder="{{ __('admin_local.Example') }} : 1200">
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                </div>
                            </div>
                            <div id="append_wblock_seats_div">
                                <div class="row">
                                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.seats Number') }}</label>
                                        <input type="text" class="form-control" id="seats_number" name="seats_number"  placeholder="{{ __('admin_local.Example') }} : 101">
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    
                                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.seats Type') }} *</label>
                                        <select class="form-control" name="seats_type" id="seats_type">
                                            <option value="">{{ __('admin_local.Select Please') }}</option>
                                            <option value="AC">{{ __('admin_local.AC') }}</option>
                                            <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
                                        </select>
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                        <label for="">{{ __('admin_local.seats Dimension') }} (sqf)</label>
                                        <input type="text" class="form-control" id="seats_dimension" name="seats_dimension" placeholder="{{ __('admin_local.Example') }} : 1200">
                                        <span class="text-danger err-mgs"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <input type="checkbox" name="is_full_seats_bookable" id="is_full_seats_bookable" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Is full seats bookable ?') }}</strong></label>
                                </div>
                                <div class="form-group col-md-3 col-xs-6 col-sm-6" id="append_max_price" style="display:none">
                                    <label for="">{{ __('admin_local.seats Price') }}</label>
                                    <input type="text" class="form-control" id="seats_max_price" name="seats_max_price">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="form-group col-md-3 col-xs-6 col-sm-6" id="append_min_price" style="display:none">
                                    <label for="">{{ __('admin_local.seats Minumm Price') }}</label>
                                    <input type="text" class="form-control" id="seats_min_price" name="seats_min_price">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_attached_bathseats" id="has_attached_bathseats" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has attached bathseats ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="has_attached_balcony" id="has_attached_balcony" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has attached balcony ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mt-2">
                                    <input type="checkbox" name="is_smoking_allowed" id="is_smoking_allowed" > &nbsp;
                                    <label for="is_smoking_allowed"><strong>{{ __('admin_local.Is smoking allowed ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 mt-2" id="has_seats_div">
                                    <input type="checkbox" name="has_seats" id="has_seats" > &nbsp;
                                    <label for="hostel_name"><strong>{{ __('admin_local.Has seats ?') }}</strong></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Window') }}</label>
                                    <input type="number" class="form-control" id="total_window" name="total_window">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Fan') }}</label>
                                    <input type="number" class="form-control" id="total_fan" name="total_fan">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                                <div class="form-group col-md-4 col-xs-6 col-sm-6">
                                    <label for="">{{ __('admin_local.Total Light') }}</label>
                                    <input type="number" class="form-control" id="total_light" name="total_light">
                                    <span class="text-danger err-mgs"></span>
                                </div>
                            </div>
                            
                            <div id="append_seat_div">

                            </div>
                            <div class="row">
                                 <div class="col-lg-12 mt-2">
                                    <button class="btn btn-success" type="submit" id="submit_btn" style="float:right"><strong>{{ __('admin_local.Submit') }}</strong></button>
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

        var form_url = "{{ route('admin.seats.store') }}";
        var translate_url = `{{ route('admin.translateString') }}`;
        var submit_btn_after = `<strong>{{ __('admin_local.Submitting') }} &nbsp; <i class="fa fa-rotate-right fa-spin"></i></strong>`;
        var submit_btn_before = `<strong><i class="fa fa-paper-plane"></i> &nbsp; {{ __('admin_local.Submit') }}</strong>`;

        
    </script>
    <script src="{{ asset('public/admin/custom/seatss/add_seats.js') }}"></script>
@endpush
