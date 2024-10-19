<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function service(Request $request)
    {
        // Set default items per page
        $perPage = $request->input('per_page', 6); // Default is 6 services per page
        // Paginate services
        $services = Service::paginate($perPage);
        
        return view('service.service', compact('services'));
    }

    public function detail($slug)
    {
        // Fetch the service by slug
        $service = Service::where('slug', $slug)->first();

        // Check if the service exists
        if ($service) {
            // Return the service detail view
            return view('service.detail', compact('service'));
        } else {
            // Redirect with error if service not found
            return redirect()->route('home')->with('error', 'Service not found');
        }
    }

    public function servicesByCategory($categorySlug)
    {
        // Fetch the category by slug
        $category = Category::where('slug', $categorySlug)->first();

        // If the category exists, fetch its services
        if ($category) {
            $services = Service::where('categories_id', $category->id)->paginate(6); // Correct the category ID
            return view('service.index', compact('services', 'category'));
        } else {
            // If the category does not exist, redirect to home with an error
            return redirect()->route('home')->with('error', 'Category not found');
        }
    }
}
