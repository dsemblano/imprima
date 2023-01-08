
<article class="prose md:prose-lg lg:prose-xl mx-auto">
    @php(the_content())
</article>

{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
