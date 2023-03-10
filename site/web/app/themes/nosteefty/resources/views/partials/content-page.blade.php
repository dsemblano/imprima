
{{-- @php $page = (! is_page(['checkout', 'cart'])) ? "article" @endphp --}}

@if (! is_page(['checkout', 'cart']))
<article class="prose md:prose-lg lg:prose-xl mx-auto max-w-none">
    @php(the_content())
</article>
@else
    @php(the_content())
@endif

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
