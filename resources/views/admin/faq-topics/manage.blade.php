@extends('admin.layouts.master_admin')

@section('page_title')
{{config('app.name')}} | Manage Faq Topics
@endsection


@section('content')



    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Faq Topics</h1>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{Request::root()}}/admin/add-faq-topic" class="btn btn-success btn-gold-styled pull-right"><i class="fa fa-plus"></i> Add Faq Topic</a>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="example1">
                        <thead>
                        <tr>
                            <th class="column-title">Created At </th>
                            <th class="column-title">Topic </th>
                            <th class="column-title text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;  ?>
                        @foreach($result as $row)
                            <tr>

                                <td>{{ @$row->created_at }}</td>
                                <td>{{ @$row->topic }}</td>
                                <td class="text-center" style="white-space:nowrap;">
                                    <a href="{{URL::to('/admin/edit-faq-topic',['id'=>@$row->id])}}" title="Edit"><i class="fa fa-edit fa-fw fa-lg"></i></a>
                                    
                                    <a href="javascript:void(0);" class="deleteFaqTopic" id="{{@$row->id}}" title="Delete"><i class="fa fa-trash fa-fw fa-lg"></i></a>

                                </td>

                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{--Footer--}}
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection


@section('admin_script_links')  
@endsection
@section('admin_script_codes')
<script>
    $(document).ready(function() {
        $('#example1').DataTable(
        {
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "visible": false,
                    "searchable": false
                },
                {
                    "targets": [2],
                    "orderable": false
                }
            ]
        });
    } );
</script>
<script type="text/javascript">
    $(document).ready(function () {

            $("#example1").on("click", ".deleteFaqTopic", function (e) {

                e.preventDefault();
                let id = $(this).attr('id');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this FAQ Topic!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "No, cancel please!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                type: "post",
                                url: "{{ url('/admin/delete-faq-topic') }}",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    "id": id
                                },
                                success: function (response) {

                                    if (response.status == "success") {
                                        toastr.success(response.msg);

                                        setTimeout(function () {
                                            location.reload();
                                        }, 5000)

                                    }
                                    if (response.status == "error") {
                                        toastr.info(response.msg);
                                        setTimeout(function () {
                                            location.reload();
                                        }, 5000)
                                    }
                                }
                            });
                            swal("Deleted!", "FAQ Topic deleted successfully.", "success");
                        } else {
                            swal("Cancelled", "FAQ Topic is safe :)", "error");
                        }
                    });
            });
        });

</script>
@endsection