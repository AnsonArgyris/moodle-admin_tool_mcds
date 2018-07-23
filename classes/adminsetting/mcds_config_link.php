<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Admin setting for auto configuration.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace tool_mcds\adminsetting;

defined('MOODLE_INTERNAL') || die();

/**
 * No setting - just heading and text.
 *
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mcds_config_link extends \admin_setting_heading {

    /**
     * @var \moodle_url
     */
    public $link;

    /**
     * ally_config_link constructor.
     * @param string $name
     * @param string $visiblename
     * @param \moodle_url $link
     */
    public function __construct($name, $visiblename, \moodle_url $link) {
        $this->nosave = true;
        $this->link = $link;
        parent::__construct($name, $visiblename, '');
    }

    /**
     * Returns an HTML string
     * @return string Returns an HTML string
     */
    public function output_html($data, $query = '') {
        $context = (object) [
            'href' => $this->link,
            'linktitle' => $this->visiblename
        ];
        return '<div class="mcds-config-row btn"><a class="btn btn-default" href="'.$context->href.'">'.
               $context->linktitle.'</a></div>';
    }
}
