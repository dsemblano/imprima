@if (! is_page('cart'))
    <article class="prose md:prose-lg lg:prose-xl mx-auto">        
@else
    <article class="mx-auto">    
@endif

    @php(the_content())
</article>

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
