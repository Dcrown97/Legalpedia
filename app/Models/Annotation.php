<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id', 'note_id', 'content_id', 'content_type', 'content', 'comment', 'replies', 'text_target', 'tags', 'display', 'resource_type',
    'featured'
    ];
    protected $appends = ['user', 'resourceId'];
    


    protected $table = 'annotations';

    // public function users()
    // {
    //     return $this->hasOne(User::class, 'id', 'user_id');
    // }

    public function getUserAttribute () {
        $user = User::find($this->user_id);
        return $user->name;
    }
    public function getResourceIdAttribute () {
        $judgement_summary = JudgementSummary::where('suit_no', 'LIKE', '%' . $this->content_id . '%')->first();
        $fed = LawOfFederation::where('id', $this->content_id)->first();
        $rule = Rule::where('id', $this->content_id)->first();
        $state_rule = Rule::where('id', $this->content_id)->first();
        $form = Rule::where('id', $this->content_id)->first();
        $article = Rule::where('id', $this->content_id)->first();
        if ($this->resource_type == 'judgement'){
            return $judgement_summary->id;
        }elseif($this->resource_type == 'fed'){
            return $fed->id;
        }elseif($this->resource_type == 'rule'){
            return $rule->id;
        }elseif($this->resource_type == 'state-rule'){
            return $state_rule->id;
        }elseif($this->resource_type == 'form'){
            return $form->id;
        }elseif($this->resource_type == 'article'){
            return $article->id;
        }
    }
}
