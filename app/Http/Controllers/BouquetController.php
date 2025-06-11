<?php

namespace App\Http\Controllers;

use App\Models\Bouquet;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Cherie Blossom API",
 *     version="1.0.0"
 * )
 *
 * @OA\PathItem(path="/api")
 */
class BouquetController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/bouquets",
     *     summary="Get all bouquets",
     *     tags={"Bouquets"},
     *     @OA\Response(
     *         response=200,
     *         description="List of bouquets"
     *     )
     * )
     */
    public function index()
    {
        return Bouquet::all();
    }

    /**
     * @OA\Post(
     *     path="/api/bouquets",
     *     summary="Create a new bouquet",
     *     tags={"Bouquets"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price"},
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="image", type="string")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Bouquet created")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|string',
        ]);

        return Bouquet::create($validated);
    }

    /**
     * @OA\Get(
     *     path="/api/bouquets/{id}",
     *     summary="Get bouquet by ID",
     *     tags={"Bouquets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Bouquet data"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function show(string $id)
    {
        return Bouquet::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/api/bouquets/{id}",
     *     summary="Update bouquet by ID",
     *     tags={"Bouquets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=false,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="price", type="number"),
     *             @OA\Property(property="image", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Bouquet updated")
     * )
     */
    public function update(Request $request, string $id)
    {
        $bouquet = Bouquet::findOrFail($id);
        $bouquet->update($request->all());
        return $bouquet;
    }

    /**
     * @OA\Delete(
     *     path="/api/bouquets/{id}",
     *     summary="Delete bouquet by ID",
     *     tags={"Bouquets"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Bouquet deleted")
     * )
     */
    public function destroy(string $id)
    {
        $bouquet = Bouquet::findOrFail($id);
        $bouquet->delete();
        return response()->json(['message' => 'Bouquet deleted']);
    }
}
