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
                                <div class="form-group col-xs-6 col-sm-6 col-md-2">
                                    <label for="">{{ __('admin_local.Room Type') }}</label>
                                    <select class="form-control" name="room_type" id="room_type">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="AC">{{ __('admin_local.AC') }}</option>
                                        <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="">{{ __('admin_local.Floor') }}</label>
                                    <select class="form-control" name="floor" id="floor">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <?php
                                        function getOrdinalSuffix($number) {
                                                if (!in_array(($number % 100), [11, 12, 13])) {
                                                    switch ($number % 10) {
                                                        case 1: return $number . 'st';
                                                        case 2: return $number . 'nd';
                                                        case 3: return $number . 'rd';
                                                    }
                                                }
                                                return $number . 'th';
                                            }

                                            
                                                // echo getOrdinalSuffix($i) . "<br>";
                                            
                                        ?>
                                        @php
                                            for ($i = 1; $i <= 20; $i++) {
                                        @endphp
                                            <option value="{{ getOrdinalSuffix($i) }}">{{ getOrdinalSuffix($i) }}</option>
                                        @php
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <h5>{{ __('admin_local.Room 1') }}</h5>
                                <hr>
                                <div class="row">

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

        var form_url = "{{ route('admin.language.store') }}";
        var translate_url = `{{ route('admin.translateString') }}`;
    </script>
    <script src="{{ asset('public/admin/custom/rooms/add_room.js') }}"></script>
@endpush
