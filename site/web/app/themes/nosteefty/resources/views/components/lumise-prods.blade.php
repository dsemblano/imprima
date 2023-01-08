@php
  $cat_prod = 'faca-sua-camiseta';
  $product_cat_ID = get_term_by('slug', $cat_prod, 'product_cat')->term_id;
  $args = array(
      'show_option_none' => '',
      'hide_empty' => 0,
      'parent' => $product_cat_ID,
      'taxonomy' => 'product_cat'
  );

  $sub_categories = get_categories($args);
@endphp

<ul class="mx-auto gap-8 grid grid-cols-2 md:grid-cols-4">

@foreach ($sub_categories as $sub)
{{-- <h2 class="page-header-allcategories text-center">
  <a class="header-link" href={{ esc_url(get_category_link($sub->cat_ID)) }}>{{ $sub->name }}</a>
</h2> --}}
@php
  $destaques_produtos = wc_get_products(array(
      'limit' => -1,
      'status'=> 'publish',
      'category' => $sub->slug
  ));
@endphp

  @foreach ($destaques_produtos as $product)
    <li class="text-center">
      <a class="lumiseprods block" href="{!! $product->get_permalink() !!}">
        @php
            $imgprod = $product->get_image($size = 'produtos', array('class'=>'imgprod w-full bg-white'));
        @endphp
        {{-- {!! $product->get_image() !!} --}}
        {!! $imgprod !!}
        <h2 class="text-sm my-3 h-8 md:h-6 overflow-auto">
          {!! $product->get_title() !!}
        </h2>

        @if ($product->get_price())
          @php
            $product_base = get_post_meta($product->get_id(), 'lumise_product_base', true);
          @endphp
          <div>R$ {!! $product->get_price() !!}</div>
            <a href="/design-editor/?product_cms={!! $product->get_id() !!}&product_base={{ $product_base }}">
              <x-blobbutton>Crie a sua aqui</x-blobbutton>
            </a>
        @endif
        </a>

        @php do_action( 'woocommerce_after_shop_loop_item' ); @endphp
    </li>
  @endforeach
@endforeach

</ul>