    <!-- latest jquery-->
    <script src="{{ URL::asset("/template/assets/js/jquery-3.5.1.min.js") }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ URL::asset("/template/assets/js/bootstrap/bootstrap.bundle.min.js") }}"></script>
    <!-- feather icon js-->
    <script src="{{ URL::asset("/template/assets/js/icons/feather-icon/feather.min.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/icons/feather-icon/feather-icon.js") }}"></script>
    <!-- scrollbar js-->
    <script src="{{ URL::asset("/template/assets/js/scrollbar/simplebar.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/scrollbar/custom.js") }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ URL::asset("/template/assets/js/config.js") }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ URL::asset("/template/assets/js/sidebar-menu.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/chart/chartist/chartist.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/chart/chartist/chartist-plugin-tooltip.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/chart/knob/knob.min.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/chart/knob/knob-chart.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/chart/apex-chart/apex-chart.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/chart/apex-chart/stock-prices.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/notify/bootstrap-notify.min.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/dashboard/default.js") }}"></script>
    <!-- <script src="{{ URL::asset("/template/assets/js/notify/index.js") }}"></script> -->
    <script src="{{ URL::asset("/template/assets/js/datepicker/date-picker/datepicker.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/datepicker/date-picker/datepicker.en.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/datepicker/date-picker/datepicker.custom.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/typeahead/handlebars.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/typeahead/typeahead.bundle.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/typeahead/typeahead.custom.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/typeahead-search/handlebars.js") }}"></script>
    <script src="{{ URL::asset("/template/assets/js/typeahead-search/typeahead-custom.js") }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{ URL::asset("/template/assets/js/script.js") }}"></script>
    <!-- <script src="{{ URL::asset("/template/assets/js/theme-customizer/customizer.js") }}"></script> -->
    <script src="{{ URL::asset("/sweetalert2/dist/sweetalert2.min.js") }}"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ URL::asset('/qrcodejs/qrcode.js') }}"></script>
    <!-- login js-->

    <script>
        var qr_base = document.getElementById('qr_image')
        var make_code = new QRCode(qr_base, '');

        function view_qr(kode) {
            make_code.makeCode(kode)
                $('#qr_modal').modal('show')
            }
            $("#qr_modal").on("hidden.bs.modal", function() {
                make_code.clear();
            });

            function hapus_data(event) {
                let button = $(event.target)
                let form_id = button.attr('form-id')
                let form = $(form_id)

                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data tidak bisa di kembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                })
            }

            for (let index = 0; index < 3; index++) {
                $('#myselect' + index).select2();

            }

            function menu_active(base) {
                let menus = $(base)
                menus.find('a').addClass('active').click()
            }

            function active_menu(base, item) {
                let menu = $(base)
                menu.find(item).addClass('active')
                menu.find('a').click()
            }

            function logout(id) {
                let form = $(id)
                //console.log(form)
                Swal.fire({
                    title: 'Anda yakin Logout?',
                    text: "Keluar dari sistem",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Logout!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit()
                    }
                })
            }
    </script>
    <!-- Plugin used-->
    @if(session('success'))

    <script>
        Swal.fire(
            'Sukses!',
            "{{ session('success') }}",
            'success'
        )
    </script>

    @endif

    @if(session('error'))

    <script>
        Swal.fire(
            'Error!',
            "{{ session('error') }}",
            'error'
        )
    </script>


    @endif


    @stack('js')