<template>
    <div role="tablist" aria-multiselectable="false" class="">
        <div class="thumbnail">
            <ul id="box-busca-opcoes" class="list-unstyled panel panel-group">
                <!-- TIPO DE MIDIA -->
                <li class="panel transparent">
                    <div id="busca-grupo-02-cabecalho" role="tab" class="panel-heading padding-all-05">
                        <h6 class="margin-none">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#busca-grupo-02" aria-expanded="false" aria-controls="busca-grupo-02"
                                class="collapse-busca collapsed">
                                <i class="cor-fonte-menu-midias-educacionais fa fa-dot-circle-o"></i> Tipos de Mídias
                                <i class="link-preto fa fa-angle-down pull-right"></i>
                            </a>
                        </h6>
                    </div>
                    <div id="busca-grupo-02" role="tabpanel" aria-labelledby="busca-grupo-02-cabecalho" class="panel-collapse collapse" aria-expanded="false"
                        style="height: 0px;">
                        <div class="panel-body padding-all-05">
                            <ul class="list-unstyled margin-none padding-left-10" v-bind:style="addScroll(tipos)">
                                <li v-for="(tipo, t) in tipos"
                                    v-bind:key="t"
                                    class="opcao-item-busca padding-top-02 padding-bottom-02">
                                    <img name="tipo-conteudo" v-bind:src="tipo.icone" width="32" height="32" v-bind:tipo-conteudo="tipo.id" class="cor-fundo-menu-midias-educacionais margin-right-05">
                                    <label v-bind:id="'tipoconteudo' + tipo.id" class="inline opcao-item cursor-pointer" style="font-family: 'UbuntuRegular' !important;">
                                        <input name="tipo-conteudo" 
                                               type="checkbox" 
                                               v-bind:id="'tipoconteudo' + tipo.id" 
                                               v-bind:value="tipo.id"
                                               class="form-check-input"
                                               v-on:click="addToArray('tipos', $event, null )"
                                               >
                                        {{ tipo.nome }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <!-- CANAIS -->
                <!-- li class="panel transparent hidden">
                    <div id="busca-grupo-03-cabecalho " role="tab" class="panel-heading padding-all-05">
                        <h6 class="margin-none">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#busca-grupo-03" aria-expanded="false" aria-controls="busca-grupo-03"
                                class="collapse-busca ">
                                <i class="cor-fonte-menu-midias-educacionais fa fa-dot-circle-o"></i>
                                Canais
                                <i class="cor-fonte-menu-midias-educacionais fa fa-angle-down pull-right"></i>
                            </a>
                        </h6>
                    </div>
                    <div id="busca-grupo-03" role="tabpanel" aria-labelledby="busca-grupo-03-cabecalho" class="panel-collapse collapse ">
                        <div class="panel-body padding-all-05">
                            <ul class="list-unstyled margin-none padding-left-10"></ul>
                        </div>
                    </div>
                </li -->
                <!-- CATEGORIA COMPONENTES -->
                <li class="panel panel-default" v-for="(categoria, c) in categorias" v-bind:key="c">
                    <div v-bind:id="'busca-grupo-' + i +'-cabecalho'" role="tab" class="panel-heading padding-all-05">
                        <h6 class="margin-none">
                            <a role="button" data-toggle="collapse" 
                               data-parent="#accordion" 
                               v-bind:href="'#busca-grupo-' + i" 
                               aria-expanded="false" 
                               v-bind:aria-controls="'busca-grupo-'+ i"
                               class="collapse-busca collapsed">
                                <i class="cor-fonte-menu-midias-educacionais fa fa-graduation-cap"></i> 
                                    {{ categoria.nome }}
                                <i class="link-preto fa fa-angle-down pull-right"></i>
                            </a>
                        </h6>
                    </div>
                    <div v-bind:id="'busca-grupo-' + i" role="tabpanel" v-bind:aria-labelledby="'busca-grupo-' + i +'-cabecalho'" class="panel-collapse collapse" aria-expanded="false"
                        style="height: 0px;">
                        <div class="panel-body padding-all-05">
                            <ul class="list-unstyled margin-none padding-left-10" v-bind:style="addScroll(categoria.componentes)">
                                <li class="opcao-item-busca padding-top-02"
                                    v-for="(componente, cc) in categoria.componentes"
                                    v-bind:key="cc"
                                    v-bind:id="componente.id">
                                    <label v-bind:for="'componente' + componente.id" class="inline opcao-item cursor-pointer" style="font-family: 'UbuntuRegular' !important;">
                                        <input name="opcao-item" 
                                               type="checkbox" 
                                               v-bind:id="'componente' + componente.id" 
                                               v-bind:value="componente.id" 
                                               v-on:click="addToArray('componentes', $event, categoria.id )">
                                               {{componente.nome}}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <!-- LICENCAS -->
                <li class="panel transparent">
                    <div id="busca-grupo-04-cabecalho" role="tab" class="panel-heading padding-all-05">
                        <h6 class="margin-none">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#busca-grupo-04" aria-expanded="false" aria-controls="busca-grupo-04"
                                class="collapse-busca collapsed">
                                <i class="cor-fonte-menu-midias-educacionais fa fa-gavel"></i> Licenças de Uso
                                <i class="link-preto fa fa-angle-down pull-right"></i>
                            </a>
                        </h6>
                    </div>
                    <div id="busca-grupo-04" role="tabpanel" aria-labelledby="busca-grupo-04-cabecalho" class="panel-collapse collapse ">
                        <div class="panel-body padding-all-05">
                            <ul class="list-unstyled margin-none padding-left-10">
                                <li class="padding-none" 
                                    v-for="(licenca,l) in licencas"
                                    v-bind:key="l">
                                    <label v-bind:for="'licenca' + licenca.id" class="inline opcao-item cursor-pointer" style="font-family: 'UbuntuRegular' !important;">
                                        <input type="checkbox" 
                                               v-bind:id="'licenca' + licenca.id" 
                                               v-bind:value="licenca.id"
                                               v-on:click="addToArray('licencas', $event, null )">
                                               {{licenca.nome}}
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
                <!-- OUTRAS MODALIDADES E NIVEIS DE ENSINO-->
                <li class="panel transparent">
                    <div id="busca-grupo-05-cabecalho" role="tab" class="panel-heading padding-all-05">
                        <h6 class="margin-none">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#busca-grupo-05" aria-expanded="false" aria-controls="busca-grupo-05"
                                class="collapse-busca collapsed">
                                <i class="cor-fonte-menu-midias-educacionais fa fa-search"></i> Outras modalidades/níveis de ensino
                                <i class="link-preto fa fa-angle-down pull-right"></i>
                            </a>
                        </h6>
                    </div>
                    <div id="busca-grupo-05" role="tabpanel" aria-labelledby="busca-grupo-05-cabecalho" class="panel-collapse collapse ">
                        <div class="panel-body padding-all-05">
                            <ul class="list-unstyled margin-none padding-none">
                                <li v-for="(nivel,n) in niveis" 
                                v-bind:key="n">
                                    <div id="busca-grupo-05-6-cabecalho" role="tab" class="panel-heading padding-all-05">
                                        <h6 class="margin-none">
                                            <a role="button" data-toggle="collapse" 
                                               data-parent="#accordion" 
                                               v-bind:href="'#busca-grupo-niveis-' + i" 
                                               aria-expanded="false" 
                                               v-bind:aria-controls="'busca-grupo-niveis-' + i"
                                               class="collapse-busca collapsed">
                                                <b>
                                                    <i class="cor-fonte-menu-midias-educacionais fa fa-caret-right"></i> {{nivel.nome}}
                                                </b>
                                                <i class="link-preto fa fa-angle-down pull-right"></i>
                                            </a>
                                        </h6>
                                    </div>
                                    <div v-bind:id="'busca-grupo-niveis-'+ i" role="tabpanel" aria-labelledby="busca-grupo-05-6-cabecalho" class="padding-left-10 panel-collapse collapse ">
                                        <div class="panel-body padding-all-05">
                                            <ul class="list-unstyled margin-none" v-bind:style="addScroll(nivel.componentes)">
                                                <li class="opcao-item-busca padding-top-02"
                                                    v-for="(componente, d) in nivel.componentes"
                                                    v-bind:key="d">
                                                    <label v-bind:for="'componente-nivel-' + componente.id" class="inline opcao-item cursor-pointer" style="font-family: 'UbuntuRegular' !important;">
                                                        <input type="checkbox" 
                                                               v-bind:id="'componente-nivel-' + componente.id" 
                                                               v-bind:value="componente.id"
                                                               v-on:click="addToArray('niveis', $event, nivel.id )">
                                                               {{componente.nome}}
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    name: 'CurricularComponents',
    
}
</script>