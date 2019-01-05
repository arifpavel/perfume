<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Perfume;

class PerfumeController extends Controller
{
     /**
     * Constructor function
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Perfume::latest()->paginate(2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'aroma' => 'required',
            'type' => 'required',
            'stock' => 'required'
        ]);
        return Perfume::create([
            'name' => $request['name'],
            'aroma' => $request['aroma'],
            'type' => $request['type'],
            'stock' => $request['stock']
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
        $perfume = Perfume::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'aroma' => 'required',
            'type' => 'required',
            'stock' => 'required'
        ]);
        $currentImage = $perfume->image;
        //Check current image isn't same as new image.
        if( $request->image != $currentImage ){
            $imagename = time().'.'. explode('/', explode(':', substr($request->image, 0, strpos(
                $request->image, ';')))[1])[1];
                // Save the image using image intervention package from base 64 image
                \Image::make($request->image)->save(public_path('img/perfume/').$imagename);
                // Merge/replace imagename with $request
                $request->merge(['image' => $imagename]); 

                $pastImage = public_path('img/perfume/').$currentImage;
                if(file_exists($pastImage)){
                    unlink($pastImage);
                }
        }
        $perfume->update($request->all());
        return ['message' => 'perfume info updated.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $perfume = Perfume::findOrFail($id);
        $perfume->delete();
        return ['message' => 'perfume has been deleted.'];
    }
}
