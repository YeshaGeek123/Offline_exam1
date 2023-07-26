<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Services\NameService;
use App\Http\Requests\SectionRequest;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::select('*')->get();

        return view('sections.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('id', '!=', 1)->get();

        return view('sections.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        // $password = $this->generatePassword($request->first_name, $request->last_name, $request->phone);
        // $request->merge(['password' => bcrypt($password), 'name' => $request->first_name.' '.$request->last_name]);

        Section::create($request->all());

        return redirect(route('sections.index'))->with('success', 'Data saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section, NameService $nameService)
    {
        $roles = Role::where('id', '!=', 1)->get();
        
        $name = $nameService->breakdownName($section->title);

        return view('sections.edit', compact('section', 'name', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        // $password = $this->generatePassword($request->name, $request->last_name, $request->phone);
        // $request->merge(['password' => bcrypt($password), 'name' => $request->name]);
        $section->update($request->all());

        return redirect(route('sections.index'))->with('success', 'Data updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return redirect(route('sections.index'))->with('success', 'Data deleted.');
    }

    private function generatePassword($firstname, $lastname, $phone) 
    {
        $initials['first'] = substr($firstname, 0, 1);
        $initials['second'] = substr($lastname, 0, 1);
        $lastFourDigits = substr($phone, -4);

        return $initials['first'].$initials['second'].$lastFourDigits;
    }
}
