<?php

namespace Aw\Test\Api\Data;

interface NewsInterface
{
    /**
     * String constants for property names
     */
    const NEWS_ID = "news_id";
    const TITLE = "title";
    const STATUS = "status";
    const DATE = "date";

    /**
     * Getter for NewsId.
     *
     * @return int|null
     */
    public function getNewsId(): ?int;

    /**
     * Setter for NewsId.
     *
     * @param int|null $newsId
     *
     * @return void
     */
    public function setNewsId(?int $newsId): void;

    /**
     * Getter for Title.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * Setter for Title.
     *
     * @param string $title
     *
     * @return void
     */
    public function setTitle(string $title): void;
    /**
     * Getter for Title.
     *
     * @return bool
     */
    public function getStatus(): bool;

    /**
     * Setter for Status.
     *
     * @param bool $status
     *
     * @return void
     */
    public function setStatus(bool $status): void;

    /**
     * Getter for Date.
     *
     * @return string
     */
    public function getDate(): string;

    /**
     * Setter for Date.
     *
     * @param string $date
     *
     * @return void
     */
    public function setDate(string $date): void;
}
