<?php

namespace App\Http\Controllers\Request\Admin\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Api\MainApi as API;

use App\Article;
use App\ArticleCategory;
use App\ArticleContent;
use App\Category;
use App\Language;
use App\ArticleArchive;
use App\ArticlePermission;
use App\UserRole;
use App\User;
use App\Role;

class ArticleRequestController extends Controller
{

  protected $messages = [
    'required' => ':attribute alanı gereklidir, lütfen doldurunuz'
  ];

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getArticles()
  {
    $user = API::authUser();

    if($roles = $user->rolesByRoleId("1")->first())

      return response()->json(
                Article::with(['categories', 'contents', 'author' => function($query) {
                           $query->select('user_id', 'name');
                         }])->orderBy('created_at', 'DESC')->paginate(15)
             , 200);



    return response()->json(
                $user->articles()
                ->with(['categories', 'contents', 'author' => function($query) {$query->select('user_id', 'name');}])
                ->orderBy('created_at', 'DESC')
                ->paginate(15)
          , 200);
  }

  public function getTrash()
  {
    $user = API::authUser();

    $trashedArticle = API::trashedArticle($user);

    return response()->json($trashedArticle, 200);
  }

  public function getProperties()
  {
    $language = API::languages();

    $i = 0; $languages = [];

    foreach ($language as $key => $value) {

      $languages[$i]['id'] = $value->id;
      $languages[$i]['name'] = $value->name;
      $languages[$i]['slug'] = $value->slug;

      $i++;
    }

    $category = API::categories();

    $k = 0; $categories = [];

    foreach ($category as $key => $value) {

      $categories[$k]['id'] = $value->id;
      $categories[$k]['name'] = $value->name;
      $categories[$k]['description'] = $value->description;

      $k++;
    }

    $data['languages'] = $languages;
    $data['categories'] = $categories;

    return response()->json($data, 200);
  }

  public function deleteArticle($article_id)
  {
    $messages = $this->messages;

    $user = API::authUser();

    if(!$article = Article::find($article_id))
      return API::responseApi([
        'header' => 'Hata',
        'message' => 'Makaleyi bulamadık!',
        'state' => 'error'
      ]);

    if(!self::hasPermission($article_id, $user->user_id))
      return API::responseApi([
        'header' => 'Yetkisiz İşlem',
        'message' => 'Bu makaleyi düzenleme hakkınız yok!',
        'state' => 'error'
      ]);

    $article->contents()->delete();

    $article->article_categories()->delete();

    $article->delete();

    return API::responseApi([
            'header' => 'İşlem Başarılı',
            'message' => 'Makaleniz çöpe taşındı!',
            'state' => 'success'
          ], 200);
  }

  public function postArticle(Request $request)
  {
    $messages = $this->messages;

    $this->validate($request, [
      'title' => 'required',
      'sub_title' => 'required',
      'body' => 'required',
      'keywords' => 'required',
      'published' => 'required',
      'language' => 'required',
      'category' => 'required',
      'image' => 'required',
      'slug' => 'required'
    ], $messages);

    $user = API::authUser();

    $article = Article::create([
      'slug' => $request->input('slug'),
      'author' => $user->user_id,
      'image' => $request->input('image')
    ]);

    $request_categories = json_decode($request->input('category'));

    foreach ($request_categories as $key => $value) {
      ArticleCategory::create([
        'article_id' => $article->id,
        'category_id' => $value
      ]);
    }

    $article_language = ArticleContent::create([
      'article_id' => $article->id,
      'title' => $request->input('title'),
      'language' => $request->input('language'),
      'body' => $request->input('body'),
      'sub_title' => $request->input('sub_title'),
      'keywords' => $request->input('keywords'),
      'published' => ($request->input('published') == "1")? 1: 0,
      'situation' => 1,
      'version' => 1
    ]);

    $permission = ArticlePermission::create([
      'article_id' => $article->id,
      'user_id' => $user->user_id
    ]);

    return API::responseApi([
            'header' => 'İşlem Başarılı',
            'message' => 'Makaleniniz başarılı bir şekilde kaydedildi',
            'state' => 'success'
          ], 200);
  }

  public function postContent(Request $request)
  {
    $messages = $this->messages;

    $this->validate($request, [
      'id' => 'required',
      'title' => 'required',
      'sub_title' => 'required',
      'body' => 'required',
      'keywords' => 'required',
      'published' => 'required',
      'language' => 'required',
      //'category' => 'required',
      //'file' => 'file|required'
    ], $messages);

    $user = API::authUser();

    if(!self::hasPermission($request->input('id'), $user->user_id))
      return API::responseApi([
        'header' => 'Yetkisiz İşlem',
        'message' => 'Bu makaleyi düzenleme hakkınız yok!',
        'state' => 'error'
      ]);

    if ($article = ArticleContent::where('article_id', $request->input('id'))->where('language', $request->input('language'))->first()) {
      return API::responseApi([
        'header' => 'Hata',
        'message' => 'Bu dile ait bir girdi var!',
        'state' => 'error'
      ]);
    }


    $article_language = ArticleContent::create([
      'article_id' => $request->input('id'),
      'title' => $request->input('title'),
      'language' => $request->input('language'),
      'body' => $request->input('body'),
      'sub_title' => $request->input('sub_title'),
      'keywords' => $request->input('keywords'),
      'published' => ($request->input('published') == "1")? 1: 0,
      'situation' => 1,
      'image_url' => '41234e11234214.jpg',
      'version' => 1
    ]);

    return API::responseApi([
            'header' => 'İşlem Başarılı',
            'message' => 'Makaleninize başarılı bir şekilde dil eklendi',
            'state' => 'success'
          ], 200);
  }

  public function putContent(Request $request)
  {
    $messages = $this->messages;

    $this->validate($request, [
      'id' => 'required',
      'title' => 'required',
      'sub_title' => 'required',
      'body' => 'required',
      'keywords' => 'required',
      'published' => 'required',
      'language' => 'required',
    ], $messages);

    $user = API::authUser();

    if(!self::hasPermission($request->input('id'), $user->user_id))
      return API::responseApi([
              'header' => 'Yetkisiz İşlem',
              'message' => 'Bu makaleyi düzenleme hakkınız yok!',
              'state' => 'error'
            ]);

    $article = Article::find($request->input('id'));

    $article_content = $article->contentByLanguage($request->input('language'))->first();

    $response = "Makaleniz başarı ile güncellendi!";

    if (
      $article_content->title != $request->input('title') ||
      $article_content->sub_title != $request->input('sub_title') ||
      $article_content->body != $request->input('body') ||
      $article_content->keywords != $request->input('keywords')
    ) {
      $article_old_save = ArticleArchive::create([
        'article_id' => $article_content->article_id,
        'sub_title' => $article_content->sub_title,
        'title' => $article_content->title,
        'title' => $article_content->title,
        'language' => $article_content->language,
        'body' => $article_content->body,
        'keywords' => $article_content->keywords,
        'published' => $article_content->published,
        'situation' => $article_content->situation,
        'version' => $article_content->version,
      ]);

      $response = "Makaleniz başarı ile güncellendi, eskisinin kopyası saklandı!";

      $article_content->version = $article_content->version + 1;
    }

    $article_content->title = $request->input('title');
    $article_content->sub_title = $request->input('sub_title');
    $article_content->body = $request->input('body');
    $article_content->keywords = $request->input('keywords');
    $article_content->published = ($request->input('published') == "1")? 1: 0;

    $article_content->save();

    return API::responseApi([
      'header' => 'İşlem Başarılı',
      'message' => $response,
      'state' => 'success'
    ], 200);
  }

  public function putArticle(Request $request)
  {
    $messages = $this->messages;

    $user = API::authUser();

    $this->validate($request, [
      'id' => 'required',
      'slug' => 'required',
      'categories' => 'required',
      'image' => 'required'
    ]);

    if(!self::hasPermission($request->input('id'), $user->user_id))
      return API::responseApi([
              'header' => 'Yetkisiz İşlem',
              'message' => 'Bu makaleyi düzenleme hakkınız yok!',
              'state' => 'error'
            ]);

    $article = Article::find($request->input('id'));

    $request_categories = $request->input('categories');

    ArticleCategory::where('article_id', $request->input('id'))->forceDelete();

    foreach ($request_categories as $key => $value) {
      ArticleCategory::create([
        'article_id' => $request->input('id'),
        'category_id' => $value
      ]);
    }

    $article->slug = $request->input('slug');

    $article->image = $request->input('image');

    $article->save();

    return API::responseApi([
      'header' => 'İşlem Başarılı',
      'message' => 'Değişiklikler kaydedildi!',
      'state' => 'success'
    ], 200);
  }

  public function postRestore(Request $request)
  {
    $this->validate($request, [
      'id' => 'required'
    ]);

    $user = API::authUser();

    if(!$article = Article::onlyTrashed()->find($request->input('id')))
      return API::responseApi([
              'header' => 'Hata',
              'message' => 'Aradığınız Makaleyi Bulamadık!',
              'state' => 'error'
            ]);

    if (!self::hasPermission($request->input('id'), $user->user_id))
      return API::responseApi([
              'header' => 'Yetkisiz İşlem',
              'message' => 'Bu makaleyi düzenleme hakkınız yok!',
              'state' => 'error'
            ]);

    $article->trashed_contents()->restore();
    $article->trashed_categories()->restore();
    $article->restore();

    return API::responseApi([
      'header' => 'İşlem Başarılı', 'message' => 'Başarılı bir şekilde geri yüklendi', 'state' => 'success'
    ], 200);
  }

  public function postForceDelete(Request $request)
  {
    $this->validate($request, [
      'id' => 'required',
      'complete' => 'required'
    ]);

    $user = API::authUser();
    $article_id = $request->input('id');
    $complete = $request->input('complete');

    if (!self::hasPermission($request->input('id'), $user->user_id))
      return API::responseApi([
              'header' => 'Yetkisiz İşlem',
              'message' => 'Bu makaleyi düzenleme hakkınız yok!',
              'state' => 'error'
            ]);

    $article = Article::onlyTrashed()->find($article_id);

    $article_contents = $article->trashed_contents()->forceDelete();

    $article_categories = $article->trashed_categories()->forceDelete();


    if ($complete == 1)
      $article->olds()->forceDelete();

    $article->forceDelete();

    return API::responseApi([
             'header' => 'İşlem Başarılı', 'message' => 'Makale veritabanından kaldırıldı', 'state' => 'success'
           ], 200);
  }

  public function getPermission($article_id)
  {
    $user = API::authUser();

    $article = Article::find($article_id);

    $article_permission = $article->users;

    if ($article->author != $user->user_id && !$role = $user->rolesByRoleId(1)->first())
      return API::responseApi([
        'header' => 'Yetkisiz İşlem', 'message' => 'Bu makaleyi düzenlemeye yetkiniz yok!', 'state' => 'error'
      ]);

    $data = ['users' => [], 'permission' => []]; $i = 0;

    $roles = Role::where('id', '>', 1)->get();

    foreach ($roles as $key => $value) {
      $temp_data = $value->users;

      foreach ($temp_data as $key => $value) {
        if ($user->user_id == $value->user_id) continue;

        $data['users'][$i]['name'] = $value->name;
        $data['users'][$i]['user_id'] = $value->user_id;
        $i++;
      }
    }

    $i = 0;

    foreach ($article_permission as $key => $value) {
      if ($user->user_id == $value->user_id) continue;

      $data['permission'][$i]['user_id'] = $value->user_id;
      $data['permission'][$i]['name'] = $value->name;
      $i++;
    }

    return response()->json($data, 200);
  }

  public function putPermission($article_id, Request $request)
  {
    $this->validate($request, [
      'have_permission' => 'present|array',
      'not_have_permission' => 'present|array'
    ]);

    $have_permissionn = $request->input('have_permission');
    $not_have_permission = $request->input('not_have_permission');

    $user = API::authUser();

    $article = Article::find($article_id);

    $article_permission = $article->users;

    if ($article->author != $user->user_id && !$role = $user->rolesByRoleId(1)->first())
      return API::responseApi([
        'header' => 'Yetkisiz İşlem', 'message' => 'Bu makaleyi düzenlemeye yetkiniz yok!', 'state' => 'error'
      ]);

    foreach ($have_permissionn as $key => $value) {
      if ($temp = UserRole::where('user_id', $value['user_id'])->where('role_id', 1)->first()) continue;

      ArticlePermission::firstOrCreate(
          ['article_id' => $article_id, 'user_id' => $value['user_id']], ['article_id' => $article_id, 'user_id' => $value['user_id']]
        );
    }

    foreach ($not_have_permission as $key => $value) {
      if($value['user_id'] == $user->user_id) continue;

      if ($temp = UserRole::where('user_id', $value['user_id'])->where('role_id', 1)->first()) continue;

      if ($exist = ArticlePermission::where('article_id', $article_id)->where('user_id', $value['user_id'])->first())
        $exist->delete();
    }

    return API::responseApi([
      'header' => 'İşlem Başarılı', 'message' => 'İzinler başarı ile güncellendi!', 'state' => 'success'
    ], 200);
  }
  /*
  * Check if user can change the Article
  *
  * @param article_id: article id | int, user: auth user | object
  *
  * @return boolean
  */
  protected static function hasPermission($article_id, $user_id)
  {
    if ($permission = ArticlePermission::where('article_id', $article_id)->where('user_id', $user_id)->first())
      return true;


    if ($role = UserRole::where('user_id', $user_id)->where('role_id', 1)->first())
      return true;

    return false;
  }
}
