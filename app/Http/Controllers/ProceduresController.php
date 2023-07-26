<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Services\NameService;
use App\Http\Requests\ProcedureRequest;

class ProceduresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procedures = Procedure::section();

        return view('procedures.index', compact('procedures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sections = Section::get();

        return view('procedures.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcedureRequest $request)
    {
        // $password = $this->generatePassword($request->first_name, $request->last_name, $request->phone);
        // $request->merge(['password' => bcrypt($password), 'name' => $request->first_name.' '.$request->last_name]);

        $request->merge(['section_id' => implode(',',$request->sections)]);
        $request = $request->except(['sections']);
        Procedure::create($request);

        return redirect(route('procedures.index'))->with('success', 'Data saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function show(Procedure $procedure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sections = Section::get();
        $procedure = Procedure::where('id', $id)->get()->toArray();

        return view('procedures.edit', compact('procedure', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function update(ProcedureRequest $request, Procedure $procedure)
    {
        // $password = $this->generatePassword($request->name, $request->last_name, $request->phone);
        // $request->merge(['password' => bcrypt($password), 'name' => $request->name]);
        $request->merge(['section_id' => implode(',',$request->sections)]);
        $request = $request->except(['sections']);
        $procedure->update($request);

        return redirect(route('procedures.index'))->with('success', 'Data updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Procedure  $procedure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Procedure $procedure)
    {
        $procedure->delete();

        return redirect(route('procedures.index'))->with('success', 'Data deleted.');
    }

    private function generatePassword($firstname, $lastname, $phone) 
    {
        $initials['first'] = substr($firstname, 0, 1);
        $initials['second'] = substr($lastname, 0, 1);
        $lastFourDigits = substr($phone, -4);

        return $initials['first'].$initials['second'].$lastFourDigits;
    }
}
