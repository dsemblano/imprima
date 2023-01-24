{{-- Anonymous components --}}

@php
    $parent_category = wc_get_products(array(
        'limit' => 9,
        'status'=> 'publish',
        'orderby' => 'rand',
        'category' => 'camiseta-e-coisa-seria'
    ));
@endphp
<div class="gap-8 grid grid-cols-2 md:grid-cols-3">
    @foreach ($parent_category as $img_cat)
    <a class="linkimgprod"
        href="{!! $img_cat->get_permalink() !!}">
        @php
        $imgprod = $img_cat->get_image($size = 'produtos', array('class'=>'imgprod w-full rounded-md'));
        @endphp
        {!! $imgprod !!}
        <h2 class="text-base sm:text-xl mt-3 h-12 text-center">
            {!! $img_cat->get_title() !!}
        </h2>
    </a>
    @endforeach
</div>