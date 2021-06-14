@extends('layout')

@section('content')
    <div class="container" style="margin-top: 35vh;">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center text-danger mb-md-3" style="font-size: 3rem;">Benefit Pay</h1>
                <form action="{{ route('payment_request') }}">
                    <div class="form-group row">
                        <label for="amount" class="col-sm-2 col-form-label col-form-label-lg">Amount</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control form-control-lg" id="amount" name="amount" placeholder="Enter Amount" value="{{$amount}}" readonly>
                            <input type="hidden" name="id" value="{{$user->id}}" />
                            <input type="hidden" name="name" value="{{$user->name}}" />
                            <input type="hidden" name="email" value="{{$user->email}}" />
                            <input type="hidden" name="mobile" value="{{$user->mobileno}}" />
                            <input type="hidden" name="chat_token" value="{{$chat_token}}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2 col-form-label col-form-label-lg"></div>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-lg btn-primary" style="width: 18%">Pay</button>
                            <a href="https://mushkilasan.com/" class="btn btn-lg btn-outline-success ml-2">Go Back</a>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
    </div>

@endsection