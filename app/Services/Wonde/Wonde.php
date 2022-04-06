<?php

namespace App\Services\Wonde;

use stdClass;
use Wonde\Client;
use Wonde\Exceptions\InvalidTokenException;

class Wonde
{
    private Client $client;

    /**
     * Instantiates the Wonde Client
     * @throws InvalidTokenException
     */
    public function __construct()
    {
        $this->client = new Client(config('wonde.api_key'));
    }

    /**
     * Returns the school object
     * @return \Wonde\Endpoints\Schools
     */
    public function school(): \Wonde\Endpoints\Schools
    {
        return $this->client->school('A1930499544');
    }

    /**
     * Returns the class object
     * @return stdClass
     */
    public function class($class_id): stdClass
    {
        return $this->school()->classes->get($class_id, ['lessons', 'students']);
    }

    /**
     * Get classes object by employee and optionally by class id
     * @param string $employee_id
     * @param string|null $class_id
     * @return array
     */
    public function classes(string $employee_id, string $class_id = null): array
    {
        $classes = [];

        if (!empty($class_id))
        {
            $classes[] = $this->school()->classes->get($class_id, ['lessons', 'students'], ['lessons_start_after' => '2022-04-25 00:00:00']);
        } else {

            // Get teacher's classes
            foreach($this->school()->employees->get($employee_id, ['classes'])->classes->data as $employee_class)
            {
                // Get all the lessons and students for those classes
                $classes[] = $this->school()->classes->get($employee_class->id, ['lessons'], ['lessons_start_after' => '2022-04-25 00:00:00']);
            }
        }

        return $classes;
    }

    /**
     * Get lessons object by employee and optionally by class id
     * @param string $employee_id
     * @param string|null $class_id
     * @return array
     */
    public function lessons(string $employee_id, string $class_id = null)
    {
        // Set empty lessons array
        $lessons = [];

        // Loop through all the class data, add the lesson data to the array, removing the unnecessary data
        foreach($this->classes($employee_id, $class_id) as $class)
        {
            foreach($class->lessons->data as $lesson)
            {
                // Store the class ID, class name and students data within the lesson data to allow us to access this data
                $lesson->class_id = $class->id;
                $lesson->class_name = $class->name;

                if (!empty($class_id)) {
                    $lesson->students = $this->class($class_id)->students->data;
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
