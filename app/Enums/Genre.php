<?php

namespace App\Enums;

class Genre
{
    const NONE = "none";
    const GAMING = 'gaming';
    const ART = 'art';
    const SCIENCE = 'science';
    const FUNNY = 'funny';
    const MOVIES = 'movies';
    const POLITICS = 'politics';

    const TYPES = [
        self::NONE,
        self::GAMING,
        self::ART,
        self::SCIENCE,
        self::FUNNY,
        self::MOVIES,
        self::POLITICS
    ];
}