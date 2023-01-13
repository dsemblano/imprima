{{-- Anonymous components --}}

@php
    $destaques_produtos = wc_get_products(array(
        'limit' => -1,
        'status'=> 'publish',
        'orderby' => 'rand',
        'category' => 'faca-sua-camiseta'
    ));
@endphp

<div class="gap-8 grid grid-cols-2 md:grid-cols-4 container">
@foreach ($destaques_produtos as $productimg)
    <a class="linkimgprod lastlumise lg:p-10 overflow-hidden" href="{!! $productimg->get_permalink() !!}">
        @php
            $imgprod = $productimg->get_image($size = 'produtos', array('class'=>'imgprod w-full'));
        @endphp
        {!! $imgprod !!}
        <h2 class="text-base sm:text-xl mt-3 h-12 text-center">
            {!! $productimg->get_title() !!}
        </h2>
    </a>
@endforeach
</div>