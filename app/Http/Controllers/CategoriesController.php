<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Services\NameService;
use App\Http\Requests\CategoryRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $categories = Category::procedure();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $procedures = Procedure::get();

        return view('categories.create', compact('procedures'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        // $password = $this->generatePassword($request->first_name, $request->last_name, $request->phone);
        // $request->merge(['password' => bcrypt($password), 'name' => $request->first_name.' '.$request->last_name]);

        $request->merge(['procedure_id' => implode(',',$request->procedures)]);
        $request = $request->except(['procedures']);
        Category::create($request);

        return redirect(route('categories.index'))->with('success', 'Data saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $procedures = Procedure::get();
        $category = Category::where('id', $id)->get()->toArray();

        return view('categories.edit', compact('category', 'procedures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        // $password = $this->generatePassword($request->name, $request->last_name, $request->phone);
        // $request->merge(['password' => bcrypt($password), 'name' => $request->name]);
        $request->merge(['procedure_id' => implode(',',$request->procedures)]);
        $request = $request->except(['procedures']);
        $category->update($request);

        return redirect(route('categories.index'))->with('success', 'Data updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect(route('categories.index'))->with('success', 'Data deleted.');
    }

    private function generatePassword($firstname, $lastname, $phone) 
    {
        $initials['first'] = substr($firstname, 0, 1);
        $initials['second'] = substr($lastname, 0, 1);
        $lastFourDigits = substr($phone, -4);

        return $initials['first'].$initials['second'].$lastFourDigits;
    }
}
