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

    /**
     * Get lessons.
     *
     * @param  string  $class_id
     * @return $lesson array
     */

    private function get(string $class_id = null)
    {
        // Instantiate Wonde Client
        $client = new Client(config('wonde.api_key'));

        // Set school ID
        $school = $client->school('A1930499544');

        // Set employee ID
        $employee_id = 'A333207420';

        return $this->get_classes($school, $employee_id, $class_id);
    }

    private function get_classes($school, $employee_id, $class_id = null)
    {
        // Set empty classes array
        $classes = array();

        if (!empty($class_id))
        {
            $classes[] = $school->classes->get($class_id, ['lessons', 'students'], ['lessons_start_after' => '2022-04-25 00:00:00']);
        } else {
            // Get teacher's classes
            foreach ($school->employees->get($employee_id, ['classes'])->classes->data as $employee_class) {
                // Get all the lessons and students for those classes
                $classes[] = $school->classes->get($employee_class->id, ['lessons'], ['lessons_start_after' => '2022-04-25 00:00:00']);
            }
        }

        return $this->get_lessons($classes, $employee_id, $class_id);
    }

    private function get_lessons($classes, $employee_id, $class_id)
    {
        // Set empty lessons array
        $lessons = array();

        // Loop through all the class data, add the lesson data to the array, removing the unnecessary data
        foreach($classes as $class)
        {
            foreach($class->lessons->data as $lesson)
            {
                // Store the class ID, class name and students data within the lesson data to allow us to access this data
                $lesson->class_id = $class->id;
                $lesson->class_name = $class->name;

                if (!empty($class_id)) {
                    $lesson->students = $class->students->data;
                }

                // Only add the lessons where this teacher is assigned.
                if($lesson->employee == $employee_id)
                {
                    $lessons[] = $lesson;
                }
            }
        }

        $lessons = collect($lessons);

        return $lessons->sortBy([
            fn ($a, $b) => $a->start_at->date <=> $b->start_at->date
        ]);
    }
}
