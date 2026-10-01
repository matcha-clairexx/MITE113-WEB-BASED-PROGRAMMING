<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::with('owner')->latest()->get();

        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:students,email'],
            'program' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1', 'max:5'],
            'id_number' => ['required', 'string', 'max:20', 'unique:students,id_number'],
        ]);

        $validatedData['owner_id'] = $request->user()->id;

        Student::create($validatedData);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student): View
    {
        $student->load('owner');

        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        $this->authorize('update', $student);

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $this->authorize('update', $student);

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:students,email,' . $student->id],
            'program' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'min:1', 'max:5'],
            'id_number' => ['required', 'string', 'max:20', 'unique:students,id_number,' . $student->id],
        ]);

        $student->update($validatedData);

        return redirect()
            ->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);

        $student->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
