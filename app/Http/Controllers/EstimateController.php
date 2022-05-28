<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use App\Http\Requests\StoreEstimateRequest;
use App\Http\Requests\UpdateEstimateRequest;
use App\Models\Customer;
use App\Models\Feature;
use App\Models\FeatureEstimate;
use Illuminate\Http\Request;
use Inertia\Inertia;

use function PHPSTORM_META\map;

class EstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allEstimates = Estimate::with('customer')->latest()->get();
        $features = Feature::latest()->get();
        return Inertia::render('AllEstimates', ['features' => $features, 'estimates' => $allEstimates]);
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
     *     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated =  $request->validate([
            'project_name' => 'required',
            'project_type' => 'required',
            'estimated_cost' => 'required',
            'estimated_time' => 'required',
            'customer_name' => 'required',
            'customer_id' => 'required',
        ]);
        $validated = (object)$validated;
        $result = Estimate::create([

            'project_name' => $validated->project_name,
            'project_type' => $validated->project_type,
            'estimated_cost' => $validated->estimated_cost,
            'estimated_time' => $validated->estimated_time,
            'customer_name' => $validated->customer_name,
            'customer_id' => $validated->customer_id,
            'features_ids' => $request->selected_feature_id,
        ]);

        if ($result) {
            // foreach ($request->selected_feature_id as $id) {
            //     $featureEstimate = new FeatureEstimate;
            //     $featureEstimate->feature_id = $id;
            //     $featureEstimate->estimate_id = $result->id;
            //     $featureEstimate->save();
            // }
            return response()->json(['data' => Estimate::latest()->get()], 200);
        } else {
            return 'data not saved';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function show(Estimate $estimate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function edit(Estimate $estimate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEstimateRequest  $request
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEstimateRequest $request, Estimate $estimate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estimate  $estimate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estimate $estimate)
    {
        //
    }
}
