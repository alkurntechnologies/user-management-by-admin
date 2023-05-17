@extends('front-user.layouts.master_user')


@section('content')
<section class="blog-individual">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
            <div class="separate-blog">
                
                <div class="blog-text blogBox">
                    <div class="table-responsive">
                    <table class="table" id="example1">
                        <thead>
                        <tr>
                            <th class="column-title">Topic </th>
                            <th class="column-title">Agenda </th>
                            <th class="column-title">Start Time </th>
                            <th class="column-title">duration </th>
                            <th class="column-title">Start Url </th>
                            <th class="column-title">Join Url </th>
                            <th class="column-title">Password </th>
                            <th class="column-title">Status </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $meeting['data']['topic'] }}</td>
                                <td>{{ $meeting['data']['agenda'] }}</td>
                                <td>{{ $meeting['data']['start_time'] }}</td>
                                <td>{{ $meeting['data']['duration'] }}</td>
                                <td>{{ $meeting['data']['start_url'] }}</td>
                                <td>{{ $meeting['data']['join_url'] }}</td>
                                <td>{{ $meeting['data']['password'] }}</td>
                                <td>{{ $meeting['data']['status'] }}</td>
                            </tr>
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