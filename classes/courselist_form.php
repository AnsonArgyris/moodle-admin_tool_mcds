<?php
/**
 * TeachCenter2.0
 * Sync Layer Plugin for Moodle
 *
 * form for synclayer_course_mapping table
 *
 * @package     synclayer
 * @author      Christian Ortner
 */

namespace tool_mcds;

//moodleform is defined in formslib.php
require_once("$CFG->libdir/formslib.php");

class courselist_form extends \moodleform
{
    //Add elements to form
    public function definition()
    {
        $mform = $this->_form;

        $courses = json_decode($this->_customdata['courses']);

        foreach ($courses as $course) {
            $mform->addElement('advcheckbox', $course->id, '',
                               $course->id . ', ' . $course->idnumber . ', ' . $course->shortname . ', ' . $course->fullname,
                               ['group' => 1], [0, 1]);
        }

        $this->add_action_buttons();
    }

    //Custom validation should be added here
    function validation($data, $files)
    {
        //TODO
        return [];
    }
}