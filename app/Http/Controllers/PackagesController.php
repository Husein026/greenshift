<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::where('isActive',true)->get();
        return view('packages.index')->with('packages', $packages);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('packages.add');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'lesson' => 'numeric|min:1',
            'price' => 'numeric|min:0',
        ];
    
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $existingPackage = Package::where('name', $request->name)
            ->where('hours', $request->lessons)
            ->where('price', $request->price)
            ->first();
    
        if ($existingPackage) {
            $existingPackage->isActive = true;
            $existingPackage->save();
    
            return redirect('packages')->with('message', 'Existing package has been updated successfully!');
        }
    
        $package = new Package();
        $package->name = $request->name;
        $package->hours = $request->lessons;
        $package->price = $request->price; 
        $package->save();
    
        return redirect('packages')->with('message', 'New package has been added successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
            $package = Package::find($id);
            $package->isActive = false;
            $package->save();
    
            return redirect()->route('packages.index')->with('message', 'Package Deleted successfully.');

    }
}
