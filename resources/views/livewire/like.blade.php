<div>
    @if (!Auth::guest())
        <span class="like-btn {{ $liked ? 'like-active' : '' }}" wire:click="updateLike({{ $recipe }})"></span>
    @else
        <span>Si te gusta esta receta ingresa 
            <a href="/login" class="text-green">aquí</a>
        </span>    
    @endif
    <p class="text-muted">A <span class="text-green">{{ $totalLikes }}</span> persona(s) le(s) gusta.</p>
</div>
