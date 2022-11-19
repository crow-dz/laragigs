<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index()
    {
        return view('listing.index', [
            'heading' => 'Latest Listings',
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }
    // Show singal listing
    public function show(Listing $listing)
    {
        return view('listing.show', ['listing' => $listing]);
    }
    // Show create form
    public function create()
    {
        return view('listing.create');
    }
    //  store listing data
    public function store(Request $request)
    {
        $formFields = $request->validate(
            [
                'title' => 'required',
                'company' => ['required', Rule::unique('listings', 'company')],
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required',
                'description' => 'required',

            ]
        );
        if ($request->hasfile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        $formFields['user_id'] = auth()->id();
        // add data to database
        Listing::create($formFields);
        return redirect('/')->with('message', 'Listing created successfully!');
    }
    // Show edit form
    public function edit(Listing $listing)
    {
        return view('listing.edit', ['listing' => $listing]);
    }
    //  update listing
    public function update(Request $request,Listing $listing)
    {

        if($listing->user_id != auth()->id()){
            abort(403,'Unauthorized Action');
        }
        $formFields = $request->validate(
            [
                'title' => 'required',
                'company' => ['required' ],
                'location' => 'required',
                'website' => 'required',
                'email' => ['required', 'email'],
                'tags' => 'required',
                'description' => 'required',

            ]
        );
        if ($request->hasfile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        // add data to database
        $listing->update($formFields);
        return back()->with('message', 'Listing updated successfully!');
    }
        // Delete listing
        public function destroy(Listing $listing)
        {
            if($listing->user_id != auth()->id()){
                abort(403,'Unauthorized Action'
            );
            }
            $listing->delete();
            return redirect('/')->with('message', 'Listing deleted successfully!');
        }
          // Mange listing
          public function manage()
          {
           return view('listing.manage',['listing'=>auth()->user()->listings()->get()]);
          }
}

