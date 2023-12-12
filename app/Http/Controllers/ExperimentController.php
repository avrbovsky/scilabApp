<?php

namespace App\Http\Controllers;

use App\Models\Experiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Experiments",
 *     description="API Endpoints for Experiments"
 * )
 */
 /**
 * @OA\SecurityScheme(
 *     type="http",
 *     securityScheme="bearerAuth",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class ExperimentController extends Controller
{
    /**
     * @OA\Get(
     *  path="/api/experiments",
     *  tags={"Experiments"},
     *  summary="Get a list of experiments",
     *  description="Returns all experiments",
     *  security={{"bearerAuth": {}}},
     *  @OA\Response(
     *      response=200,
     *      description="Successful operation",
     *      @OA\JsonContent(
     *          @OA\Property(
     *              property="experiments",
     *              type="array",
     *              @OA\Items(
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="file_name", type="string", example="experiment_files/1622619815_1619954846_tcn.zcos"),
     *                  @OA\Property(property="context", type="string", example="{}"),
     *                  @OA\Property(property="output", type="string", example="{}"),
     *                  @OA\Property(property="save", type="integer", example=0),
     *                  @OA\Property(property="created_by", type="integer", example=1),
     *                  @OA\Property(property="created_at", type="string", format="date-time"),
     *                  @OA\Property(property="updated_at", type="string", format="date-time")
     *                  )
     *              )
     *          )
     *      )
     *  )
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
     * @OA\Post(
     *     path="/api/experiments",
     *     tags={"Experiments"},
     *     summary="Create a new experiment",
     *     description="Stores a new experiment",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"file", "context", "output", "save"},
     *             @OA\Property(property="file", type="string", format="file", description="Experiment file"),
     *             @OA\Property(property="context", type="string", description="Context"),
     *             @OA\Property(property="output", type="string", description="Output"),
     *             @OA\Property(property="save", type="boolean", description="Save")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Experiment created successfully"),
     *     @OA\Response(response="400", description="Invalid input")
     * )
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
     * @OA\Get(
     *     path="/api/experiments/{id}",
     *     tags={"Experiments"},
     *     summary="Get an experiment by ID",
     *     description="Returns an experiment based on ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the experiment",
     *         @OA\Schema(type="string"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="file_name", type="string", example="experiment_files/1622619815_1619954846_tcn.zcos"),
     *             @OA\Property(property="context", type="string", example="{}"),
     *             @OA\Property(property="output", type="string", example="{}"),
     *             @OA\Property(property="save", type="integer", example=0),
     *             @OA\Property(property="created_by", type="integer", example=1),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Experiment not found"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/experiments/{id}",
     *     tags={"Experiments"},
     *     summary="Delete an experiment by ID",
     *     description="Deletes an experiment based on ID",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the experiment",
     *         @OA\Schema(type="string"),
     *         example=1
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Experiment deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Experiment deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Experiment not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error deleting experiment",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
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
