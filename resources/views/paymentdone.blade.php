@extends('layouts.app')

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="entry-header-area ptb-40">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="entry-header">
                   <center><img src="{{url('/')}}/assets/images/payment_sucess.jpg" alt="payment sucess"></center>
                  <div class="text-center">
                  <a href="{{ route('dashboard') }}" class="btn btn-info mt-2"><i class="fa fa-arrow-circle-left"></i>Dashborad</a>
                  <a  class="btn btn-danger mt-2" >Send Sms </a>
                  </div> 

                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>


@endsection
