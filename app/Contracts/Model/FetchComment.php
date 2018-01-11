<?php



namespace Genv\Otc\Contracts\Model;

interface FetchComment
{
    /**
     * Get comment centent.
     *
     * @return string
     */
    public function getCommentContentAttribute(): string;

    /**
     * Get target source display title.
     *
     * @return string
     */
    public function getTargetTitleAttribute(): string;

    /**
     * Get target source image file with ID.
     *
     * @return int
     */
    public function getTargetImageAttribute(): int;

    /**
     * Get target source id.
     *
     * @return int
     */
    public function getTargetIdAttribute(): int;
}
