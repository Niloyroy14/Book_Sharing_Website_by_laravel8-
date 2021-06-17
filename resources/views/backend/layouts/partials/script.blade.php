<!-- Bootstrap core JavaScript-->
<script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!--  scripts for Datatable-->
<script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/js/dataTables.bootstrap4.min.js')}}"></script>


<!-- Core plugin JavaScript-->
<script src="{{asset('admin/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Select2 scripts for multiple author-->
<script src="{{asset('admin/js/select2.min.js')}}"></script>

<!-- Summer Note Text Editor scripts for book details-->
<script src="{{asset('admin/js/summernote.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('admin/js/sb-admin-2.min.js')}}"></script>

<!-- Page level plugins -->
<script src="{{asset('admin/vendor/chart.js/Chart.min.js')}}"></script>

<!-- Page level custom scripts -->
<script src="{{asset('admin/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('js/demo/chart-pie-demo.js')}}"></script>



<!-- DataTable and Select2 and SummerNote Run -->
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
        $('.select2').select2();
        $('#summernote').summernote();
    });
</script>