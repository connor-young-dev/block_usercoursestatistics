<?php

namespace block_usercoursestatistics\output;
defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;

class main implements renderable, templatable {

    public function export_for_template(renderer_base $output) {
        return [
            'testdata' => 'It',
            'moretestdata' => 'works!'
        ];
    }
}
