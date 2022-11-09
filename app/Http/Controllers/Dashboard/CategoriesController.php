<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();

        // SELECT a.* , b.name as parent_name FROM categories as a
        // LEFT JOIN categories as b on b.id = a.parent_id

        $categories = Category::with('parent')
        /*leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ]) */
            //select('categories.*')
            //->selectRaw( ('SELECT COUNT(*) From products where category_id = categories.id AND status = active ) as products_count') // نفسها نفس عمل ال withCount('products)
            ->withCount([
                'products' => function($query){
                    $query->where('status' , '=' , 'active');
                }
                ])
            ->filter($request->query())
            ->paginate();
        //return Collection object not array  لكن بقدر اتعامل معاه كمصفوفة عادي $categories[0]

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
        // Mass Assignment
        $request->merge([
            'slug' => Str::slug($request->name),
        ]);
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);
        $category = Category::create($data);

        // PRG post redirect get
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Added Successfully !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category) //model Bindeing لازم كون اسم الفاريبل نفس الاسم الي مررناه بالراوت ليست
    {
         return view('dashboard.categories.show',[
            'category' => $category
         ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')->with('info', 'Record Not Found !');
        }
        //وبدنا يرجع الكاتيقوري الي ملوش اب يعني بيرنت ايدي اله بيساوي نل  // نستثني ابناءه كمان لانه بنفعش يكون ابن لابناءه// و بدنا نستثني الكاتيقوري الحالي  لانو بنفعش يكون اب لنفسه
        // select * from categories where id <> $id AND ( $parent_id is NULL OR  $parent_id <> $id )
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(Category::rules($id));
        $category =  Category::findOrFail($id);

        $old_image = $category->image;

        $data = $request->except('image');

        $new_image = $this->uploadImage($request);
        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category) //Model Binding مشروح في درس ال softDelete
    {
        //    $category= Category::findOrFail($id);
        //    $category->delete();
        // Category::where('id' , '=' , $id)->delete();
        //  Category::destroy($id);

        // $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('dashboard.categories.index')->with('success', 'deleted successflly');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }


    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }


    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.archi')->with('success', 'Category Restored !');
    }


    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        $category->forceDelete();
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category Deleted Forever !');
    }
}
