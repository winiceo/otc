<?php

namespace Genv\Otc\Helpers;

use Genv\Otc\Modelss\Tag;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasTags
{
    /**
     * @return \Genv\Otc\Modelss\Tag[]
     */
    public function tags()
    {
        return $this->tagsRelation;
    }

    /**
     * @param \Genv\Otc\Modelss\Tag[]|int[] $tags
     */
    public function syncTags(array $tags)
    {
        $this->save();
        $this->tagsRelation()->sync($tags);
    }

    public function removeTags()
    {
        $this->tagsRelation()->detach();
    }

    public function tagsRelation(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable')->withTimestamps();
    }
}
