<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{

    /**
     * Выход из админ панели
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->forget('admin');
        return redirect(route('home'));
    }

    /**
     * Отображение главной страницы
     */
    public function getIndex()
    {
        $events = Event::orderBy('date_at', 'desc')->get();

        return view('admin.index', [
            'data' => $events,
        ]);
    }

    /**
     * Добавление события
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $data = $request->post();

        $sd = explode('/', $data['date_at']);
        $date_at = strtotime($sd[2] . '-' . $sd[1] . '-' . $sd[0]);

        $result = Event::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'date_at' => $date_at,
            'a_seats' => $data['a_seats'],
            'age_start' => $data['age_start'],
            'age_end' => $data['age_end']
        ]);

        if ($result) return redirect(route('admin'));
        else return redirect(route('addEvent'));
    }

    public function createXML(Request $request)
    {
        $file = Input::file('file');

        $xml = simplexml_load_file($file->getRealPath());

        foreach ($xml->event as $event) {
            $ds = explode('/', $event->date);
            $timestamp = strtotime($ds[2].'-'.$ds[1].'-'.$ds[0]);

            Event::create([
                'title' => $event->name,
                'description' => $event->description,
                'date_at' => $timestamp,
                'a_seats' => $event->place,
                'age_start' => $event->age->attributes()->min,
                'age_end' => $event->age->attributes()->max,
            ]);
        }

        return redirect(route('admin'));

    }

    public function delete(Request $request)
    {
        $id = $request->id;

        $event = Event::find($id);
        $event->delete();

        return redirect(route('admin'));
    }
}
