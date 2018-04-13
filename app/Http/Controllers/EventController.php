<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class EventController extends Controller
{
    public function getEvents()
    {
        return Event::all();
    }

    /**
     * Получение списка доступных ивентов
     * @return LengthAwarePaginator
     */
    public function getAvailableEvents()
    {

        $events = Event::with(['users'])->withCount(['users'])->orderBy('date_at', 'DESC');

        if (Input::get('filter') === 'default' || !Input::has('filter')) {

            if (Input::has('s')) {
                $search_string = Input::get('s');

                $events = $events->where('title', 'like', "%$search_string%");
            }

            $events = $events->where('date_at', '>=', time() - 86400)->get();
            $events = $events->reject(function ($item) {
                return $item['a_seats'] === $item['users_count'];
            });
        } else if (Input::get('filter') === 'passed') {
            $events = $events->where('date_at', '<', time())->get();
        } else if (Input::get('filter') === 'no_places') {
            $events = $events->where('date_at', '>=', time())->get();
            $events = $events->reject(function ($item) {
                return $item['a_seats'] !== $item['users_count'];
            });
        }

        if (Auth::check())
            $events = $events->reject(function ($item) {
                foreach ($item['users'] as $user)
                    if ($user->user_id === Auth::id()) return true;
            });


        return $this->paginate($events);
    }

    /**
     * Собственная пагинация
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function joinEvent($idEvent)
    {
        $user = User::find(Auth::user()->id);
        $user->events()->attach($idEvent);

        return redirect(route('home'));
    }

    public function cancelEvent($idEvent)
    {
        $user = User::find(Auth::user()->id);
        $user->events()->detach($idEvent);

        return redirect(route('myEvents'));
    }

    public function myEvents()
    {
        $events = Event::with(['users'])->get()->reject(function ($item) {

            if (!isset($item['users'][0])) return true;

            foreach ($item['users'] as $user)
                if ($user['user_id'] === Auth::user()->id) return false;
            return true;
        });

        return view('profile', [
            'data' => $events
        ]);
    }
}
