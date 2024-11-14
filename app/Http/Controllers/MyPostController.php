<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use App\Models\Post;

// class MyPostController extends Controller
// {
//     public function index()
//     {
//         // $post = Post::where('is_published', 1)->first();

//         // dump($post->title);

//         $posts = Post::all();

//         return view('posts', compact('posts'));

//         // dd($posts);

//         // dd('end');
//     }

//     public function create()
//     {
//         $postArr = [
//             [
//                 'title' => 'title_1',
//                 'past_content' => 'content_1',
//                 'image' => 'image_1',
//                 'likes' => 250,
//                 'is_published' => 1,
//             ],
//             [
//                 'title' => 'title_2',
//                 'past_content' => 'content_2',
//                 'image' => 'image_2',
//                 'likes' => 350,
//                 'is_published' => 0,
//             ]
//         ];

//         // Post::create([
//         //     'title' => 'title_5',
//         //     'content' => 'content_5',
//         //     'image' => 'image_5',
//         //     'likes' => 35,
//         //     'is_published' => 0,
//         // ]);

//         foreach ($postArr as $item) {
//             Post::create($item);
//         }
//         dd('created');
//     }

//     public function update()
//     {
//         $post = Post::find(4);

//         $post->update([
//             'title' => 'updated',
//             'content' => 'updated',
//             'image' => 'updated',
//             'likes' => 1000,
//             'is_published' => 0,
//         ]);

//         dd('updated');
//     }

//     public function delete()
//     {

//         // $post = Post::find(2);
//         // $post->delete();

//         $post = Post::withTrashed()->find(2);
//         $post->restore();

//         dd('deleted');
//     }

//     # Комбинированные запросы

//     // firstOrCreate 
//     // updateOrCreate

//     public function firstOrCreate()
//     {
//         $anotherPostArr = [
//             'title' => 'title_3',
//             'content' => 'content_3',
//             'image' => 'image_3',
//             'likes' => 450,
//             'is_published' => 0,
//         ];

//         $post = Post::firstOrCreate([
//             'title' => 'title_2',
//         ], [
//             'title' => 'title_2',
//             'content' => 'content_3',
//             'image' => 'image_3',
//             'likes' => 450,
//             'is_published' => 0,
//         ]);

//         dump($post->content);
//         dd('finished');
//     }
//}
