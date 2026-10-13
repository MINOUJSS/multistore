<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\UserEmployee; // Assuming UserEmployee model exists for employees
use Illuminate\Http\Request; // Assuming Admin model is also relevant based on previous content

class AdminEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch and return a list of employees.
        // Based on the provided file content, it seems there was a consideration to use Admin model.
        // Using Admin model as it was commented out in the previous version, assuming this is the desired logic.
        // Using ->get() to fetch results, which is generally preferred over ->all() for Eloquent queries.
        $employees = Admin::where('type', '<>', 'admin')->get();

        return view('admins.admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a form view for creating a new employee
        // Example: return view('admin.employees.create');
        return view('admins.admin.employees.create');

        // For now, returning a placeholder response
        return response()->json(['message' => 'Create employee form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store new employee data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admins', // Assuming 'admins' is the table name for Admin model
            'password' => 'required|string|min:8', // Minimum 8 characters for password
            'type' => 'required|string|in:support,manager,developer,financial_manager', // Example types, adjust as needed
            'phone' => 'required|string|regex:/^(\+?0[0-9]{9})$/|unique:admins', // Example regex for Algerian phone numbers
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB image file
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $stored = admin_media_service()->storeFile($request->file('photo'), 'employees/'.$request->phone.'/photos/avatars');
            $validatedData['photo'] = $stored['path'];
        }

        // Assuming Admin model is used for employees based on index method
        $employee = Admin::create($validatedData);

        // Redirect back to the index page with a success message
        return redirect()->route('admin.employees')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(['message' => "Show employee with ID: {$id}"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $employee = Admin::findOrFail($id);
        return view('admins.admin.employees.edite', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Fetch the employee to update
        $employee = Admin::findOrFail($id);

        // Validate and update employee data
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|unique:admins,email,'.$employee->id,
            'password' => 'nullable|string|min:8',
            'type' => 'sometimes|required|string|in:support,manager,developer,financial_manager',
            'phone' => 'sometimes|required|string|regex:/^(\+?0[0-9]{9})$/',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload if a new photo is provided
        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                admin_media_service()->deleteFile($employee->photo);
            }
            $targetPhone = $request->phone ?? $employee->phone;
            $stored = admin_media_service()->storeFile($request->file('photo'), 'employees/'.$targetPhone.'/photos/avatars');
            $validatedData['photo'] = $stored['path'];
        }

        // Update the employee record
        if (empty($request->password)) {
            $employee->update(collect($validatedData)->except('password')->toArray());
        } else {
            $validatedData['password'] = bcrypt($request->password);
            $employee->update($validatedData);
        }

        return redirect()->route('admin.employees')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $employee = Admin::findOrFail($id);
        if ($employee->photo) {
            admin_media_service()->deleteFile($employee->photo);
        }
        admin_media_service()->deleteDirectory('employees/'.$employee->phone);
        admin_media_service()->deleteDirectory($employee->phone);
        $employee->delete();
        return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully.');
    }
}

