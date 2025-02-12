<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Models\Category;
use App\Models\Video;
use App\Repositories\VideosRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VideosController extends Controller
{

    public function __construct(       
        private $videoRepository = new VideosRepository()
    ){}

    public function teste(){
        echo'teste';
    }
    public function list(){
        return $this->videoRepository->list();
    }

    public function store(Request $request){
        $data = $this->validateVideo($request);
        $data['category_id'] = $data['category_id'] ?? '1';
        
        try{
            $video = $this->videoRepository->store($data);

            return $this->serverSuccessResponse(
                'Video criado com sucesso!',
                new VideoResource($video)
            );
        }catch(Exception){
            return $this->serverErrorResponse("Não foi possivel criar o video :(");
        }
        // return response()
        //         ->json($this->videoRepository->store($data), 201);
        //$videos = $this->videoRepository->store($validator->validated());
    }

    public function update(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required'
        ]); 
        $validator->validate();

        $video = Video::find($id);

        if($video){
            return response()
            ->json($this->videoRepository->update($video, $validator->validated()), 200);
        }else{
            return response()
                    ->json('The selected video does not exist', 404);
        }
    }

    public function destroy(string $id){
        $video = Video::find($id);

        if($video){
            $this->videoRepository->destroy($video);
            return response()
                    ->json('The video was deleted successfully', 200);
        }else{
            return response()
                    ->json('The selected video does not exist', 404);
        }
    }

    public function search(Request $request){
        echo 'ok';
    }

    public function validateVideo(Request $request): array{
        $fields = $request->all();

        $rules = [
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required',
            'category_id' => 'nullable'
        ];

        // foreach ($rules as $field => $rule) {
        //     if (!ValidatorHelper::shouldValidateField($fields, $field)) {
        //         unset($rules[$field]);
        //     }
        // }

        $validator = Validator::make(
            $fields,
            $rules,
            [
                'title.required' => 'O título da categoria é obrigatório',
                'title.max' => 'O máximo de caracteres para o título foi excedido',
                'color.required' => 'A cor da categoria é obrigatória',
                'color.min' => 'O mínimo de caracteres para cor é de :min'
            ]
            );


            //dd($validator->validated());
            $validator->validate();
            return $validator->validated();
    }

}
