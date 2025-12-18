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
            //get file extension
            $extension = $request->file('photo')->getClientOriginalExtension();
            //set file name to employee_name.extension
            $fileName = $request->name . '.' . $extension;
            //strore file
            $photoPath = $request->file('photo')->store($request->phone.'/photos/avatars/'.$fileName, 'employees'); // Store in 'storage/app/public/photos'
            $validatedData['photo'] = $photoPath;
        }

        // Assuming Admin model is used for employees based on index method
        $employee = Admin::create($validatedData);

        // Redirect back to the index page with a success message
        // If this is an API, you might return a JSON response instead
        return redirect()->route('admin.employees')->with('success', 'Employee created successfully.');
        // If you need to return JSON for an API:
        // return response()->json(['message' => 'Employee stored successfully', 'data' => $employee], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch and return a specific employee
        // Example: $employee = UserEmployee::findOrFail($id);
        // return view('admin.employees.show', compact('employee'));
        // For now, returning a placeholder response
        return response()->json(['message' => "Show employee with ID: {$id}"]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Fetch employee and return edit form view
        // Example: $employee = UserEmployee::findOrFail($id);
        $employee = Admin::findOrFail($id);
        return view('admins.admin.employees.edite', compact('employee'));
        // For now, returning a placeholder response
        // return response()->json(['message' => "Edit employee form for ID: {$id}"]);
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
            'email' => 'sometimes|required|string|email|unique:admins,email,'.$employee->id, // Ensure email is unique, ignoring the current employee's email
            'password' => 'nullable|string|min:8', // Minimum 8 characters for password
            'type' => 'sometimes|required|string|in:support,manager,developer,financial_manager', // Example types, adjust as needed
            'phone' => 'sometimes|required|string|regex:/^(\+?0[0-9]{9})$/', // Example regex for Algerian phone numbers
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB image file, nullable for updates
        ]);

        // Handle file upload if a new photo is provided
        if ($request->hasFile('photo')) {
            // Optionally, delete the old photo if it exists
            // if ($employee->photo && Storage::disk('public')->exists($employee->photo)) {
            //     Storage::disk('public')->delete($employee->photo);
            // }
            $photoPath = $request->file('photo')->store('photos', 'public'); // Store in 'storage/app/public/photos'
            $validatedData['photo'] = $photoPath;
        } elseif ($request->filled('photo') && !$request->hasFile('photo')) {
            // If 'photo' is sent but it's not a file (e.g., an empty string or null to remove), handle accordingly.
            // For now, we assume 'nullable' handles cases where it's not sent.
            // If you want to explicitly remove the photo, you might need a specific flag or logic.
        }

        // Update the employee record
        if (empty($request->password)) {
            // استبعاد حقل كلمة المرور من التحديث
            $employee->update(collect($validatedData)->except('password')->toArray());
        } else {
            // إذا تم إدخال كلمة مرور جديدة نقوم بتشفيرها ثم التحديث الكامل
            $validatedData['password'] = bcrypt($request->password);
            $employee->update($validatedData);
        }

        // Redirect back to the index page with a success message
        // If this is an API, you might return a JSON response instead
        return redirect()->route('admin.employees')->with('success', 'Employee updated successfully.');
        // If you need to return JSON for an API:
        // return response()->json(['message' => "Employee with ID: {$id} updated successfully", 'data' => $employee]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete employee
        // Example: $employee = UserEmployee::findOrFail($id);
        $employee = Admin::findOrFail($id);
        //delete the store folder of this omployee
        Storage::disk('employees')->deleteDirectory($employee->phone);
        $employee->delete();
        return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully.');
        // For now, returning a placeholder response
        //return response()->json(['message' => "Employee with ID: {$id} deleted successfully"]);
    }
}
