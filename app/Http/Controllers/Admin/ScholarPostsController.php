<?php

namespace App\Http\Controllers\Admin;

use App\ReportCard;
use App\User;
use App\ScholarPost;
use App\Services\ScholarPostsService;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use App\Services\AwsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScholarPostsController extends Controller
{
    protected $scholarPostsService, $awsService;
    public function __construct(ScholarPostsService $scholarPostsService, AwsService $awsService){
        $this->scholarPostsService = $scholarPostsService;
        $this->awsService = $awsService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->scholarPostsService->index($request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = User::find($request->route('id'));
        return view('admin.scholar_posts.create')->withUser($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->user_id);
        $scholarPost = new ScholarPost;
        $this->validate($request, array(
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'required'
        ));
        $scholarPost->title = $request->input('title');
        $scholarPost->body = $request->input('body');
        $scholarPost->user_id = $request->user_id;
        $filenamewithextension = $request->file('cover_image')->getClientOriginalName(); 	//get filename with extension
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME); //get filename without extension
        $extension = $request->file('cover_image')->getClientOriginalExtension(); //get file extension
        $filenametostore = 'Users/Scholarposts/'.$filename.'_'.time().'.'.$extension;	//filename to store
        Storage::disk('s3')->put($filenametostore, fopen($request->file('cover_image'), 'r+'), 'public');	//Upload File to s3
        $report_url = "https://s3-ap-southeast-1.amazonaws.com/advoedu-testing/".$filenametostore;
        $scholarPost->cover_image = $report_url;
        $scholarPost->save();
        return redirect()->action('Admin\UsersController@show', [$user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = ScholarPost::find($id);
        return view('admin.scholar_posts.show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = ScholarPost::find($id);
        return view('admin.scholar_posts.edit')->withPost($post);
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
        $post = ScholarPost::find($id);
        $this->validate($request, array(
            'title' => 'required',
            'body' => 'required',
        ));
        $post->update($request->all());
        $post->save();
        $this->awsService->removeUpload($post, $post->cover_image, 'Users/Scholarposts/');
        $this->awsService->uploadProfileImage($request, $post, 'cover_image_', 'Users/Scholarposts/');

        return view('admin.scholar_posts.show')->withPost($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = ScholarPost::find($id);
        $user = User::find($post->user_id);
        $post->delete();
        return redirect()->action('Admin\UsersController@show', [$user]);
    }
}
