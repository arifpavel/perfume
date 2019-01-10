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
        $this->middleware('api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Perfume::latest()->paginate(6);
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
        if( $request->image){
            $imagename = time().'.'. explode('/', explode(':', substr($request->image, 0, strpos(
                $request->image, ';')))[1])[1];
                // Save the image using image intervention package from base 64 image
                \Image::make($request->image)->save(public_path('img/perfume/').$imagename);
                // Merge/replace imagename with $request
                $request->merge(['image' => $imagename]); 
        }
        return Perfume::create([
            'name' => $request['name'],
            'aroma' => $request['aroma'],
            'type' => $request['type'],
            'stock' => $request['stock'],
            'image' => $request['image']
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

    /**
     * Get query string from api call
     * Return user resources with matched by query
     */
    public function search(){
        if( $search = \Request::get('q') ){
            $perfumes = Perfume::where(function ($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")
                ->orWhere('aroma', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%")
                ->orWhere('stock', 'LIKE', "%$search%");
            })->paginate(6);
            return $perfumes;
        }
        else{
            return Perfume::latest()->paginate(6);
        }
        
    }

    /**
     * Get query id from api call
     * Return perfume resources with matched by aroma & type
     */
    public function searchFront(){
        if( $search = \Request::get('q') ){
            $type = Perfume::findOrFail($search);
            $type = $type->type;
            $perfumes = Perfume::where(function ($query) use ($type){
                $query->where('type', 'LIKE', "%$type%");
            })->paginate(6);
            return $perfumes;
        }
        else{
            return Perfume::latest()->paginate(6);
        }
        
    }

    /**
     * Return all name resources
     */
    public function getAllName(){
        //return Perfume::all()->toArray();     
        return Perfume::all('name','id');     
    }
}
