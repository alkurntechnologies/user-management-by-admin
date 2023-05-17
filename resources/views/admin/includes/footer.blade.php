<!-- <footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}} <a href="http://alkurn.com/" target="_blank">Alkurn Technologies</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
        <b>Alkurn Technologies</b> All rights reserved.
    </div>
</footer> -->

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery for dismissible-->

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 --><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>



<script type="text/javascript" src="{{ URL::asset('/assets/front-end/js/parsley.min.js') }}"></script>

<script src="{{ URL::asset('/assets/admin/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('/assets/admin/plugins/toastr/toastr.min.js') }}"></script>

<!-- Summernote -->
<script src="{{asset('/assets/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/assets/admin/js/adminlte.js')}}"></script>


<script src="{{asset('/assets/admin/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('/assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<!-- <script src="{{URL::asset('/assets/front-end/js/bootstrap-datetimepicker.min.js')}}"></script>
 -->

<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>



@yield('admin_script_links')
@yield('admin_script_codes')

<script type="text/javascript">
   if ($(window).width() < 767) {
        $('body').removeClass('sidebar-collapse');
       
    } else {
        $('body').addClass('sidebar-open');
    }  

</script>

<script type="text/javascript">
    $(document).ready(function () {
        window.Parsley.addValidator('fileextension', function (value, requirement) {
            var fileExtension = value.split('.').pop();

            return requirement.includes(fileExtension.toLowerCase());
        }, 32)
            .addMessage('en', 'fileextension', 'Please upload only jpg/png file.');
    });
</script>

</body>
</html>
