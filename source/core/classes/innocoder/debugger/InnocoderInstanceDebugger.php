<?php
/* ***** BEGIN LICENSE BLOCK *****
 * Version: MPL 1.1
 *
 * The contents of this file are subject to the Mozilla Public License Version
 * 1.1 (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS" basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License
 * for the specific language governing rights and limitations under the
 * License.
 *
 * The Original Code is Innocoder Debugger.
 *
 * The Initial Developer of the Original Code is Alex Pagnoni.
 * Portions created by the Initial Developer are Copyright (C) 2000-2014
 * the Initial Developer. All Rights Reserved.
 *
 * Contributor(s):
 *
 * ***** END LICENSE BLOCK ***** */
require_once ('innomatic/debug/InnomaticDump.php');
/*!
 @class Debugger
 @abstract Class for Innomatic processes debugging.
 */
class InnocoderInstanceDebugger
{
    public $mPid;
    public $mDump;
    public $mPidStructure = array();
    public $mRead = false;
    public $mLogEvents = array();
    public $mCalledHooks = array();
    public $mWuiEvents = array();
    public $mExecutedQueries = array();
    public $mSessionId;
    public $mState;
    public $mInterface;
    public $mMode;
    public $mOpenedLibraries = array();
    public $mLoadedExtensions = array();
    public $mDefinedClasses = array();
    public $mDefinedFunctions = array();
    public $mIncludedFiles = array();
    public $mMemoryUsage = 0;
    public $mProfiler = array();
    public $mDbProfiler = array();
    public $mPidSize;
    public $mDbTotalLoad;
    public $mDesktopApplication;
    public function __construct ($pid)
    {
        $this->mPid = $pid;
    }
    public function checkPidFile ()
    {
        if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $this->mPid) and filesize(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $this->mPid))
            return true;
        return false;
    }
    public function isCurrentPid ()
    {
        require_once ('innomatic/core/InnomaticContainer.php');
        $innomatic = InnomaticContainer::instance('innomaticcontainer');
        if ($this->mPid == $innomatic->getPid())
            return true;
        else
            return false;
    }
    public function readPidFile ()
    {
        $result = false;
        if ($this->CheckPidFile()) {
            $this->mPidSize = filesize(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $this->mPid);
            if ($fh = @fopen(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $this->mPid, 'r')) {
                $this->mPidStructure = array();
                $this->mDump = unserialize(file_get_contents(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $this->mPid));
                if (is_object($this->mDump)) {
                    $this->mProfiler = array();
                    $this->mLogEvents = array();
                    $this->mLibraries = array();
                    $this->mSessionId = $this->mDump->sessionId;

                    switch ($this->mDump->innomatic['state']) {
                        case InnomaticContainer::STATE_SETUP:
                            $this->mState = 'SETUP';
                            break;
                        case InnomaticContainer::STATE_DEBUG:
                            $this->mState = 'DEBUG';
                            break;
                        case InnomaticContainer::STATE_PRODUCTION:
                            $this->mState = 'PRODUCTION';
                            break;
                        case InnomaticContainer::STATE_UPGRADE:
                            $this->mState = 'UPGRADE';
                            break;
                    }

                    switch ($this->mDump->innomatic['interface']) {
                        case InnomaticContainer::INTERFACE_UNKNOWN:
                            $this->mInterface = 'UNKNOWN';
                            break;
                        case InnomaticContainer::INTERFACE_CONSOLE:
                            $this->mInterface = 'CONSOLE';
                            break;
                        case InnomaticContainer::INTERFACE_WEB:
                            $this->mInterface = 'WEB';
                            break;
                        case InnomaticContainer::INTERFACE_WEBSERVICES:
                            $this->mInterface = 'WEBSERVICES';
                            break;
                        case InnomaticContainer::INTERFACE_GUI:
                            $this->mInterface = 'GUI';
                            break;
                        case InnomaticContainer::INTERFACE_EXTERNAL:
                            $this->mInterface = 'EXTERNAL';
                    }

                    switch ($this->mDump->innomatic['mode']) {
                        case InnomaticContainer::MODE_ROOT:
                            $this->mMode = 'ROOT';
                            break;
                        case InnomaticContainer::MODE_DOMAIN:
                            $this->mMode = 'DOMAIN';
                            break;
                    }
                    if (is_array($this->mDump->logs)) {
                        while (list ($log, $event_array) = each($this->mDump->logs)) {
                            while (list (, $event) = each($event_array)) {
                                $this->mLogEvents[] = $event;
                            }
                        }
                    }
                    if (is_array($this->mDump->hooks)) {
                        while (list ($hook, $functions) = each($this->mDump->hooks)) {
                            while (list (, $function) = each($functions)) {
                                $this->mCalledHooks[] = $hook . '->' . $function;
                            }
                        }
                    }
                    if (isset($this->mPidStructure['gEnv']['runtime']['disp']['wui']) and is_array($this->mPidStructure['gEnv']['runtime']['disp']['wui'])) {
                        $this->mWuiEvents = $this->mPidStructure['gEnv']['runtime']['disp']['wui'];
                    }
                    if (isset($this->mDump->dataAccess['queries']) and is_array($this->mDump->dataAccess['queries'])) {
                        while (list (, $query) = each($this->mDump->dataAccess['queries'])) {
                            $this->mExecutedQueries[] = $query;
                        }
                    }
                    $this->mMemoryUsage = $this->mDump->environment['memory_usage'];
                    $this->mMemoryPeakUsage = $this->mDump->environment['memory_peak_usage'];
                    if (is_object($this->mDump->loadTimer)) {
                        $history = $this->mDump->loadTimer->getHistory();
                        end($history);
                        $total_time = current($history);
                        reset($history);
                        $prev_time = 0;
                    } else {
                        $history = array();
                    }
                    while (list ($mark, $time) = each($history)) {
                        $perc = round(($time - $prev_time) * 100 / $total_time, 3);
                        $this->mProfiler[] = $time . ' - ' . $mark . ': ' . ($time - $prev_time) . ' (' . $perc . '%)';
                        $prev_time = $time;
                    }
                    $total_time = 0;
                    if (is_object($this->mDump->dbLoadTimer)) {
                        $history = $this->mDump->dbLoadTimer->getHistory();
                        while (list ($section, $time) = each($history)) {
                            $total_time += $time;
                        }
                        $this->mDbTotalLoad = $total_time;
                        reset($history);
                    } else {
                        $history = array();
                    }
                    while (list ($section, $time) = each($history)) {
                        $perc = round($time * 100 / $total_time, 3);
                        $this->mDbProfiler[] = $time . ' (' . $perc . '%): ' . $section;
                    }
                    if (is_array($this->mDump->environment['declared_classes'])) {
                        $this->mDefinedClasses = $this->mDump->environment['declared_classes'];
                    }
                    if (is_array($this->mDump->environment['defined_functions'])) {
                        $this->mDefinedFunctions = $this->mDump->environment['defined_functions'];
                    }
                    if (is_array($this->mDump->environment['loaded_extensions'])) {
                        $this->mLoadedExtensions = $this->mDump->environment['loaded_extensions'];
                    }
                    if (is_array($this->mDump->environment['included_files'])) {
                        $this->mIncludedFiles = $this->mDump->environment['included_files'];
                    }
                    $this->mDesktopApplication = $this->mDump->desktopApplication;
                    $result = $this->mRead = true;
                }
                fclose($fh);
            }
        }
        return $result;
    }
    public function guessApplication ()
    {
        $result = false;
        if (! $this->mRead) {
            $this->ReadPidFile();
        }
        $page = basename($this->mDump->desktopApplication);
        if (strlen($page)) {
			$guess_query_sql = 'SELECT appname,applications.id,applications.appversion AS appversion,applications.supportemail AS supportemail,applications.bugsemail AS bugsemail,applications.authoremail AS authoremail,applications.maintaineremail AS maintaineremail FROM applications_components_register,applications_components_types,applications
			WHERE componentname LIKE ' . InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->formatText('%' . $page) .
			' AND applications_components_types.typename=' . InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->formatText($this->mDump->innomatic['mode'] == InnomaticContainer::MODE_ROOT ? 'rootpanel' : 'domainpanel') .
			' AND applications_components_types.id=applications_components_register.categoryid AND appname=applications.appid';

            $guess_query = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute(
				$guess_query_sql);
            if ($guess_query->getNumberRows()) {
                $guess_data = $guess_query->getFields();
                $bug_email = '';
                if (strlen($guess_data['bugsemail']))
                    $bug_email = $guess_data['bugsemail'];
                else
                    if (strlen($guess_data['supportemail']))
                        $bug_email = $guess_data['supportemail'];
                    else
                        if (strlen($guess_data['authoremail']))
                            $bug_email = $guess_data['authoremail'];
                        else
                            if (strlen($guess_data['maintaineremail']))
                                $bug_email = $guess_data['maintaineremail'];
                $result = array();
                $result['application'] = $guess_data['appname'];
                $result['version'] = $guess_data['appversion'];
                $result['email'] = $bug_email;
                if ($guess_data['appname'] == 'innomatic') {
                    $result['innomaticemail'] = $bug_email;
                } else {
                    $innomatic_query = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute('SELECT bugsemail FROM applications WHERE appid=' . InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->formatText('innomatic'));
                    $result['innomaticemail'] = $innomatic_query->getFields('bugsemail');
                    if (! strlen($result['email']))
                        $result['email'] = $result['innomaticemail'];
                }
            }
        }
        if (! is_array($result)) {
            $result = array();
            $innomatic_query = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute('SELECT bugsemail FROM applications WHERE appid=' . InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->formatText('innomatic'));
            $result['email'] = $result['innomaticemail'] = $innomatic_query->getFields('bugsemail');
            $result['application'] = $result['application'] = '';
        }
        return $result;
    }
    public function submitBugReport ($appdata, $from, $message = '', $notifyInnomaticTeam = false)
    {
        if (is_array($appdata) and isset($appdata['email']) and strlen($from)) {
            require_once ('innomatic/net/mail/Mail.php');
            $bug_report = new Mail();
            $bug_report->From($from);
            $bug_report->ReplyTo($from);
            $bug_report->To($appdata['email']);
            $bug_report->Subject('Innomatic bug report for ' . (strlen($appdata['application']) ? '"' . $appdata['application'] . '[' . $appdata['version'] . ']"' : 'undefined') . ' application');
            $bug_report->Body('Innomatic bug report for ' . (strlen($appdata['application']) ? '"' . $appdata['application'] . '[' . $appdata['version'] . ']"' : 'undefined') . ' application' . "\n\n" . (strlen($message) ? 'Message from bug report submitter:' . "\n\n" . $message . "\n\n" : "\n\n"));
            if ($notifyInnomaticTeam and $appdata['email'] != $appdata['innomaticemail'])
                $bug_report->Cc($appdata['innomaticemail']);
            $bug_report->Attach(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $this->mPid, 'text/plain', 'attachment');
            $bug_report->Send();
            return true;
        }
        return false;
    }
}
?>
