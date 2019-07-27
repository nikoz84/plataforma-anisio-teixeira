<?php

namespace App\Helpers;

use App\Canal;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class ColaborativusService
{
    private $api;
    protected $token = '';
    private const URL_SERVICE = 'webservice/rest/server.php';
    private const TAG_ID = 1162;

    public function __construct()
    {
        $this->canal = Canal::find(8);

        $this->api = $this->canal->options['back_url'] . self::URL_SERVICE;
    }

    public function findCourses()
    {

        $response = Curl::to($this->api)
            ->withData([
                'moodlewsrestformat' => 'json',
                'wstoken' => $this->canal->token,
                'wsfunction' => 'core_course_search_courses',
                'criterianame' => 'tagid',
                'criteriavalue' => self::TAG_ID
            ])
            ->asJsonResponse()
            ->get();

        $courses = [];
        foreach ($response->courses as $course) {
            array_push($courses, [
                'id' => $course->id,
                'name' => $course->fullname,
                'description' => $course->summary,
                'imagem' => $this->findCoursePerId($course->id)
            ]);
        }


        dd($courses);

        return $courses;
    }

    public function getImageBase64($file, $url)
    {
        $data = '';
        $base64 = '';
        $type = pathinfo($file, PATHINFO_EXTENSION);
        if (pathinfo($file, PATHINFO_BASENAME) == 'destaque-home-plataforma.jpg') {
            $data = file_get_contents($url . "?token=" . $this->canal->token);
        }

        if ($data) {
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }


        return $base64;
    }

    /**
     * Seleciona um curso pelo ID
     * @param int $idcurso int retorna timecriated
     * @return array retorna um array de objetos 
     */
    public function findCoursePerId($course_id)
    {
        $response = Curl::to($this->api)
            ->withData([
                'moodlewsrestformat' => 'json',
                'wstoken' => $this->canal->token,
                'wsfunction' => 'core_course_get_courses',
                'options[ids][0]=' => $course_id
            ]);
        dd($response);
        //->asJsonResponse()
        //->get();

        dd($response);
    }
    /**
     *  pega todas as categorias do Ambiente Colaborativo de Aprendizagem 
     * @param type $is_object boolean retorna array ou um array objetc $array['valor'] ou $array->valor
     * @return type retorna um array ou um array de objetos
     */
    public function getCategories($is_object = false)
    {
        $categories = "&wsfunction=core_course_get_categories";
        $request = file_get_contents($this->api . $categories);
        $categories_api = json_decode($request, $is_object);
        return $categories_api;
    }
    /**
     * pega todos os cursos de uma categoria
     * @param type $id identificador unico da categoria
     * @return type retorna um array de objetos
     */
    public function getCoursesByCategory($id)
    {
        $courses = $this->getCourses();
        $coursesById = [];
        foreach ($courses as $course) {
            if ($course->categoryid == $id) {
                $coursesById[] = $course;
            }
        }
        return $coursesById;
    }
    /**
     * pega os últimos 10 cursos adicionados e são ordenados pela data de criação
     * @return type retorna um array de objetos
     */
    public function getLatestCourses()
    {
        $courses = $this->getCourses(true);
        $maisRecentes = [];
        array_multisort(array_map(function ($items) {
            return $items['timecreated'];
        }, $courses), SORT_DESC, $courses);
        // primeiros 10
        for ($i = 0; $i < 10; $i++) {
            $maisRecentes[] = $courses[$i];
        }
        return $this->toObject($maisRecentes);
    }
    /**
     * converte de array a objeto
     * @param type $toObject é um array
     * @return type objeto PHP
     */
    private function toObject($toObject)
    {
        return json_decode(json_encode($toObject), false);
    }
}
