@extends('front-user.layouts.master_user')


@section('content')
<section class="blog-individual">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <div class="separate-blog">
                
                <div class="blog-text blogBox">
                    <a href="{{url('create-meeting')}}" class="btn btn-primary"> Create Meeting </a>

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
                        @foreach($meetings as $row)
                            <tr>

                                <td>{{ @$row->created_at }}</td>
                                <td>{{ @$row->topic }}</td>
                                <td class="text-center" style="white-space:nowrap;">
                                    <a href="{{URL::to('/show-meeting',['meeting_id'=>@$row->meeting_id])}}" title="Show"><i class="fa fa-eye fa-fw fa-lg"></i></a>
                                </td>

                            </tr>
                            <?php $i++; ?>
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</section>

@endsection

@section('script_links')


@endsection

@section('script_codes')
@endsection