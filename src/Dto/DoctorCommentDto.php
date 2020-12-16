<?php

namespace DocDoc\RgsApiClient\Dto;

use JsonSerializable;

/**
 * Комментарий доктора
 */
class DoctorCommentDto  implements JsonSerializable
{
    /** @var string */
    private $doctorComment;

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * @return string
     */
    public function getDoctorComment(): string
    {
        return $this->doctorComment;
    }

    /**
     * @param string $doctorComment
     */
    public function setDoctorComment(string $doctorComment): void
    {
        $this->doctorComment = $doctorComment;
    }
}
