<?php

namespace App\Http\Controllers;

use App\Services\Wonde\Wonde;

class LessonController extends Controller
{
    public $wondeApi;

    public function __construct()
    {
        $this->wondeApi = new Wonde();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(view('lessons.index')->with(['lessons' => $this->wondeApi->lessons('A333207420')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        return response(view('lessons.show')->with(['lesson' => $this->wondeApi->lessons('A333207420', $id)[0]]));
    }
}
