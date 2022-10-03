<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // Add [title] to fillable property to allow mass assignment on [App\Models\Listing].
    protected $fillable=['title','logo','company','location','tags','website','email','description','user_id'];

    public function scopeFilter($query, array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags','like','%'. request('tag').'%');

        }
        if($filters['search'] ?? false){
            $query->where('title','like','%'. request('search').'%')
            ->orWhere('location','like','%'. request('search').'%')
            ->orWhere('tags','like','%'. request('search').'%')
            ->orWhere('company','like','%'. request('search').'%');

        }


    }
    // Relationship to User
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
