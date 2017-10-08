<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Request;

use App\dbJob;
use App\Jobs;
use App\User;
class jobController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function index()
    {
        $user = dbJob::all();
        return view("read", compact("user"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
       return view("create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $data = dbJob::create(Request::all());
       return view('employer.jobposting');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = dbJob::find($id);
        return view("show", compact("user"));
    }
    
    public function recommendedApplicants() {
    $job_id = 1;
 
    $job = Jobs::where('job_id', $job_id)->first();
 
 
    $recommended_applicants = User::join('profiles', 'users.id', '=', 'profiles.user_id')
    ->join('prof_skills', 'profiles.profile_id', '=', 'prof_skills.profile_id')
    ->join('skills.id', 'category')
    ->where('prof_skills.skill_id', $job->skill_id)
    ->get();
 
    return $recommended_applicants;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = dbJob::find($id);
        return view("update", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = dbJob::find($id);
        $user->update(Request::all());
        return redirect("index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= dbJob::find($id);
       $user->delete();
       return redirect("index");
    }
}
