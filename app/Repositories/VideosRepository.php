<?php 

namespace App\Repositories;

use App\Models\Video;
use App\Traits\HttpResponses;
class VideosRepository{
    use HttpResponses;
    public function list(){
        return Video::all();
    }

    public function store(array $data){
        //dd($data);
        $video = new Video();
        $video->title = $data['title'];
        $video->description = $data['description'];
        $video->url = $data['url'];
        $video->category_id = $data['category_id'];

        $video->save();
        return $video;
    }

    public function update(Video $video, array $data){
        //dd($data, $request);
        //dd($video->category);
        if (array_key_exists('title', $data)) {
            $video->title = $data['title'];
        }
        if (array_key_exists('description', $data)) {
            $video->description = $data['description'];
        }
        if (array_key_exists('url', $data)) {
            $video->url = $data['url'];
        }
        
        $video->save();

        return $video;
    }

    public function destroy(Video $video){
        $video->delete();
    }
}