<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //Defining a relation job which we are creating will belong to a specific jobType() & jobCategory so we will use 'belongsTo' relation.

    use HasFactory;

    public function jobType() {
        return $this->belongsTo(JobType::class);
    } 

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function applications() {
        return $this->hasMany(JobApplication::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
 }
