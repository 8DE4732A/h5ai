<?php

class Upload {
    private $context;
    private $request;
    private $setup;

    public function __construct($context) {
        $this->context = $context;
        $this->request = $context->get_request();
        $this->setup = $context->get_setup();
    }

    public function apply() {
        $file = $this->setup->get_file();
        $save_path = $this->setup->get('ROOT_PATH') . $this->setup->get('REQUEST_HREF') . basename($file['fileToUpload']['name']);
        move_uploaded_file($file['fileToUpload']['tmp_name'], $save_path);
        $public_href = $this->setup->get('PUBLIC_HREF');
        $x_head_tags = $this->context->get_x_head_html();
        $fallback_mode = $this->context->is_fallback_mode();
        $fallback_html = (new Fallback($this->context))->get_html();
        require __DIR__ . '/../pages/index.php';
    }
}