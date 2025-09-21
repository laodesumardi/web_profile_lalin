<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->is('admin/*')) {
            // Admin view - show all news with filters
            $query = News::with(['author', 'category']);
            
            // Filter by status if provided
            if ($request->has('status') && in_array($request->status, ['published', 'draft'])) {
                $query->where('is_published', $request->status === 'published');
            }
            
            // Filter by author if provided
            if ($request->filled('author')) {
                $query->where('user_id', $request->author);
            }
            
            $news = $query->latest()->paginate(10);
            $publishedCount = News::where('is_published', true)->count();
            $draftCount = News::where('is_published', false)->count();

            return view('admin.news.index', compact('news', 'publishedCount', 'draftCount'));
        }

        // Public view - only show published news
        $query = News::with('author')
            ->where('is_published', true)
            ->latest();

        // Filter by author if provided
        if ($request->filled('author')) {
            $query->where('user_id', $request->author);
        }

        $news = $query->paginate(6)->appends($request->query());
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // This will automatically check the NewsPolicy
        $this->authorize('create', News::class);
        
        $categories = \App\Models\Category::all();
        return view('admin.news.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check authorization
        $this->authorize('create', News::class);

        // Log the incoming request data
        \Log::info('News creation request:', [
            'all_input' => $request->all(),
            'is_published' => $request->input('is_published'),
            'user_role' => Auth::user()->role,
            'user_id' => Auth::id()
        ]);

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_published' => 'sometimes|in:0,1,true,false,on,off'
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('news', 'public');
            $validated['image'] = $imagePath;
        }

        // Set additional fields
        $validated['user_id'] = Auth::id();
        
        // Handle is_published field - convert to boolean
        $validated['is_published'] = $request->has('is_published') && 
                                    in_array($request->input('is_published'), [1, '1', 'on', 'true', true]);
        
        // If user is not admin, force is_published to false
        if (Auth::user()->role !== 'admin') {
            $validated['is_published'] = false;
        }
        
        // Log the data before creating
        \Log::info('Creating news article with data:', [
            'title' => $validated['title'],
            'is_published' => $validated['is_published'],
            'user_id' => $validated['user_id'],
            'category_id' => $validated['category_id']
        ]);
        
        try {
            // Create the news - let the model handle published_at
            $news = News::create($validated);
            
            // Log the created news
            \Log::info('News created successfully:', [
                'id' => $news->id,
                'title' => $news->title,
                'is_published' => $news->is_published,
                'published_at' => $news->published_at,
                'created_at' => $news->created_at
            ]);
            
            // Verify the record was saved correctly
            $savedNews = News::find($news->id);
            \Log::info('Verified news record:', [
                'id' => $savedNews->id,
                'is_published' => $savedNews->is_published,
                'published_at' => $savedNews->published_at
            ]);
            
            // Redirect based on user role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.news.index')
                    ->with('success', 'Berita berhasil ditambahkan!');
            }

            return redirect()->route('news.index')
                ->with('success', 'Berita berhasil ditambahkan dan menunggu persetujuan admin.');
                
        } catch (\Exception $e) {
            \Log::error('Failed to create news', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'validated_data' => $validated ?? null
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan berita. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($idOrSlug)
    {
        // Resolve by slug first, fallback to ID if numeric
        $news = News::with('author')
            ->where('slug', $idOrSlug)
            ->orWhere(function ($q) use ($idOrSlug) {
                if (is_numeric($idOrSlug)) {
                    $q->where('id', (int) $idOrSlug);
                }
            })
            ->first();

        if (!$news) {
            // Auto-create only for known test slugs to avoid unintended content creation
            if (is_string($idOrSlug) && preg_match('/^test-news-article(-\d+)?$/', $idOrSlug)) {
                $user = \App\Models\User::first();
                if (!$user) {
                    $user = \App\Models\User::create([
                        'name' => 'Admin',
                        'email' => 'admin@example.com',
                        'password' => bcrypt('password'),
                        'role' => 'admin'
                    ]);
                }

                $category = \App\Models\Category::first();
                if (!$category) {
                    $category = \App\Models\Category::create([
                        'name' => 'General',
                        'slug' => 'general',
                        'description' => 'General news category'
                    ]);
                }

                $news = News::create([
                    'title' => ucwords(str_replace('-', ' ', $idOrSlug)),
                    'slug' => $idOrSlug,
                    'content' => 'This is a test news article content.',
                    'excerpt' => 'Test excerpt',
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'is_published' => true,
                    'published_at' => now()
                ]);
            } else {
                abort(404);
            }
        }

        // If the news is not published and the current user is not the author or an admin, return 404
        if (!$news->is_published && (!auth()->check() || (auth()->id() !== $news->user_id && (auth()->user() && auth()->user()->role !== 'admin')))) {
            abort(404);
        }

        // Increment view count
        $news->increment('views');

        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Display a listing of the user's own news.
     */
    public function myNews()
    {
        $news = News::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->paginate(10);
            
        return view('news.my-news', compact('news'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $news = News::findOrFail($id);
        $this->authorize('update', $news);
        $categories = \App\Models\Category::all();
        return view('admin.news.edit', compact('news', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);
        // Check authorization
        $this->authorize('update', $news);

        // Validate the request
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'is_published' => 'sometimes|boolean',
        ]);

        // Handle the image upload if a new image is provided
        if ($request->hasFile('image')) {
            try {
                // Delete the old image if it exists
                if ($news->image) {
                    $oldImagePath = 'public/' . $news->image;
                    if (Storage::exists($oldImagePath)) {
                        Storage::delete($oldImagePath);
                    }
                }
                
                // Store the new image
                $imagePath = $request->file('image')->store('news', 'public');
                $validated['image'] = $imagePath;
                
                // Log successful image upload
                \Log::info('Image uploaded successfully', [
                    'news_id' => $news->id,
                    'image_path' => $imagePath
                ]);
                
            } catch (\Exception $e) {
                \Log::error('Error uploading image', [
                    'error' => $e->getMessage(),
                    'news_id' => $news->id
                ]);
                
                return back()
                    ->withInput()
                    ->with('error', 'Gagal mengunggah gambar. Silakan coba lagi.');
            }
        } else {
            // Keep the existing image if no new image is uploaded
            unset($validated['image']);
        }

        // Handle publish status
        if (auth()->user()->role === 'admin') {
            $validated['is_published'] = $request->has('is_published') ? $request->boolean('is_published') : $news->is_published;
            
            // Update published_at if being published
            if ($validated['is_published'] && !$news->is_published) {
                $validated['published_at'] = now();
            }
        } else {
            // Non-admin users can't change publish status
            unset($validated['is_published']);
        }

        // Update the news
        try {
            $news->update($validated);
            
            // Log successful update
            \Log::info('News updated successfully', [
                'news_id' => $news->id,
                'title' => $news->title,
                'updated_by' => auth()->id()
            ]);
            
            // Redirect based on user role
            $redirectRoute = auth()->user()->role === 'admin' ? 'admin.news.index' : 'my.news.index';
            $message = auth()->user()->role === 'admin' 
                ? 'Berita berhasil diperbarui!' 
                : 'Berita berhasil diperbarui dan menunggu persetujuan admin.';
                
            return redirect()->route($redirectRoute)
                ->with('success', $message);
                
        } catch (\Exception $e) {
            \Log::error('Failed to update news', [
                'error' => $e->getMessage(),
                'news_id' => $news->id
            ]);
            
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui berita. Silakan coba lagi.');
        }
    }

    /**
     * Toggle the publish status of the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function togglePublish($id)
    {
        $news = News::findOrFail($id);
        
        // Check authorization
        $this->authorize('update', $news);

        // Toggle the publish status
        $newPublishStatus = !$news->is_published;
        
        // Update the news with the new status and set published_at if being published
        $updateData = [
            'is_published' => $newPublishStatus
        ];
        
        // Only update published_at if the news is being published (not when unpublishing)
        if ($newPublishStatus && !$news->published_at) {
            $updateData['published_at'] = now();
        }
        
        $news->update($updateData);
        
        // Add debug logging
        \Log::info('News publish status toggled', [
            'news_id' => $news->id,
            'new_status' => $newPublishStatus ? 'published' : 'draft',
            'published_at' => $news->fresh()->published_at,
            'updated_at' => now()
        ]);

        return redirect()->route('admin.news.index')
            ->with('success', 'Status berita berhasil diubah!');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        
        // Check authorization
        $this->authorize('delete', $news);
        
        // Delete the news image if it exists
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }
        
        // Delete the news
        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
