<?php

namespace App\Http\Livewire;

use App\Models\Recipe;
use Livewire\Component;

class Like extends Component
{
    public $recipe;

    public $isLiked;

    public $totalLikes;

    public function mount($recipe)
    {
        $this->isLiked = $this->isLiked($recipe);
        $this->totalLikes = $this->likesCount($recipe);
    }

    public function updateLike($recipe)
    {
        auth()->user()->myLikes()->toggle($recipe);
        $this->isLiked = !$this->isLiked;
        $this->totalLikes = $this->likesCount($recipe);
    }


    public function isLiked($recipe)
    {
        if (!auth()->user()) {
            return ;
        }
        return auth()->user()->myLikes->find($recipe) ? true : false;
    }

    public function likesCount($recipe)
    {
        return Recipe::find($recipe)->likes->count();
    }

    public function render()
    {
        return view('livewire.like', [
            'liked' => $this->isLiked,
            'totalLikes' => $this->totalLikes
        ]);
    }
}
