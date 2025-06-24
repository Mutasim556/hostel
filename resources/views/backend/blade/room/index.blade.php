@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Room List') }}
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

    {{-- Add room Modal Start --}}

    <div class="modal fade" id="add-room-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add room') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="add_room_form">
                        @csrf
                        <div class="row">
                            {{-- <div class="col-lg-12 mt-2">
                                <label for="room"><strong>{{ __('admin_local.room') }} *</strong></label>
                                <select class="js-example-basic-single" name="room" id="room">
                                    @foreach (config('room') as $key=>$lang)
                                        <option value="{{ $key }}" {{ $key=='en'?'selected':'' }}>{{ $lang['name'] }}</option>
                                    @endforeach

                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="name"><strong>{{ __('admin_local.Name') }} ( {{ __('admin_local.Default') }} ) *</strong></label>
                                <input type="text" class="form-control" name="name" id="name" readonly>
                                <span class="text-danger err-mgs"></span>
                            </div> --}}

                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('admin_local.Submit') }}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add room Modal End --}}

    {{-- Add room Modal Start --}}

    <div class="modal fade" id="edit-room-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit room') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="edit_room_form">
                        @csrf
                        <input type="hidden" id="room_id" name="room_id" value="">
                        <div class="row">
                            {{-- <div class="col-lg-12 mt-2">
                                <label for="room"><strong>{{ __('admin_local.room') }} *</strong></label>
                                <select class="js-example-basic-single1" name="room" id="room">
                                    @foreach (config('room') as $key=>$lang)
                                        <option value="{{ $key }}">{{ $lang['name'] }}</option>
                                    @endforeach

                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div> --}}
                            {{-- <div class="col-lg-6 mt-2">
                                <label for="name"><strong>{{ __('admin_local.Name') }} ( {{ __('admin_local.Default') }} ) *</strong></label>
                                <input type="text" class="form-control" name="name" id="name" readonly>
                                <span class="text-danger err-mgs"></span>
                            </div> --}}

                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('admin_local.Submit') }}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add room Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.room List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['room-create']))
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <a href="{{ route('admin.room.create') }}" class="btn btn-success" >+  {{ __('admin_local.Add Room')}}</a>
                            </div>
                        </div>
                        @endif
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Hostel') }}</th>
                                        <th>{{ __('admin_local.Floor') }}</th>
                                        <th>{{ __('admin_local.Room Number') }}</th>
                                        <th>{{ __('admin_local.Block') }}</th>
                                        <th>{{ __('admin_local.Is full bookable ?') }}</th>
                                        <th>{{ __('admin_local.Room Price') }}</th>
                                        <th>{{ __('admin_local.Minimum Price') }}</th>
                                        <th>{{ __('admin_local.Attached Bathroom') }}</th>
                                        <th>{{ __('admin_local.Attached Balcony') }}</th>
                                        <th>{{ __('admin_local.Smoking Allowed') }}</th>
                                        <th>{{ __('admin_local.Total Window') }}</th>
                                        <th>{{ __('admin_local.Total Fan') }}</th>
                                        <th>{{ __('admin_local.Total Light') }}</th>
                                        <th>{{ __('admin_local.Room Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $room)
                                        <tr id="trid-{{ $room->id }}" data-id="{{ $room->id }}">
                                            <td>{{ $room->hostel->hostel_name }}</td>
                                            <td>{{ $room->floor }}</td>
                                            <td>{{ $room->room_number }}-{{ $room->block }}</td>
                                            <td>{{ $room->block }}</td>
                                            <td>{{ $room->is_full_bookable?__('admin_local.Yes'):__('admin_local.No') }}</td>
                                            <td>{{ $room->full_room_max_price??'N/A' }}</td>
                                            <td>{{ $room->full_room_min_price??'N/A' }}</td>
                                            <td>{{ $room->has_attached_bath_room?__('admin_local.Yes'):__('admin_local.No') }}</td>
                                            <td>{{ $room->has_attached_balcony?__('admin_local.Yes'):__('admin_local.No') }}</td>
                                            <td>{{ $room->is_smoking_allowed?__('admin_local.Yes'):__('admin_local.No') }}</td>
                                            <td>{{ $room->total_window }}</td>
                                            <td>{{ $room->total_fan }}</td>
                                            <td>{{ $room->total_light }}</td>

                                            <td class="text-center">
                                                @if (hasPermission(['room-update']))
                                                <span class="mx-2">{{ $room->status==1?'Active':'Inactive' }}</span><input
                                                    data-status="{{ $room->status == 1 ? 0 : 1 }}"
                                                    id="status_change" type="checkbox" data-toggle="switchery"
                                                    data-color="green" data-secondary-color="red" data-size="small"
                                                    {{ $room->status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __("admin_local.No Permission") }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (hasPermission(['room-update','room-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['room-update']))
                                                            <a style="cursor: pointer;" href="{{ route('admin.room.edit',$room->id) }}"><i class=" fa fa-edit mx-1"></i> {{ __('admin_local.Edit')}}</a>
                                                        @endif
                                                        @if (hasPermission(['room-delete']))
                                                            <a class="text-danger" id="delete_button"
                                                            style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                                            {{ __('admin_local.Delete') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @else
                                                    <span class="badge badge-danger">{{ __("admin_local.No Permission") }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            @csrf
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->
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
            dropdownParent: $('#add-room-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-room-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable();

        var form_url = "{{ route('admin.room.store') }}";
    </script>
    <script src="{{ asset('public/admin/custom/rooms/room_list.js') }}"></script>
@endpush
