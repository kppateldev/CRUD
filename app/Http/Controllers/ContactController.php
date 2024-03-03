<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        if( auth()->guard('web')->check() ):
			$userId = auth()->guard('web')->user()->id;
		endif;
        $contacts = Contact::where('user_id',$userId)->orderBy('id','ASC')->paginate(10);
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',
        ]);
        if( auth()->guard('web')->check() ):
			$userId = auth()->guard('web')->user()->id;
		endif;
        $contact = array(
			'user_id' =>$userId,
			'name' =>$request->name,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'address' =>$request->address,
		);
        Contact::create($contact);
        return redirect()->route('contacts.index')->with('success','Contact has been created successfully.');
    }

    public function show(Contact $contact)
    {
        return view('contacts.show',compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit',compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required',
            //'email' => 'required',
            'phone' => 'required|numeric|digits:10',
            'address' => 'required',
        ]);
        
        $contact->fill($request->post())->save();

        return redirect()->route('contacts.index')->with('success','Contact has been updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success','Contact has been deleted successfully.');
    }

    public function OrderBy(Request $request)
    {
        if( auth()->guard('web')->check() ):
			$userId = auth()->guard('web')->user()->id;
		endif;
        $contacts = Contact::where('user_id',$userId);
        if($request->order_by == 1)
        {
            $contacts = $contacts->orderBy('id', 'ASC');
        } elseif($request->order_by == 2)
        {
            $contacts = $contacts->orderBy('id', 'DESC');
        }
        $contacts = $contacts->get();
        $html = view('contacts/contact_popup', compact('contacts'))->render();
        return response()->json($html);
    }

    public function search_contacts(Request $request)
    {
        if( auth()->guard('web')->check() ):
			$userId = auth()->guard('web')->user()->id;
		endif;
        $contacts = Contact::where('user_id',$userId);
        if($request->keyword != ''){
            $contacts = $contacts->where('name','LIKE','%'.$request->keyword.'%');
        }
        $contacts = $contacts->orderBy('id', 'ASC');
        $contacts = $contacts->get();
        $html = view('contacts/contact_popup', compact('contacts'))->render();
        return response()->json($html);
    }
}