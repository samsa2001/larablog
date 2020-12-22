<?php

namespace App\Http\Controllers\dashboard;

use App\Helpers\CustomUrl;
use App\Contact;
use App\ContactImage;
use App\Http\Controllers\Controller;  
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // este middleware controla que el usuario está autenticado antes de poder acceder a las rutas de dashboard/contact 
    // sino lo redirige al login
    public function __construct()
    {
        $this->middleware(['auth','rol.admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // almacenamos en $contacts los datos obtenidos con el modelo Contact. Para recuperar los datos podemos utilizar el get() o paginate()
        $contacts = Contact::orderBy('created_at','desc')->paginate(10);
        return view('dashboard.contact.index',['contacts' => $contacts]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*
    public function show($id)
    {
        $contact=Contact::findOrFail($id);
        return view('dashboard.contact.show',['contact' => $contact]);
    }
    */
    public function show(Contact $contact)
    {
        return view('dashboard.contact.show',['contact' => $contact]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('status','Contact eliminado con éxito');
    }
}
