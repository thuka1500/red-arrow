<?php

namespace App\Http\Controllers\API;

use Auth;
use Validator;
use App\Donor;
use App\Services\ImageStorageService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
    * Validation rules for hospital model
    *
    * @var Array
    */
    public $rules = [
        'name' => 'required',
        'dob' => 'required',
        'address' => 'required',
        'map_lat' => 'required',
        'map_lng' => 'required',
        'contact_no' => 'required',
        'blood_type' => 'required',
    ];

    private $blockFor = 90;

    public $messages = [
        'dob.before' => 'Your age must be atleast 18 years',
    ];

    public function __construct(ImageStorageService $imageStorageService)
    {
        $this->middleware('auth:api', ['except' => [
            'index', 'show'
        ]]);

        $this->imageStorageService = $imageStorageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donors = Donor::all();

        $searchableDonors = [];
        foreach ($donors as $donor) {
            $lastReview = $donor->appointments()->orderBy('updated_at', 'desc')->where('status', 'COMPLETED')->first();
            if ($lastReview === null || strtotime($lastReview->updated_at) + 60 * 60 * 24 * $this->blockFor < time()) {
                $searchableDonors[] = $donor;
            }
        }

        return response()->json([
            'count'  => count($searchableDonors),
            'donors' => $searchableDonors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hospital || Auth::user()->donor) {
            return response()->json([
                'success' => false
            ]);
        }

        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false
            ]);
        }

        $donor = new Donor;

        if ($request->hasFile('avatar')) {
            $donor->avatar = $this->imageStorageService->storeAvatar($request->file('avatar'));
        }

        $donor->name = $request->name;
        $donor->dob = $request->dob;
        $donor->address = $request->address;
        $donor->map_lat = $request->map_lat;
        $donor->map_lng = $request->map_lng;
        $donor->contact_no = $request->contact_no;
        $donor->blood_type = $request->blood_type;
        $donor->health_issues = $request->health_issues;
        $donor->user_id = $request->user()->id;
        $donor->save();

        return response()->json([
            'success' => true,
            'donor' => $donor
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $donor = Donor::findOrFail($id);

        return response()->json($donor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validator = Validator::make($request->all(), $this->rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false
            ]);
        }

        $donor = Donor::find($id);

        if (Auth::user()->id !== $donor->user->id)
            abort(403);

        if ($request->hasFile('avatar')) {
            $donor->avatar = $this->imageStorageService->storeAvatar($request->file('avatar'));
        }

        $donor->name = $request->name;
        $donor->dob = $request->dob;
        $donor->address = $request->address;
        $donor->map_lat = $request->map_lat;
        $donor->map_lng = $request->map_lng;
        $donor->contact_no = $request->contact_no;
        $donor->blood_type = $request->blood_type;
        $donor->health_issues = $request->health_issues;
        $donor->save();

        return response()->json([
            'success' => true,
            'donor' => $donor
        ]);
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
}
