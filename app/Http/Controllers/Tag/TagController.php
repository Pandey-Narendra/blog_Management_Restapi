<?php

namespace App\Http\Controllers\Tag;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class TagController extends Controller
{
    public function index()
    {
        try {
            $tags = Tag::all();
            return response()->json($tags);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching tags', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'tag_name' => 'required|string|max:255|unique:tags'
            ]);

            $tag = Tag::create($request->all());

            return response()->json($tag, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating tag', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            return response()->json($tag);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tag not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching tag', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tag = Tag::findOrFail($id);

            $request->validate([
                'tag_name' => 'required|string|max:255|unique:tags,tag_name,' . $tag->id
            ]);

            $tag->update($request->all());

            return response()->json($tag);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tag not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating tag', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();

            return response()->json(['message' => 'Tag deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Tag not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting tag', 'error' => $e->getMessage()], 500);
        }
    }
}
