<?php

namespace Tinify;

class ResultMeta {
    protected $meta;

    public function __construct($meta) {
        $this->meta = $meta;
    }

    public function width() {
        return intval($this->meta["image-width"]);
    }

    public function height() {
        return intval($this->meta["image-height"]);
    }

    public function location() {
        return isset($this->meta["location"]) ? $this->meta["location"] : null;
    }
}
