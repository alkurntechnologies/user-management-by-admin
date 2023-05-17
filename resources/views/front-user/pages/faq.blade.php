@extends('front-user.layouts.master_user')

@section('content')
<section class="blogListingSect contact faq">
  <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h2>FAQs</h2>
            @php $j = 1; @endphp  
            @php $i = 1; @endphp
            @foreach($faq_arr as $key => $faqs)
            <div class="faq-division">
                <h3>{{$key}}</h3>

                <!--accordion-->
                <div class="panel-group" id="accordion{{$j}}" role="tablist" aria-multiselectable="true">
                  
                  @foreach($faqs as $faq)
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading-1">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion{{$j}}" href="#collapse-{{$faq->id}}" aria-expanded="false" aria-controls="collapse-1">
                          {{$faq->question}}
                        </a>
                      </h4>
                    </div>
                    <div id="collapse-{{$faq->id}}" class="panel-collapse collapse @if($i==1) show @endif" role="tabpanel" aria-labelledby="heading-1">
                      <div class="panel-body">
                          <div class="accordion-text">
                            {!! $faq->answer !!}
                          </div>
                         
                      </div>
                    </div>
                  </div>
                  @php $i++; @endphp
                  @endforeach                  
                </div>
            </div>
            @php $j++; @endphp
            @endforeach

        </div>
    </div>
  </div>
</section>

@endsection

@section('script_links')


@endsection

@section('script_codes')
@endsection