<?php

namespace block_usercoursestatistics\output;
defined('MOODLE_INTERNAL') || die;

use plugin_renderer_base;

class renderer extends plugin_renderer_base {
    public function render_main(main $main) {
        return $this->render_from_template('block_usercoursestatistics/main', $main->export_for_template($this));
    }
}
