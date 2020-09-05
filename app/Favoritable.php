<?php


    namespace App;


    trait Favoritable
    {

        public function getFavoritesCountAttribute()
        {
            return $this->favorites->count();
        }

        public function isFavorited()
        {
            return !! $this->favorites->where('user_id', auth()->id())->count();
        }

        public function getIsFavoritedAttribute() // $reply->isFavorited
        {
            return $this->isFavorited();
        }

        public function favorite()
        {
            $attributes = ['user_id' => auth()->id()];

            if (! $this->favorites()->where($attributes)->exists()) {
                return $this->favorites()->create($attributes);
            }
        }

        public function unfavorite()
        {
            $attributes = ['user_id' => auth()->id()];

            $this->favorites()->where($attributes)->delete();
        }

        public function favorites()
        {
            return $this->morphMany(Favorite::class, 'favorited');
        }
    }
