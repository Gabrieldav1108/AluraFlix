<?php 

namespace App\Repositories;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Video;


class CategoriesRepository extends Controller
{

    public function list(){
        return Category::all();
    }
    
    public function store(array $data){
        $category = new Category();
        
        $category->title = $data['title'];
        $category->color = $data['color'];

        $category->save();

        return $category;
    }

    public function update(Category $category, array $data){
        if (array_key_exists('title', $data)) {
            $category->title = $data['title'];
        }
        if (array_key_exists('color', $data)) {
            $category->color = $data['color'];
        }
        $category->save();
        return $category;
    }
    public function delete(Category $category){
        $category->delete();
    }

    public function videosByCategory(string $id){
        return Video::where('category_id', '=', $id)->get();
    }

}