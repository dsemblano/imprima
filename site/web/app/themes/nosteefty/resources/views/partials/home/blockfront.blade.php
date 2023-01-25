<section class="bg-home blockhome blockhome-1 bg-transparent h-screen flex flex-col justify-end">
    {{-- background wallpaper --}}
    <div class="w-full glass py-4">
        <div class="container lg:px-24 mx-auto gap-4 grid grid-cols-2 md:grid-cols-4">
            <div class="flex items-center py-2 md:py-0 leading-tight w-full">
            <img src="@asset('images/semlimites.png')" alt="ícone sem limite cores" width="118" height="45" />
            {{-- <span class="ml-4 text-xs md:text-lg text-pureblack"><p>SEM</p><p>limite de cores</p></span> --}}
            </div>
            <div class="flex items-center py-2 md:py-0 leading-tight w-full">
            <img src="@asset('images/sempedido.png')" alt="ícone sem pedido" width="137" height="38" />
            {{-- <span class="ml-4 text-xs md:text-lg text-pureblack"><p>SEM</p><p>pedido mínimo</p></span> --}}
            </div>
            <div class="flex items-center py-2 md:py-0 leading-tight w-full">
            <img src="@asset('images/100algodao.png')" alt=" ícone 100% algodão" width="107" height="39" />
            {{-- <span class="ml-4 text-xs md:text-lg text-pureblack"><p>100% algodão</span> --}}
            </div>
            <div class="flex items-center py-2 md:py-0 leading-tight w-full">
            <img src="@asset('images/produtos_entrega.png')" alt="ícone produtos pronta entrega.png" width="189" height="31" />
            {{-- <span class="ml-4 text-xs md:text-lg text-pureblack"><p>Produtos à</p><p>pronta entrega</p></span> --}}
            </div>
        </div>
    </div>
</section>

<section id="products-customize" class="bg-white py-14">
    <div class="container lg:px-24 ">
        <div class="page-header pb-14">
            <h2 class="md:text-5xl">Crie e Customize</h2>
            <p class="md:text-2xl mb-6 text-center">todos os produtos</p>
        </div>
        <x-last-lumise />
    </div>
</section>

@include('partials/snippets.ribbon-algodao')

<section id="products-nosteefty" class="bg-gray-100 py-14">
    <div class="container lg:px-24">
        <div class="page-header pb-14">
            <h2 class="md:text-5xl">Camiseta É Coisa Séria</h2>
            <a href="/colecao-coisa-seria">
                {{-- <button class="btn-estudio">Veja todos os produtos</button> --}}
                <x-blobbutton>Veja todos os produtos</x-blobbutton>
            </a>
          </div>
        <x-last-camisetaprods />
    </div>
</section>


<section id="servicos" class="bg-white py-14">
    <div class="container lg:px-24 ">
        <div class="page-header pb-14">
             <h2 class="md:text-5xl">Serviços</h2>
        </div>
        <ul class="flex flex-wrap justify-between">
            <li class=" ">
            <a href="/servicos/impressao-digital-avulsa-em-algodao">
                <div class="img-container" role="button">
                <img src="@asset('images/impressaodigital.png')" alt="blusa 1" class="blockhome4-img hover:shadow-lg" width="390" height="505" />
                {{-- <div class="text-over">
                    <p class="text">Saiba mais</p>
                </div> --}}
                </div>
            </a>
            </li>
        
            <li class=" ">
            <a href="/servicos/outsourcing">
                <div class="img-container" role="button">
                <img src="@asset('images/outsourcing.png')" alt="blusa 1" class="blockhome4-img hover:shadow-lg" width="390" height="505" />
                {{-- <div class="text-over">
                    <p>Saiba mais</p>
                </div> --}}
                </div>
            </a>
            </li>
        
            <li class=" ">
            <a href="/servicos/dropshipping">
                <div class="img-container" role="button">
                <img src="@asset('images/dropshipping.png')" alt="blusa 1" class="blockhome4-img hover:shadow-lg" width="390" height="505" />
                {{-- <div class="text-over">
                    <p>Saiba mais</p>
                </div> --}}
                </div>
            </a>
            </li>
        
        </ul>
        {{-- @include('partials/snippets.ribbon-algodao') --}}
    </div>
    </section>
