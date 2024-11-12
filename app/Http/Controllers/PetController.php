<?php
namespace App\Http\Controllers;

//use App\Http\Controllers;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function getAllPets(Request $request)
    {
        $dsPet = Pet::get();
        if ($dsPet->isEmpty()) {
            return response()->json(['message' => 'No pets found'], 404);
        }
        return response()->json($dsPet, 200);
    }
}
