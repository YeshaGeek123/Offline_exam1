<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Category;
use App\Models\Criteria;
use App\Models\ExamType;
use App\Models\Procedure;
use Illuminate\Http\Request;
use App\Models\Questionnaire;
use App\Services\QuestionnaireService;
use App\Http\Requests\QuestionnaireRequest;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaires = Questionnaire::with(['exam_type', 'section', 'procedure', 'category'])->get();

        return view('questionnaires.index', compact('questionnaires'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resources = $this->getAllResources();

        return view('questionnaires.create', compact('resources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionnaireRequest $request, QuestionnaireService $questionnaireService)
    {
        $q = Questionnaire::create($request->except('criterias'));

        $questionnaireService->storeCriterias($request->criterias, $q->id);

        return redirect(route('questionnaires.index'))->with('success', 'Data saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function show($questionnaire)
    {
        $questionnaire = Questionnaire::where('id', $questionnaire)->with(['exam_type', 'section', 'procedure', 'category', 'criterias'])->firstOrFail();
        
        return view('questionnaires.show', compact('questionnaire')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function edit($questionnaire)
    {
        $questionnaire = Questionnaire::where('id', $questionnaire)->with(['exam_type', 'section', 'procedure', 'category', 'criterias'])->firstOrFail();
        $resources = $this->getAllResourcesForEdit($questionnaire->section_id, $questionnaire->procedure_id);

        return view('questionnaires.edit', compact('resources', 'questionnaire')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Questionnaire $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionnaireRequest $request, Questionnaire $questionnaire, QuestionnaireService $questionnaireService)
    {
        if ( empty($request->criterias) && empty($request->old_criterias) ) return back()->with('error', 'No criterias found.');

        $questionnaire->update($request->except('criterias'));

        $questionnaireService->updateOldCriterias($request->old_criterias);

        $questionnaireService->storeCriterias($request->criterias, $questionnaire->id);

        return redirect(route('questionnaires.index'))->with('success', 'Data updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getAllResources()
    {
        $resources['examTypes'] = ExamType::get();
        $resources['allSections'] = Section::get();

        return $resources;
    }
    
    private function getAllResourcesForEdit($sectionId, $procedureId)
    {
        $resources['examTypes'] = ExamType::get();
        $resources['allSections'] = Section::get();
        $resources['procedures'] = Procedure::where('section_id', $sectionId)->get();
        $resources['categories'] = Category::where('procedure_id', $procedureId)->get();

        return $resources;
    }

    public function getAllRelatedProcedures($id) 
    {
        return response()->json([
            'procedures' => Procedure::where('section_id', $id)->get()
        ]);
    }
    
    public function getAllRelatedCategories($id) 
    {
        return response()->json([
            'categories' => Category::where('procedure_id', $id)->get()
        ]);
    }
}
