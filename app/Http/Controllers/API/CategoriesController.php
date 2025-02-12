<?php

namespace App\Http\Controllers\API;

use App\Helpers\ValidatorHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{

    public function __construct(
        private $categoriesRepository = new CategoriesRepository()
    )
    {
    }

    public function list(){
        //dd(Auth::user());
        return $this->categoriesRepository->list();
    }

    public function store(Request $request){
        $data = $this->validateCategory($request);

        return response()
            ->json($this->categoriesRepository->store($data));
    }

    public function update(Request $request, string $id){
        $data = $this->validateCategory($request);

        $category = Category::find($id);

        if($category){
            return response()
                ->json($this->categoriesRepository->update($category, $data));
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

    public function videosByCategory(string $id){
        return response()
            ->json($this->categoriesRepository->videosByCategory($id));
    }

    public function validateCategory(Request $request): array{
        $fields = $request->all();

        $rules = [
            'title' => 'required|max:255',
            'color' => 'required|min:3'
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

            //dd($validator);
            $validator->validate();
            return $validator->validated();
    }
}
