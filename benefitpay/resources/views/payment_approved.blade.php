@extends('layout')

@section('content')
  
  <div class="container mt-md-5">
    <div class="row">
      <div class="offset-md-2 col-md-8">
        <div class="alert alert-dismissible alert-success">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><span class="text-success">Success!</span> Payment Approved.</strong>
        </div>
        <table class="table table-striped table-hover mt-1">
          <tbody>
          <!--<tr>-->
          <!--  <th>Payment ID:</th>-->
          <!--  <td>{{ $paymentID }}</td>-->
          <!--</tr>-->

          <!--<tr>-->
          <!--  <th>Result:</th>-->
          <!--  <td>{{ $result }}</td>-->
          <!--</tr>-->

          <!--<tr>-->
          <!--  <th>Response Code:</th>-->
          <!--  <td>{{ $responseCode }}</td>-->
          <!--</tr>-->

          <!--<tr>-->
          <!--  <th>Payment ID:</th>-->
          <!--  <td>{{ $paymentID }}</td>-->
          <!--</tr>-->

          <tr>
            <th>Transaction ID:</th>
            <td>{{ $transactionID }}</td>
          </tr>

          <!--<tr>-->
          <!--  <th>Reference ID:</th>-->
          <!--  <td>{{ $referenceID }}</td>-->
          <!--</tr>-->

          <!--<tr>-->
          <!--  <th>Track ID:</th>-->
          <!--  <td>{{ $trackID }}</td>-->
          <!--</tr>-->
          
          <!--<tr>-->
          <!--  <th>Reference ID:</th>-->
          <!--  <td>{{ $referenceID }}</td>-->
          <!--</tr>-->

          <tr>
            <th>Amount:</th>
            <td>{{ $amount }}</td>
          </tr>

          <tr>
            <th>Name:</th>
            <td>{{ $name }}</td>
          </tr>

          <tr>
            <th>Email:</th>
            <td>{{ $email }}</td>
          </tr>

          <tr>
            <th>Phone no:</th>
            <td>{{ $mobile }}</td>
          </tr>

          <tr>
            <th>Date:</th>
            <td>{{ $postDate }}</td>
          </tr>

          </tbody>
        </table>
        
        <div class="d-flex justify-content-center">
            <a href="https://mushkilasan.com/" class="mt-2 btn btn-lg btn-outline-success">Continue Shopping</a>
        </div>
        
      </div>
    </div>
  </div>

@endsection
