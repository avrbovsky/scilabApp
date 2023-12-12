<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExperimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $experiments =  Experiment::all();

            return response()->json(["experiments"=> $experiments], 200);
        }catch(\Exception $exception){
            return response()->json(["message"=>"Error - {$exception->getMessage()}"]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file',
            'context' => 'required|json',
            'output' => 'required|json',
            'save' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $filePath = $file->storeAs('experiment_files', $originalFileName);

        // $experiment = Experiment::create([
        //     'file_name' => $filePath,
        //     'context' => $request->input('context'),
        //     'output' => $request->input('output'),
        //     'save' => $request->input('save', false),
        //     // 'created_by' => auth()->id(),
        //     'created_by' => 1,
        // ]);


        $scriptCommand = 'loadXcosLibs();loadScicos();importXcosDiagram(\'' . $filePath . '\');Context=struct();scicos_simulate(scs_m,list(),Context,\'nw\');';
        $script = 'SCRIPT="' . $scriptCommand .'" /usr/bin/ssh -q -o "UserKnownHostsFile=/dev/null" -o "StrictHostKeyChecking=no" -o "SendEnv=SCRIPT" root@localhost -- /opt/bp-app/run-script.sh 2>&1';
        // $script = 'SCRIPT="' . $scriptCommand . '" ';

        $result = shell_exec($script);

        return response()->json(["simulation"=>$result], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(!$id){
            return response()->json(["message"=>"Invalid id!"], 400);
        }

        try{
            $experiment = Experiment::findOrFail($id);

            return response()->json(["experiment"=>$experiment], 200);
        } catch(\Exception $_){
            return response()->json(["message"=>"There is no experiment with that id!"], 400);
        }
    }

    /**
     * Get the specified schema.
     */
    public function getSchemaFile($id)
    {
        if(!$id){
            return response()->json(["message"=>"Invalid id!"], 400);
        }

        try{
            $experiment = Experiment::findOrFail($id);
            $filePath = $experiment->file_name;
            // $filePath = $experiment->get('file_name');

            return Storage::response($filePath);
        } catch(\Exception $_){
            return response()->json(["message"=>"There is no experiment with that id!"], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!$id){
            return response()->json(["message"=>"Invalid id!"], 400);
        }
        try{
            $experiment = Experiment::findOrFail($id);
            $filePath = $experiment->file_name;

            try{
                Storage::delete($filePath);

                $experiment->delete();
            } catch(\Exception $exception){
                return response()->json(["message"=>"Error - {$exception->getMessage()}"], 500);
            }

            return response()->json(['message' => 'Experiment deleted successfully'], 200);
        } catch(\Exception $_){
            return response()->json(["message"=>"There is no experiment with that id!"], 400);
        }
    }
}
