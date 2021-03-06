<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    //TODO:show all
    public function index(){
        $tags = Tag::paginate(env('PAGINATION_COUNT'));
        return view('admin.tags.tags')->with([
            'tags' => $tags,
            'showLinks' => true
        ]);
    }
    //TODO:check if tag is already exist
    private function checkTagName($tagName){
        $tags = Tag::where(
            'tag','=',$tagName
        )->get();
        if(count($tags) > 0){
            Session::flash('message','tag (' .$tagName. ') is already exist');
            return true;
        }else{
            return false;
        }
    }
    //TODO:store new
    public function store(Request $request){
        $request->validate([
            'tag_name' => 'required'
        ]);

        $tagName = $request->input('tag_name');
        if($this->checkTagName($tagName)){
            return back();
        }
        $newTag = new Tag();
        $newTag->tag = $tagName;
        $newTag->save();
        Session::flash('message','tag (' . $tagName . ') has been added');
        return back();
    }
    //TODO:delete
    public function delete(Request $request){
        $tagID = $request->input('tag_id');
        if(is_null($tagID) || empty($tagID)){
            Session::flash('message','tag ID is required');
            return back();
        }
        Tag::destroy($tagID);
        Session::flash('message','this tag has been deleted');
        return back();
    }
    //TODO:update
    public function update(Request $request){
        $request->validate([
            'tag_id' => 'required',
            'tag_name' => 'required'
        ]);
        $tagId = intval($request->input('tag_id'));
        $tagName = $request->input('tag_name');
        if ($this->checkTagName($tagName)){
            return back();
        }
        $tag = Tag::find($tagId);
        $tag->tag = $tagName;
        $tag->save();
        Session::flash('message','tag (' .$tagName. ') has been updated ');
        return back();
    }
    //TODO:search
    public function search(Request $request){
        $request->validate([
            'tag_search' => 'required'
        ]);
        $tagTerm = $request->input('tag-search');
        $result = Tag::where(
            'tag' , 'like' , '%' .$tagTerm. '%'
        )->get();
        if(count($result) > 0){
            return view('admin.tags.tags')->with([
                'tags' => $result,
                'showLinks' => false
            ]);
        }
        Session::flash('message','this tag is not exist');
        return redirect()->route('tags');

    }
}
