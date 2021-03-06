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
 * Book plugin version info
 *
 * @package    mod
 * @subpackage book
 * @copyright  2004-2011 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$module->version   = 2011032000; // The current module version (Date: YYYYMMDDXX)
$module->requires  = 2010120700; // Requires this Moodle version
$module->cron      = 0;          // Period for cron to check this module (secs)
$module->component = 'mod_book'; // Full name of the plugin (used for diagnostics)

$maturity          = 150; //MATURITY_RC
$release           = "2.0rc (20110320)"; // User-friendly version number
