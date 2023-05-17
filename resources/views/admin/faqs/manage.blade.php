@extends('admin.layouts.master_admin')

@section('page_title')
{{config('app.name')}} | Manage Faqs
@endsection


@section('content')


<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: green;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Faqs</h1>
                </div>

                <div class="col-sm-6 text-right">
                    <a href="{{Request::root()}}/admin/add-faq" class="btn btn-success btn-gold-styled pull-right"><i class="fa fa-plus"></i> Add Faq</a>
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
                            <th class="column-title">Question </th>
                            <th class="column-title">Status </th>
                            <th class="column-title text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;  ?>
                        @foreach($result as $row)
                            <tr>

                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->topic?@$row->topic->topic:'' }}</td>
                                <td>{{ $row->question }}</td>
                                <td> @if ($row->status == 1)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">De-Active</span>
                                    @endif
                                </td>
                                <td class="text-center" style="white-space:nowrap;">
                                    <a href="{{URL::to('/admin/edit-faq',['id'=>@$row->id])}}" title="Edit"><i class="fa fa-edit fa-fw fa-lg"></i></a>
                                    
                                    <a href="javascript:void(0);" class="deleteFaq" id="{{@$row->id}}" title="Delete"><i class="fa fa-trash fa-fw fa-lg"></i></a>

                                    <label class="switch">
                                      <input data-id="{{@$row->id}}" class="activate" type="checkbox" @if(@$row->status==1) checked @endif >
                                      <span class="slider round"></span>
                                    </label>
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
                    "targets": [4],
                    "orderable": false
                }
            ]
        });
    } );
</script>
<script type="text/javascript">
    $(document).ready(function () {

            $("#example1").on("click", ".deleteFaq", function (e) {

                e.preventDefault();
                let id = $(this).attr('id');
                swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this FAQ!",
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
                                url: "{{ url('/admin/delete-faq') }}",
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
                            swal("Deleted!", "FAQ deleted successfully.", "success");
                        } else {
                            swal("Cancelled", "FAQ is safe :)", "error");
                        }
                    });
            });
        });

    $(document).on("click", ".activate", function (e) {
        var id = $(this).data("id");
        if($(this).prop("checked") == true)
            var status = 1;
        else
            var status = 0;

        $.ajax({
            type: "post",
            url: "{{ url('/admin/activate-deactivate-faq') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "status": status
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

                swal("Success!", response.msg, "success");
            }
        });
        
    });

</script>
@endsection