<?php

namespace IntoTheSource\Slugable;

trait Slugable
{
    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = $this->generateSlug($value);
    }

    /**
     * Increment a slug's suffix.
     *
     * @param  string $slug
     *
     * @return string
     */
    protected function incrementSlug($slug)
    {
        $found = static::where($this->getSlugableKey(), $this->{$this->getSlugableKey()})
                       ->where('id', '!=', $this->id)
                       ->latest('id')
                       ->first();

        if (!$found) {
            return $slug;
        }

        if ($this->slugContainsDigit($found) && !$this->firstSlugifyVersion($found)) {
            return preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1] + 1;
            }, $found->slug);
        }

        return $slug . '-2';
    }

    /**
     * Check if the 'key' is the first slugify version of that 'key'.
     *
     * @param \Illuminate\Database\Eloquent\Model $found
     *
     * @return bool
     */
    protected function firstSlugifyVersion($found)
    {
        return $found->slug === str_slug($found->{$this->getSlugableKey()});
    }

    /**
     * Check if the given slug of the found record contains a digit at the end,
     * that can indicate that it needs to add +1 to that digit.
     *
     * @param \Illuminate\Database\Eloquent\Model $found
     *
     * @return bool
     */
    protected function slugContainsDigit($found)
    {
        return is_numeric(substr($found->slug, -1));
    }

    /**
     * Returns the column that needs to be made into a slug
     *
     * @return string
     */
    protected function getSlugableKey()
    {
        return $this->slugableColumn ?: 'title';
    }

    /**
     * Generate a slug.
     *
     * @param $value
     *
     * @return string
     */
    protected function generateSlug($value)
    {
        if (static::whereSlug($slug = str_slug($value))->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        return $slug;
    }
}