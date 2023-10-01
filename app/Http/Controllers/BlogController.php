<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $genre = $request->get('genre');

        $blogs = Blog::with('user');

        if ($genre) {
            $blogs = $blogs->where('genre', $genre);
        }

        if ($request->path() === 'dashboard' || $request->path() === '/') {
            return view('dashboard', [
                'blog' => $blogs->latest()->paginate(10),
            ]);
        } else {
            return view('blog.index', [
                'blog' => $blogs->latest()->paginate(10),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,bmp,gif',
            'genre' => 'nullable'
        ]);
 
        $imagePath = null;
        if ($request->hasFile('image')) 
        {
            $imagePath = $this->storageImage($request);
        }

        $request->user()->blog()->create([
            'message' => $validated['message'],
            'image' => $imagePath,
            'genre' => $validated['genre']
        ]);

        return redirect(route('blog.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);
 
        return view('blog.edit', [
            'blog' => $blog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);
 
        $validated = $request->validate([
            'message' => 'required|string|max:255',
           
        ]);
 
        $blog->update($validated);
 
        return redirect(route('blog.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete',$blog);
    
        $imagePath = $blog->image;

        if ($imagePath && file_exists(public_path('blog_images/'.$imagePath))) 
        {
            unlink(public_path('blog_images/'.$imagePath));
        }
        $blog->delete();

        return redirect(route('blog.index'));
    }

    //zapisuje przeslane zdjecie w blog images oraz nadaje mu unikalne id-tmp.rozszerzenie zdjecia
    private function storageImage($request)
    {
        $desination_path='public/blog_images';
        $newImageName = uniqid() . '-' . $request->image . '.' . $request->image->extension();
        
        $request->image->move(public_path('blog_images'),$newImageName);

        return basename($newImageName);
    }
}
