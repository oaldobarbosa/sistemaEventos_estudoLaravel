<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

use App\Models\User;

class EventController extends Controller
{
    public function index(){

        $search = request('search');


        if($search){

            $events = Event::where([
                ['title', 'like', '%'.$search.'%']
            ])->get();
        } else {

        $events = Event::all();

        };

        return view('welcome', ['events' => $events, 'search' => $search]);
        
        }
    
    //chama a view create
    public function create(){

        return view('events.create');

    }

    //create evento request
    public function store(Request $request){
        
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;


        //image upoad
        if($request->hasFile('image') && $request->file('image')->isValid()){

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5( $requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path("img/events"), $imageName);

            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');

    }

    //exibir 1 evento
    public function show($id){

        
        $event = Event::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;

        if ($user) {

            $userEvents = $user->eventsasparticipant->toArray();

            foreach ($userEvents as $userEvent) {

                if ($userEvent['id'] == $id) {

                    $hasUserJoined = true;

                }

            }
  
        }

;
        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);
    }

    //dashboard
    public function dashboard(){

        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;


        return view('events.dashboard', 
            ['events' => $events, 'eventsasparticipant' => $eventsAsParticipant]
        );
    }

    //delete evento
    public function destroy($id){

        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento Excluído com sucesso');

    }
    // editar evento->chamar view
    public function edit($id){

        $user = auth()->user();

        $event = Event::findOrFail($id);

        if ($user->id != $event->user_id) {

            return redirect('/dashboard');
            
        }

        $event = Event::findOrFail($id);

        return view('events.edit', ['event' => $event]);

    } 
    
    //editar evento de fato
    public function update(Request $request){

        $data = $request->all();

        //image upoad
        if($request->hasFile('image') && $request->file('image')->isValid()){

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5( $requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path("img/events"), $imageName);

            $data['image'] = $imageName;
        }

        Event::findOrFail($request->id)->update($data);

        return redirect('/dashboard')->with('msg', 'Evento Editado com sucesso');

    }

    public function joinEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        return back()->with('msg', 'Inscrição Feita com Sucesso no evento: '. $event->title );


    }

    public function leaveEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);

        $event = Event::findOrFail($id);

        return back()->with('msg', 'Voĉe saiu do Evento: '. $event->title );

    }
}
