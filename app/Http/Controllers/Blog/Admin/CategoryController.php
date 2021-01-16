<?php

namespace App\Http\Controllers\Blog\Admin;

// use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use App\Repositories\BlogCategoryRepository;

class CategoryController extends BaseController
{
    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    public function __construct() {
        parent::__construct();
        $this->blogCategoryRepository=app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //TODO logikan grvela repositoriayum
        // $paginator=BlogCategory::paginate(10);
        $paginator=$this->blogCategoryRepository->getAllWithPaginate(10);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item=new BlogCategory();
        // $categoryList=BlogCategory::all();
        $categoryList=$this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item','categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data=$request->input();
        if (empty($data['slug'])) {
            $data['slug']=str_slug($data['title']);
        }

        // Создать обект и добавиь в БД
        // $item=new BlogCategory($data);
        // $item->save();
        // dd($data);
        $item = (new BlogCategory())->create($data);

        if ($item) {
            return redirect()
            ->route('blog.admin.categories.edit',$item->id)
            ->with(['success'=>'успешно сохранено']);
        }else {
            return back()
            ->withErrors(['msg'=>'Ошибка сохранения'])
            ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,BlogCategoryRepository $categoryRepository)
    {
        //TODO logikan grvela repositoriayum
        // $item=BlogCategory::findOrFail($id);
        // $categoryList=BlogCategory::all();

        //TODO logikan grvela repositoriayum( erph edit($id,BlogCategoryRepository $categoryRepository))
        // $item=$categoryRepository->getEdit($id);
        // $categoryList=$categoryRepository->getForComboBox();

        $item=$this->blogCategoryRepository->getEdit($id);
        if(empty($item)){
            abort(404);
        }
        $categoryList=$this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.categories.edit', compact('item','categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        //TODO texaphoxelem BlogCategoryUpdateRequest class
        // $rules=[
        //     'title'=>'required|min:5|max:200',
        //     'slug'=>'max:200',
        //     'description'=>'string|min:3|max:200',
        //     'parent_id'=>'required|integer|exists:blog_categories,id',
        // ];

        // $validatedData=$this->validate($request,$rules);

        // $validatedData=$request->validate($rules);

        // $validator=\Validator::make($request->all(),$rules);
        // $validatedData=$validator->passes();     //return boolean ancav te voch stugum@--true ete ancav
        // $validatedData=$validator->validate();   //
        // $validatedData=$validator->valid();      // veradarcnuma validatian ancac toxer@
        // $validatedData=$validator->failed();     // veradarcnuma validatian chancac toxer@
        // $validatedData=$validator->errors();     // veradarcnuma bolor paymanner@ voroncov chi ancel
        // $validatedData=$validator->fails();      //return boolean ancav te voch stugum@--true ete chancav

        // dd($validatedData);

        $item=$this->blogCategoryRepository->getEdit($id);
        
        if (empty($item)) {
            return back()
            ->withErrors(['msg'=>'запись id=[{$id} не наыден'])
            ->withInput();
        }

        $data=$request->all();
        if (empty($data['slug'])) {
            $data['slug']=str_slug($data['title']);
        }

        $result=$item->update($data);
        // $result=$item->fill($data)->save();

        if ($result) {
            return redirect()
            ->route('blog.admin.categories.edit',$item->id)
            ->with(['success'=>'успешно сохранено']);
        }else {
            return back()
            ->withErrors(['msg'=>'Ошибка сохранения'])
            ->withInput();
        }
    }
}