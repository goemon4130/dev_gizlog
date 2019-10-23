<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'tag_category_id', 'title', 'content'];

    /**
     * userテーブルのリレーション
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * タグカテゴリテーブルのリレーション
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagCategory()
    {
        return $this->belongsTo(TagCategory::class);
    }

    /**
     * コメントテーブルとのリレーション
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * ユーザIDで質問を検索するローカルスコープ
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActiveUser($query, $request)
    {
        if (isset($request['user_id'])) {
            return $query->where('user_id', $request['user_id']);
        }
    }

    /**
     * 検索ワードで質問を検索するローカルスコープ
     * 
     * @param \Illuminate\Database\Eloquent\Builder $queery
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchTitle($query, $request)
    {
        if (isset($request['search_word'])) {
            return $query->where('title', 'like', '%'. $request['search_word']. '%');
        }
    }

    /**
     * タグカテゴリで質問を検索するローカルスコープ
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchTagCategory($query, $request)
    {
        if (isset($request['select_tag_category_id'])) {
            return $query->where('tag_category_id', $request['select_tag_category_id']);
        }
    }

    /**
     * 質問の一覧を取得する
     * 
     * @param array $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getQuestion($request)
    {
        return $this->activeUser($request)->searchTitle($request)->searchTagCategory($request)->with(['user', 'tagCategory', 'comments'])->latest()->get();
    }
}
