@extends('layouts.app')

@section('content')
  <product-detail-component :product_detail='@json($prodDetailM)'></product-detail-component>
@endsection