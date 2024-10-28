<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // API lấy danh sách tin tức
    public function news(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);

        $query = News::with(['categorynew', 'user']);

        if ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        $newsItems = $query->paginate($perPage, ['*'], 'page', $page)->through(function ($news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'description' => $news->description,
                'image' => $news->image,
                'detail' => $news->detail,
                'category_name' => $news->categorynew ? $news->categorynew->name : null,
                'user_name' => $news->user ? $news->user->name : null,
                'created_at' => $news->created_at,
                'updated_at' => $news->updated_at,
            ];
        });

        return response()->json($newsItems, 200);
    }

    // API lấy chi tiết tin tức
    public function newsDetail($id)
    {
        $news = News::with(['categorynew', 'user'])->find($id);

        if (!$news) {
            return response()->json(['message' => 'Tin tức không tồn tại'], 404);
        }

        $formattedNews = [
            'id' => $news->id,
            'title' => $news->title,
            'content' => $news->content,
            'description' => $news->description,
            'image' => $news->image,
            'detail' => $news->detail,
            'category_name' => $news->categorynew ? $news->categorynew->name : null,
            'user_name' => $news->user ? $news->user->name : null,
            'created_at' => $news->created_at,
            'updated_at' => $news->updated_at,
        ];

        return response()->json($formattedNews, 200);
    }
}
