<?php

namespace App\Http\Controllers;

use auth;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //

    public function index(){
        // dd(request()->tag);
        return view('listings.index',[
            // 'heading'=>'Latest Listing',
            'listings'=>Listing::latest()->filter
            (request(['tag','search']))
            ->paginate(2)
        ]);
    }

    public function show($id){
        $listing = Listing::find($id);
        if($listing){

            return view('listings.show',[
                'listing'=>$listing
            ]);
        }
        else{
            abort(404);
        }

    }
    public function create(){
        return view('listings.create');
    }
    public function store( Request $req){
        $formFields=$req->validate([
            'title'=>'required',
            'tags'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'location'=>'required',
            'company'=>['required',Rule::unique('listings','company')],
            'description'=>'required',

        ]);

        if($req->hasFile('logo')){
            // dd($req->file('logo'));
            $formFields['logo']=$req->file('logo')->store('logos','public');

        }
        $formFields['user_id']= auth()->id();
        // dd($formFields);
        Listing::create($formFields);
        return redirect('/')->with('message','Listing created succesfully');
        // dd($req->all());
        // return view('listings.create');
    }
    public function edit(Listing $listing){
        // dd($listing->company);
        return view('listings.edit', ['listing'=>$listing] );

    }
    // update
    // public function update(Request $req,Listing $listing){
    //     $formFields=$req->validate([
    //         'title'=>'required',
    //         'tags'=>'required',
    //         'website'=>'required',
    //         'email'=>['required','email'],
    //         'location'=>'required',
    //         'company'=>'required',
    //         'description'=>'required',
    //         'logo'=>'required'
    //     ]);

    //     if($req->hasFile('logo')){

    //         $formFields['logo']=$req->file('logo')->store('logos','public');

    //     }

    //     $listing->create($formFields);
    //     return redirect('/')->with('message','Listing updated succesfully');

    // }
    public function update(Request $request, Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }


        $listing->update($formFields);

        return redirect('/')->with('message', 'Listing updated successfully!');
    }
    public function delete(Listing $listing){

        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }

    public function manage(){

        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

    }

