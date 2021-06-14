@extends('layout')

@section('content')
    <div class="container" style="margin-top: 22vh;">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class="text-center text-warning mb-md-3" style="font-size: 6rem;">Sorry!</h1>
                <h4 class="text-center text-warning mb-md-3" >We are unable to process your payment</h4>
            </div>
            
            <div class="col-md-6 offset-md-3">
                <div class="text-center mb-md-3">
                    <span class="h3 text-danger">Error Reason: </span><em class="lead">{{$errorText}}</em>
                </div>
                
                <div class="d-flex justify-content-center">
                    <a href="https://mushkilasan.com/" class="mt-2 btn btn-lg btn-outline-success">Go Back</a>
                </div>
            </div>
        </div>
    </div>

@endsection