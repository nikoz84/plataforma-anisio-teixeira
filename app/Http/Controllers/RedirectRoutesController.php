<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedirectRoutesController extends Controller
{
    /**
     * Método que redireciona as Tags
     * @param integer id Identificador único $id
     * @return void
     */
    public function redirectTags($id)
    {
        return redirect("/recursos-educacionais/listar?tag={$id}");
    }
    /**
     * Método que redireciona para tv
     * @param integer id Identificador único $id
     * @return void
     */
    public function redirectTV($id)
    {
        return redirect("/tv-anisio-teixeira/conteudo/exibir/{$id}");
    }
    /**
     * Método que redireciona para Emitec
     * @param integer id identificador único $id
     * @return void
     */
    public function redirectEmitec($id)
    {
        return redirect("/emitec/conteudo/exibir/{$id}");
    }
    /**
     * Método que redireciona para aulas Emitec
     * @param mixed disciplina
     * @param integer id identificador único $id
     * @return void
     */
    public function redirectAulasEmitec($disciplina, $id)
    {
        return redirect("/emitec/listar?canal=2&componentes=$disciplina&categoria=$id");
    }
    /**
     * Método que redireciona para Resursos
     * @param integer id identificador único $id
     * @return void
     */
    public function redirectRecursos($id)
    {
        return redirect("/recursos-educacionais/conteudo/exibir/{$id}");
    }
    /**
     * Método que Redireciona para incorporar
     * @param integer id Identificador único $id
     * @return void
     */
    public function redirectIncorporar($id)
    {
        return redirect("/incorporar-conteudo/{$id}");
    }
    /**
     * Método que redireciona o Download
     * @return void
     */
    public function redirectDownload()
    {
        return;
    }
    /**
     * Método que faz o teste
     * @return string json
     */
    public function teste()
    {

        //$is_save = \App\Canal::where('slug', 'educacao-profissional')->get();
        /*
        $canal->name = 'Educação Profissional e Tecnológica';
        $canal->description = 'Descrição do canal Educação Profissional e Tecnológica';
        $canal->slug = 'educacao-profissional';
        $canal->is_active = true;
        $canal->options = json_decode('{
            "color": "#54317a",
            "back_url": "",
            "has_home": true,
            "has_about": true,
            "order_menu": 14,
            "extend_name": "Educação Profissional e Tecnológica",
            "tipo_conteudo": [1,2,3,4,5,6,8,10,17],
            "has_categories": true,
            "has_quick_access": false,
            "complement_description": {
                "que": "O que são e para quem estes conteúdos são destinados",
                "como": "Quais os objetivos, justificativas da oferta dos conteúdos",
                "porque": "Como estes conteúdos podem colaborar para o fortalecimento do processo de ensino e de aprendizagem."
            }
        }');
        
        $is_save = $canal->save();
        */
        $this->createCategories();

        return response()->json([
            //'save' => $is_save,
            'categories' => 'ok'
        ]);
    }
    /**
     * Método que cria uma categoria
     * @return void
     */
    public function createCategories()
    {

        $rn = \App\Models\Category::create([
            'canal_id' => 19,
            'name' => 'Recursos Naturais',
            'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
        ]);

        $data = [
            [
                'parent_id' => $rn->id,
                'canal_id' => 19,
                'name' => 'Técnico em Aquicultura',
                'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
            ],
            [
                'parent_id' => $rn->id,
                'canal_id' => 19,
                'name' => 'Técnico em Cafeicultura',
                'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
            ],
            [
                'parent_id' => $rn->id,
                'canal_id' => 19,
                'name' => 'Técnico em Florestas',
                'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
            ],
            [
                'parent_id' => $rn->id,
                'canal_id' => 19,
                'name' => 'Técnico em Pesca',
                'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
            ],
            [
                'parent_id' => $rn->id,
                'canal_id' => 19,
                'name' => 'Técnico em Recursos Pesqueiros',
                'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
            ],
            [
                'parent_id' => $rn->id,
                'canal_id' => 19,
                'name' => 'Técnico em Zootecnia',
                'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
            ],
            [
                'parent_id' => $rn->id,
                'canal_id' => 19,
                'name' => 'Viveiricultor',
                'options' => json_decode('{
                    "is_active": true,
                    "description": "descrição",
                    "is_featured": false
                }')
            ]

        ];


        foreach ($data as $item) {
            \App\Models\Category::create($item);
        }
    }
    /**
     * Método que cria cursos
     * @return void
     */
    public function createCourses()
    {
    }
}
