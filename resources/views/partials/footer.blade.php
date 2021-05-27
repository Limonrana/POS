@guest

@else
    <footer>
        <div class="row no-gutters justify-content-between fs--1 mt-4 mb-3">
            <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">© 2020 Copyright Inventory POS <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none" /> By <a href="https://limonrana.com/">Limon Rana</a></p>
            </div>
            <div class="col-12 col-sm-auto text-center">
                <p class="mb-0 text-600">v1.0.0</p>
            </div>
        </div>
    </footer>
    </div>
@endguest

</div>
</main><!-- ===============================================-->
<!--    End of Main Content-->
<!-- ===============================================-->

<script>
    var isFluid = JSON.parse(localStorage.getItem('isFluid'));
    if (isFluid) {
        var container = document.querySelector('[data-layout]');
        container.classList.remove('container');
        container.classList.add('container-fluid');
    }
</script>

<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/lib/%40fortawesome/all.min.js') }}"></script>
<script src="{{ asset('assets/lib/stickyfilljs/stickyfill.min.js') }}"></script>
<script src="{{ asset('assets/lib/sticky-kit/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/lib/is_js/is.min.js') }}"></script>
<script src="{{ asset('assets/lib/lodash/lodash.min.js') }}"></script>
<script src="{{ asset('assets/lib/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700%7cPoppins:100,200,300,400,500,600,700,800,900&amp;display=swap" rel="stylesheet">
<script src="{{ asset('assets/lib/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/lib/datatables.net-responsive/dataTables.responsive.js') }}"></script>
<script src="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/lib/leaflet/leaflet.js') }}"></script>
<script src="{{ asset('assets/lib/leaflet.markercluster/leaflet.markercluster.js') }}"></script>
<script src="{{ asset('assets/lib/leaflet.tilelayer.colorfilter/leaflet-tilelayer-colorfilter.min.js') }}"></script>
<script src="{{ asset('assets/lib/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('assets/lib/dropzone/dropzone.min.js')}}"></script>
<script src="{{ asset('assets/js/theme.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    @if(Session::has('alert'))
    var type="{{Session::get('alert-type','info')}}"
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('alert') }}");
            break;
        case 'success':
            toastr.success("{{ Session::get('alert') }}");
            break;
        case 'warning':
            toastr.warning("{{ Session::get('alert') }}");
            break;
        case 'error':
            toastr.error("{{ Session::get('alert') }}");
            break;
    }
    @endif
</script>

<script>
    $(document).on("click", "#delete", function(e){
        e.preventDefault();
        var link = $(this).attr("href");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = link;
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        })
    });
</script>
@yield('admin-js')
</body>

</html>
