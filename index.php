<?php
// This file is part of Book module for Moodle - http://moodle.org/
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
 * This page lists all the instances of book in a particular course
 *
 * @package    mod
 * @subpackage book
 * @copyright  2004-2011 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/mod/book/locallib.php');

$id = required_param('id', PARAM_INT);           // Course Module ID

$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);

unset($id);

require_course_login($course, true);
$PAGE->set_pagelayout('incourse');

/// Get all required strings
$strbooks        = get_string('modulenameplural', 'mod_book');
$strbook         = get_string('modulename', 'mod_book');
$strsectionname  = get_string('sectionname', 'format_'.$course->format);
$strname         = get_string('name');
$strintro        = get_string('moduleintro');
$strlastmodified = get_string('lastmodified');

$PAGE->set_url('/mod/book/index.php', array('id' => $course->id));
$PAGE->set_title($course->shortname.': '.$strbooks);
$PAGE->set_heading($course->fullname);
$PAGE->navbar->add($strbooks);
echo $OUTPUT->header();

add_to_log($course->id, 'book', 'view all', 'index.php?id='.$course->id, '');

/// Get all the appropriate data
if (!$books = get_all_instances_in_course('book', $course)) {
    notice(get_string('thereareno', 'moodle', $strbooks), "$CFG->wwwroot/course/view.php?id=$course->id");
    die;
}

$usesections = course_format_uses_sections($course->format);
if ($usesections) {
    $sections = get_all_sections($course->id);
}

$table = new html_table();
$table->attributes['class'] = 'generaltable mod_index';

if ($usesections) {
    $table->head  = array ($strsectionname, $strname, $strintro);
    $table->align = array ('center', 'left', 'left');
} else {
    $table->head  = array ($strlastmodified, $strname, $strintro);
    $table->align = array ('left', 'left', 'left');
}

$modinfo = get_fast_modinfo($course);
$currentsection = '';
foreach ($books as $book) {
    $cm = $modinfo->cms[$book->coursemodule];
    if ($usesections) {
        $printsection = '';
        if ($book->section !== $currentsection) {
            if ($book->section) {
                $printsection = get_section_name($course, $sections[$book->section]);
            }
            if ($currentsection !== '') {
                $table->data[] = 'hr';
            }
            $currentsection = $book->section;
        }
    } else {
        $printsection = '<span class="smallinfo">'.userdate($book->timemodified)."</span>";
    }

    $class = $book->visible ? '' : 'class="dimmed"'; // hidden modules are dimmed

    $table->data[] = array (
        $printsection,
        "<a $class href=\"view.php?id=$cm->id\">".format_string($book->name)."</a>",
        format_module_intro('book', $book, $cm->id));
}

echo html_writer::table($table);

echo $OUTPUT->footer();
