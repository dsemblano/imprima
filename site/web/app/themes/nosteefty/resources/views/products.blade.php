{{--
  Template Name: Products Template
--}}

@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="content products container">
    <x-lumise-prods />
  </div>

</section>

@endsection
