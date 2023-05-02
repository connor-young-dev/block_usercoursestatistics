<?php

defined('MOODLE_INTERNAL') || die();

class block_usercoursestatistics extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_usercoursestatistics');
    }

    public function has_config() {
        return true;
    }

    public function get_content() {
        if (isset($this->content)) {
            return $this->content;
        }

        $renderable = new block_usercoursestatistics\output\main();
        $renderer = $this->page->get_renderer('block_usercoursestatistics');

        $this->content = new stdClass();
        $this->content->text = $renderer->render($renderable);
        $this->content->footer = '';

        return $this->content;
    }
}
