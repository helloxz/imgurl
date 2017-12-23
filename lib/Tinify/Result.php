<?php

namespace Tinify;

class Result extends ResultMeta {
    protected $data;

    public function __construct($meta, $data) {
        $this->meta = $meta;
        $this->data = $data;
    }

    public function data() {
        return $this->data;
    }

    public function toBuffer() {
        return $this->data;
    }

    public function toFile($path) {
        return file_put_contents($path, $this->toBuffer());
    }

    public function size() {
        return intval($this->meta["content-length"]);
    }

    public function mediaType() {
        return $this->meta["content-type"];
    }

    public function contentType() {
        return $this->mediaType();
    }
}
