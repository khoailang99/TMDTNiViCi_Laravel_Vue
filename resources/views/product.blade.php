@extends('layouts.app')

@section('content')
<div class="css-5542cb">
  <h4 style="font-size: 1rem"> Giao diện sản phẩm
    <span style="font-size: 1.3rem; color: #bc1d1d;">
      {{ $prodDetailM -> product -> Name }}
    </span>
    đang trong quá trình xây dựng!</h4>
</div>
@endsection