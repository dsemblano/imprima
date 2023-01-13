@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())
    <x-alert type="warning">
      <h2 class="text-2xl text-center p-8">
        {!! __('Erro 404 - A página não existe!', 'sage') !!}
      </h2>
    </x-alert>

    {{-- {!! get_search_form(false) !!} --}}
  @endif
@endsection
