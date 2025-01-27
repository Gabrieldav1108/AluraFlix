<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video;
use App\Repositories\VideosRepository;
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'required',
            'url' => 'required',
            'category_id' => 'required'
        ]);
        $validator->validate();

        return response()
                ->json($this->videoRepository->store($validator->validated()), 201);
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

}
