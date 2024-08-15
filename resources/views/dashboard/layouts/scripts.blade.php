<script src="{{ asset('dashboard') }}/vendors/popper/popper.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/bootstrap/bootstrap.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/jquery-3.7.1.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/popover.js"></script>

<!-- data table -->
<script src="{{ asset('dashboard') }}/vendors/datatable/dataTables.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/dataTables-bootstrap5.js"></script>
{{-- <script src="{{ asset('dashboard') }}/vendors/datatable/dataTables.responsive.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/dataTables.responsive.bootstrap5.js"></script> --}}
<script src="{{ asset('dashboard') }}/vendors/datatable/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable//buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/buttons/2.4.2/js/buttons.colVis.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/dataTables-select.js"></script>
<script src="{{ asset('dashboard') }}/vendors/datatable/dataTables-select-bootstrap5.js"></script>


<!-- End Data Table -->
<!-- <script src="vendors/datatable/select/1.7.0/js/dataTables.select.min.js"></script> -->
<script src="{{ asset('dashboard/assets/js/jquery.validate.js') }}"></script>

<script src="{{ asset('dashboard') }}/vendors/fontawesome/all.min.js?v={{ config('app.js_version') }}"></script>
<script src="{{ asset('dashboard') }}/vendors/lodash/lodash.min.js"></script>
<script src="{{ asset('dashboard') }}/vendors/feather-icons/feather.min.js"></script>
<script src="{{ asset('dashboard') }}/assets/js/phoenix.js"></script>
<script src="{{ asset('dashboard') }}/vendors/sortablejs@1.10.2/Sortable.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="{{ asset('dashboard') }}/assets/js/main.js"></script>
<script src="{{ asset('dashboard') }}/select2-4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('vendor/notify.min.js') }}"></script>
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

@include('sweetalert::alert')
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();
    });

    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: "btn btn-primary mx-6",
                        cancelButton: "btn btn-danger mx-6"
                    },
                    buttonsStyling: false
                });
</script>

@yield('js')
{{-- <script  src="{{ asset('dashboard') }}/vendors/jquery.dataTables.min.js"></script>
 <script  src="{{ asset('dashboard') }}/vendors/dataTables.bootstrap5.min.js"></script>
<script  src="{{ asset('dashboard') }}/vendors/dataTables.responsive.min.js"></script>
 --}}
