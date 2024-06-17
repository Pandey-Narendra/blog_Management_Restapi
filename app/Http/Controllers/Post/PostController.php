<?php

namespace App\Http\Controllers\Post;

use App\Models\Post;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::where(function ($query) {
                $query->where('published', true)
                      ->orWhere('user_id', Auth::id());
            })->get();

            return response()->json(['posts' => $posts]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while fetching posts.', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->published || $post->user_id == Auth::id()) {
                return response()->json($post);
            }

            return response()->json(['message' => 'Unauthorized'], 403);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while fetching the post.', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'slug' => 'required|string|max:255|unique:posts',
                'category_id' => 'nullable|exists:categories,id',
                'published' => 'boolean',
                'featured_image' => 'nullable|string',
                'tags' => 'array',
                'tags.*' => 'exists:tags,id'
            ]);

            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'slug' => $request->slug,
                'user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'published' => $request->published ?? false,
                'featured_image' => $request->featured_image,
            ]);

            if ($request->has('tags')) {
                $post->tags()->sync($request->tags);
            }

            return response()->json($post, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while storing the post.', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id != Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'slug' => 'sometimes|required|string|max:255|unique:posts,slug,' . $post->id,
                'category_id' => 'nullable|exists:categories,id',
                'published' => 'boolean',
                'featured_image' => 'nullable|string',
                'tags' => 'array',
                'tags.*' => 'exists:tags,id'
            ]);

            $post->update($request->only(['title', 'content', 'slug', 'category_id', 'published', 'featured_image']));

            if ($request->has('tags')) {
                $post->tags()->sync($request->tags);
            }

            return response()->json($post);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while updating the post.', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id != Auth::id()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }

            $post->delete();

            return response()->json(['message' => 'Post deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Post not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while deleting the post.', 'error' => $e->getMessage()], 500);
        }
    }
}
