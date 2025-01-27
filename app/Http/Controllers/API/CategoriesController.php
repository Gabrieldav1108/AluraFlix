<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    public function __construct(
        private $categoriesRepository = new CategoriesRepository()
    )
    {
    }

    public function list(){
        return $this->categoriesRepository->list();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'color' => 'required'
        ]);
        $validator->validate();

        return response()
            ->json($this->categoriesRepository->store($validator->validated()));
    }

    public function update(Request $request, string $id){
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'color' => 'required'
        ]);
        $validator->validate();

        $category = Category::find($id);

        if($category){
            return response()
                ->json($this->categoriesRepository->update($category, $validator->validated()));
        }else{
            return response()
                    ->json('The selected category does not exist', 404);
        }
    }

    public function delete(string $id){
        $category = Category::find($id);

        if($category){
            $this->categoriesRepository->delete($category);
            return response()
                ->json('The selected category was deleted successfully');
        }else{
            return response()
                    ->json('The selected category does not exist', 404);
        }
    }

    public function showOne(string $id){
        $category = Category::find($id);
        
        if($category){
            return response()
                ->json($category);
        }else{
            return response()
                ->json('The selected category does not exist');
        }
    }
}
