<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{
    public function index()
    {
        try {
            $comments = Comment::all();
            return response()->json($comments);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching comments', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'post_id' => 'required|exists:posts,id',
                'comment_content' => 'required'
            ]);

            $comment = new Comment($request->all());
            $comment->commented_by = Auth::id();
            $comment->save();

            return response()->json($comment, 201);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating comment', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            return response()->json($comment);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Comment not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error fetching comment', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            if (Auth::id() !== $comment->commented_by) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            $request->validate([
                'comment_content' => 'required'
            ]);

            $comment->update($request->all());

            return response()->json($comment);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Comment not found'], 404);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation Error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error updating comment', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $comment = Comment::findOrFail($id);
            if (Auth::id() !== $comment->commented_by) {
                return response()->json(['message' => 'Forbidden'], 403);
            }

            $comment->delete();

            return response()->json(['message' => 'Comment deleted']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Comment not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error deleting comment', 'error' => $e->getMessage()], 500);
        }
    }
}
