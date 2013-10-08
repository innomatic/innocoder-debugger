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
 * The Original Code is Innomatic.
 *
 * The Initial Developer of the Original Code is Alex Pagnoni.
 * Portions created by the Initial Developer are Copyright (C) 2000-2009
 * the Initial Developer. All Rights Reserved.
 *
 * Contributor(s):
 *
 * ***** END LICENSE BLOCK ***** */
require_once ('innomatic/core/InnomaticContainer.php');
require_once ('innomatic/locale/LocaleCatalog.php');
require_once ('innomatic/locale/LocaleCountry.php');
require_once ('innomatic/wui/Wui.php');
require_once ('innomatic/wui/dispatch/WuiEventsCall.php');
require_once ('innocoder/debugger/InnocoderInstanceDebugger.php');
global $gLocale, $gPage_status, $gPage_content, $gToolbars, $gState, $gPage_title, $gPass_disp, $gJavascript;
$innomatic = InnomaticContainer::instance('innomaticcontainer');
$gLocale = new LocaleCatalog('innocoder-debugger::root_main', $innomatic->getLanguage());
$gWui = Wui::instance('wui');
$gWui->loadWidget('innomaticpage');
$gWui->loadWidget('innomatictoolbar');
$gWui->loadWidget('button');
$gWui->loadWidget('checkbox');
$gWui->loadWidget('combobox');
$gWui->loadWidget('date');
$gWui->loadWidget('empty');
$gWui->loadWidget('file');
$gWui->loadWidget('formarg');
$gWui->loadWidget('form');
$gWui->loadWidget('grid');
$gWui->loadWidget('helpnode');
$gWui->loadWidget('horizbar');
$gWui->loadWidget('horizframe');
$gWui->loadWidget('horizgroup');
$gWui->loadWidget('image');
$gWui->loadWidget('label');
$gWui->loadWidget('link');
$gWui->loadWidget('listbox');
$gWui->loadWidget('menu');
$gWui->loadWidget('page');
$gWui->loadWidget('progressbar');
$gWui->loadWidget('radio');
$gWui->loadWidget('sessionkey');
$gWui->loadWidget('statusbar');
$gWui->loadWidget('string');
$gWui->loadWidget('submit');
$gWui->loadWidget('tab');
$gWui->loadWidget('table');
$gWui->loadWidget('text');
$gWui->loadWidget('titlebar');
$gWui->loadWidget('toolbar');
$gWui->loadWidget('treemenu');
$gWui->loadWidget('vertframe');
$gWui->loadWidget('vertgroup');
$gWui->loadWidget('xml');
$gPage_content = $gPage_status = $gJavascript = '';
$gPage_title = $gLocale->getStr('advanced.title');
$gToolbars_array['main'] = array('view' => array('label' => $gLocale->getStr('default.button') , 'themeimage' => 'configure' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'default' , '')))) , 'processes' => array('label' => $gLocale->getStr('processes.button') , 'themeimage' => 'run' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'processes' , '')))));
$gToolbars_array['main']['semaphores'] = array('label' => $gLocale->getStr('semaphores.button') , 'themeimage' => 'stop' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'semaphores' , ''))));
$gToolbars_array['apps']['applications'] = array('label' => $gLocale->getStr('applications.button') , 'themeimage' => 'view_detailed' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'applications' , ''))));
// Info tool bar
//
$phpinfo_action = new WuiEventsCall();
$phpinfo_action->addEvent(new WuiEvent('view', 'phpinfo', ''));
$gToolbars_array['info']['phpinfo'] = array('label' => $gLocale->getStr('phpinfo_button') , 'themeimage' => 'run' , 'horiz' => 'true' , 'action' => $phpinfo_action->getEventsCallString());
if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic.log')) {
    $innomaticlog_action = new WuiEventsCall();
    $innomaticlog_action->addEvent(new WuiEvent('view', 'showrootlog', ''));
    $gToolbars_array['info']['rootlog'] = array('label' => $gLocale->getStr('rootlog_button') , 'themeimage' => 'toggle_log' , 'horiz' => 'true' , 'action' => $innomaticlog_action->getEventsCallString());
}
if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/webservices.log')) {
    $innomaticwebserviceslog_action = new WuiEventsCall();
    $innomaticwebserviceslog_action->addEvent(new WuiEvent('view', 'showrootwebserviceslog', ''));
    $gToolbars_array['info']['webserviceslog'] = array('label' => $gLocale->getStr('rootwebserviceslog_button') , 'themeimage' => 'toggle_log' , 'horiz' => 'true' , 'action' => $innomaticwebserviceslog_action->getEventsCallString());
}
if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic_root_db.log')) {
    $rootdalog_action = new WuiEventsCall();
    $rootdalog_action->addEvent(new WuiEvent('view', 'showrootdalog', ''));
    $gToolbars_array['info']['rootda'] = array('label' => $gLocale->getStr('rootdalog_button') , 'themeimage' => 'toggle_log' , 'horiz' => 'true' , 'action' => $rootdalog_action->getEventsCallString());
}
if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/php.log')) {
    $phplog_action = new WuiEventsCall();
    $phplog_action->addEvent(new WuiEvent('view', 'showphplog', ''));
    $gToolbars_array['info']['phplog'] = array('label' => $gLocale->getStr('phplog_button') , 'themeimage' => 'toggle_log' , 'horiz' => 'true' , 'action' => $phplog_action->getEventsCallString());
}
$gToolbars_array['help'] = array('help' => array('label' => $gLocale->getStr('help.button') , 'themeimage' => 'help' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'help' , '')))));
$gState = '';
// Pass dispatcher
//
$gPass_disp = new WuiDispatcher('action');
$gPass_disp->addEvent('setadvanced', 'pass_setadvanced');
$gPass_disp->addEvent('removepid', 'pass_removepid');
$gPass_disp->addEvent('eraseallpids', 'pass_eraseallpids');
$gPass_disp->addEvent('removesem', 'pass_removesem');
$gPass_disp->addEvent('eraseallsemaphores', 'pass_eraseallsemaphores');
$gPass_disp->addEvent('submitbugreport', 'pass_submitbugreport');
$gPass_disp->addEvent('cleanrootlog', 'pass_cleanrootlog');
$gPass_disp->addEvent('cleanrootdalog', 'pass_cleanrootdalog');
$gPass_disp->addEvent('cleanrootwebserviceslog', 'pass_cleanrootwebserviceslog');
$gPass_disp->addEvent('cleanphplog', 'pass_cleanphplog');
$gPass_disp->Dispatch();
$innomatic = InnomaticContainer::instance('innomaticcontainer');
$gToolbars = array(new WuiInnomaticToolBar('main', array('toolbars' => $gToolbars_array, 'toolbar' => 'true')));
// Main dispatcher
//
$gMain_disp = new WuiDispatcher('view');
$gMain_disp->addEvent('default', 'main_default');
$gMain_disp->addEvent('processes', 'main_processes');
$gMain_disp->addEvent('semaphores', 'main_semaphores');
$gMain_disp->addEvent('debug', 'main_debug');
$gMain_disp->addEvent('help', 'main_help');
$gMain_disp->addEvent('showrootlog', 'main_showrootlog');
$gMain_disp->addEvent('showrootwebserviceslog', 'main_showrootwebserviceslog');
$gMain_disp->addEvent('showrootdalog', 'main_showrootdalog');
$gMain_disp->addEvent('showphplog', 'main_showphplog');
$gMain_disp->addEvent('phpinfo', 'main_phpinfo');
$gMain_disp->addEvent('about', 'main_about');
$gMain_disp->addEvent('applications', 'main_applications');
$gMain_disp->addEvent('showapplication', 'main_showapplication');
$gMain_disp->addEvent('applicationhooks', 'main_applicationhooks');
$gMain_disp->Dispatch();
$gWui->addChild(new WuiInnomaticPage('page', array('pagetitle' => $gPage_title , 'menu' => InnomaticContainer::getRootWuiMenuDefinition($innomatic->getLanguage()) , 'toolbars' => $gToolbars , 'maincontent' => $gPage_content , 'status' => $gPage_status , 'icon' => 'exec' , 'javascript' => $gJavascript)));
$gWui->render();
function pass_setadvanced ($eventData)
{
    global $gPage_status, $gLocale, $gState;
    $innomatic_state = '';
    switch ($eventData['innomaticstate']) {
        case InnomaticContainer::STATE_DEBUG:
            $innomatic_state_str = 'DEBUG';
            $innomatic_state = 'debug';
            $innomatic = InnomaticContainer::instance('innomaticcontainer');
            $innomatic->setState(InnomaticContainer::STATE_DEVELOPMENT); // Do not set it to DEBUG
            break;
        case InnomaticContainer::STATE_DEVELOPMENT:
            $innomatic_state_str = 'DEVELOPMENT';
            $innomatic_state = 'development';
            $innomatic = InnomaticContainer::instance('innomaticcontainer');
            $innomatic->setState(InnomaticContainer::STATE_DEVELOPMENT);
            break;
        case InnomaticContainer::STATE_PRODUCTION:
            $innomatic_state_str = 'PRODUCTION';
            $innomatic_state = 'production';
            $innomatic = InnomaticContainer::instance('innomaticcontainer');
            $innomatic->setState(InnomaticContainer::STATE_PRODUCTION);
            break;
    }
    if (strlen($innomatic_state)) {
        $gState = $eventData['innomaticstate'];
        $log = InnomaticContainer::instance('innomaticcontainer')->getLogger();
        require_once ('innomatic/config/ConfigFile.php');
        $innomatic_cfg = new ConfigFile(InnomaticContainer::instance('innomaticcontainer')->getConfigurationFile());
        $innomatic_cfg->setValue('PlatformState', $innomatic_state);
        //InnomaticContainer::instance('innomaticcontainer')->getState() = $eventData['innomaticstate'];
        $log->logEvent('Innomatic', 'Changed Innomatic state to ' . $innomatic_state_str, Logger::NOTICE);
        $gPage_status = $gLocale->getStr('advancedset.status');
        //$wui_page->mJavascript = 'parent.frames.menu.location.reload()';
    } else {
        $gPage_status = $gLocale->getStr('advancednotset.status');
    }
}
function pass_removepid ($eventData)
{
    global $gLocale, $gPage_status;
    if (@unlink(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $eventData['pid'])) {
        $gPage_status = $gLocale->getStr('pid_removed.status');
    } else {
        $gPage_status = $gLocale->getStr('pid_not_removed.status');
    }
}
function pass_eraseallpids ($eventData)
{
    global $gLocale, $gPage_status;
    if ($handle = opendir(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids')) {
        require_once ('innomatic/core/InnomaticContainer.php');
        $innomatic = InnomaticContainer::instance('innomaticcontainer');
        while (($file = readdir($handle)) !== false) {
            if ($file != '.' && $file != '..' && $file != $innomatic->getPid()) {
                @unlink(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $file);
            }
        }
        closedir($handle);
    }
    $gPage_status = $gLocale->getStr('all_pids_removed.status');
}
function pass_removesem ($eventData)
{
    global $gLocale, $gPage_status;
    if (@unlink(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/semaphores/' . $eventData['semaphore']))
        $gPage_status = $gLocale->getStr('sem_removed.status');
    else
        $gPage_status = $gLocale->getStr('sem_not_removed.status');
}
function pass_eraseallsemaphores ($eventData)
{
    global $gLocale, $gPage_status;
    if ($handle = opendir(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/semaphores')) {
        while (($file = readdir($handle)) !== false) {
            @unlink(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/semaphores/' . $file);
        }
        closedir($handle);
    }
    $gPage_status = $gLocale->getStr('all_sems_removed.status');
}
function pass_submitbugreport ($eventData)
{
    global $gLocale, $gPage_status;
    $debug = new InnocoderInstanceDebugger($eventData['pid']);
    $debug->ReadPidFile();
    $appdata = $debug->GuessApplication();
    if (strlen($eventData['email'])) {
        $from = $eventData['email'];
    } else {
        $from = 'bugs@innomatic.org';
    }
    $notify = false;
    if (isset($eventData['notify']))
        $notify = $eventData['notify'] == 'on' ? true : false;
    if ($debug->SubmitBugReport($appdata, $from, $eventData['message'], $notify))
        $gPage_status = $gLocale->getStr('bugreport_sent.status');
    else
        $gPage_status = $gLocale->getStr('bugreport_not_sent.status');
}
function pass_cleanrootlog ($eventData)
{
    global $gLocale, $gPage_status;
    $temp_log = InnomaticContainer::instance('innomaticcontainer')->getLogger();
    if ($temp_log->cleanLog()) {
        $gPage_status = $gLocale->getStr('logcleaned_status');
    } else {
        $gPage_status = $gLocale->getStr('lognotcleaned_status');
    }
}
function pass_cleanrootdalog ($eventData)
{
    global $gPage_status, $gLocale;
    require_once ('innomatic/logging/Logger.php');
    $temp_log = new Logger(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic_root_db.log');
    if ($temp_log->cleanLog()) {
        $gPage_status = $gLocale->getStr('logcleaned_status');
    } else {
        $gPage_status = $gLocale->getStr('lognotcleaned_status');
    }
}
function pass_cleanrootwebserviceslog ($eventData)
{
    global $gPage_status, $gLocale;
    require_once ('innomatic/logging/Logger.php');
    $temp_log = new Logger(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/webservices.log');
    if ($temp_log->cleanLog()) {
        $gPage_status = $gLocale->getStr('logcleaned_status');
    } else {
        $gPage_status = $gLocale->getStr('lognotcleaned_status');
    }
}
function pass_cleanphplog ($eventData)
{
    global $gPage_status, $gLocale;
    require_once ('innomatic/logging/Logger.php');
    $temp_log = new Logger(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/php.log');
    if ($temp_log->cleanLog()) {
        $gPage_status = $gLocale->getStr('logcleaned_status');
    } else {
        $gPage_status = $gLocale->getStr('lognotcleaned_status');
    }
}
function main_default ($eventData)
{
    global $gLocale, $gPage_content, $gState;
    $innomatic = InnomaticContainer::instance('innomaticcontainer');
    $state = $innomatic->getState();
    if (strlen($gState)) {
        $state = $gState;
    }
    $xml_def = '<vertgroup><name>state</name><args><width>100%</width></args><children>
          <form><name>state</name><args><action type="encoded">' . urlencode(WuiEventsCall::buildEventsCallString('', array(array('view' , 'default' , '') , array('action' , 'setadvanced' , '')))) . '</action></args><children>
            <vertgroup><name>state</name><args><width>100%</width></args><children>
              <label><name>state</name><args><label type="encoded">' . urlencode('<strong>' . $gLocale->getStr('state.label') . '</strong>') . '</label></args></label>
              <radio><name>innomaticstate</name><args><disp>action</disp><value>' . InnomaticContainer::STATE_PRODUCTION . '</value>' . ($state == InnomaticContainer::STATE_PRODUCTION ? '<checked>true</checked>' : '') . '<label type="encoded">' . urlencode($gLocale->getStr('production.radio')) . '</label></args></radio>
              <radio><name>innomaticstate</name><args><disp>action</disp><value>' . InnomaticContainer::STATE_DEVELOPMENT . '</value>' . ($state == InnomaticContainer::STATE_DEVELOPMENT ? '<checked>true</checked>' : '') . '<label type="encoded">' . urlencode($gLocale->getStr('development.radio')) . '</label></args></radio>
              <radio><name>innomaticstate</name><args><disp>action</disp><value>' . InnomaticContainer::STATE_DEBUG . '</value>' . ($state == InnomaticContainer::STATE_DEBUG ? '<checked>true</checked>' : '') . '<label type="encoded">' . urlencode($gLocale->getStr('debug.radio')) . '</label></args></radio>
              <horizbar><name>hb</name></horizbar>
              <button><name>submit</name><args><themeimage>button_ok</themeimage><formsubmit>state</formsubmit><horiz>true</horiz><label>' . $gLocale->getStr('submit.button') . '</label><action type="encoded">' . urlencode(WuiEventsCall::buildEventsCallString('', array(array('view' , 'default' , '') , array('action' , 'setadvanced' , '')))) . '</action></args></button>
            </children></vertgroup>
          </children></form>
        </children></vertgroup>';
    $innomatic = InnomaticContainer::instance('innomaticcontainer');
    if ($innomatic->getState() == InnomaticContainer::STATE_DEBUG) {
        $innomatic->setState(InnomaticContainer::STATE_DEVELOPMENT);
    }
    $gPage_content = new WuiXml('page', array('definition' => $xml_def));
}
function processes_list_action_builder ($pageNumber)
{
    return WuiEventsCall::buildEventsCallString('', array(array('view' , 'processes' , array('processespage' => $pageNumber))));
}
function main_processes ($eventData)
{
    global $gLocale, $gPage_content, $gToolbars;
    $innomatic = InnomaticContainer::instance('innomaticcontainer');
    if ($innomatic->getState() == InnomaticContainer::STATE_DEBUG)
        $innomatic->setState(InnomaticContainer::STATE_DEVELOPMENT);
    $headers[1]['label'] = $gLocale->getStr('pid.header');
    $headers[2]['label'] = $gLocale->getStr('creation.header');
    $xml_def = '<table><name>processes</name><args><headers type="array">' . WuiXml::encode($headers) . '</headers><rowsperpage>15</rowsperpage><pagesactionfunction>processes_list_action_builder</pagesactionfunction><pagenumber>' . ((is_array($eventData) and isset($eventData['processespage'])) ? $eventData['processespage'] : '') . '</pagenumber></args><children>';
    $row = 0;
    if ($handle = opendir(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids')) {
        $country = new LocaleCountry(InnomaticContainer::instance('innomaticcontainer')->getCountry());
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                $tmp_debugger = new InnocoderInstanceDebugger($file);
                if (! $tmp_debugger->IsCurrentPid()) {
                    $toolbar = array();
                    $file_stats = stat(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/pids/' . $file);
                    $core_dump = strpos($file, '_coredump') !== false ? true : false;
                    if ($core_dump) {
                        $xml_def .= '<button row="' . $row . '" col="0"><name>type</name><args><themeimage>clanbomber</themeimage><themeimagetype>mini</themeimagetype></args></button>';
                        $pid_label = substr($file, 0, strpos($file, '_coredump'));
                    } else {
                        $pid_label = $file;
                    }
                    $xml_def .= '<label row="' . $row . '" col="1"><name>pid</name><args><label type="encoded">' . urlencode($pid_label) . '</label>';
                    if ($core_dump) {
                        $xml_def .= '<color>red</color><bold>true</bold>';
                    }
                    $xml_def .= '</args></label>';
                    $xml_def .= '<label row="' . $row . '" col="2"><name>date</name><args><label>' . $country->FormatShortDate($file_stats[10]) . ' ' . $country->FormatTime($file_stats[10]) . '</label></args></label>';
                    $toolbar['main']['remove'] = array('label' => $gLocale->getStr('remove.button') , 'themeimage' => 'edittrash' , 'themeimagetype' => 'mini' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'processes' , '') , array('action' , 'removepid' , array('pid' => $file)))) , 'needconfirm' => 'true' , 'confirmmessage' => $gLocale->getStr('remove_confirm.label'));
                    if ($tmp_debugger->CheckPidFile()) {
                        $toolbar['main']['debug'] = array('label' => $gLocale->getStr('debug.button') , 'themeimage' => 'run' , 'themeimagetype' => 'mini' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'debug' , array('pid' => $file)))));
                    } else {
                        if (! $core_dump) {
                            // This is a running (or never finished) process
                            $xml_def .= '<button row="' . $row . '" col="0"><name>type</name><args><themeimage>run</themeimage><themeimagetype>mini</themeimagetype></args></button>';
                        }
                    }
                    $xml_def .= '<innomatictoolbar row="' . $row . '" col="3"><name>toolbar</name><args><frame>false</frame><toolbars type="array">' . WuiXml::encode($toolbar) . '</toolbars></args></innomatictoolbar>';
                    $row ++;
                }
            }
        }
        closedir($handle);
    }
    $xml_def .= '</children></table>';
    $gToolbars_array['debugger'] = array('eraseall' => array('label' => $gLocale->getStr('eraseall.button') , 'themeimage' => 'edittrash' , 'needconfirm' => 'true' , 'horiz' => 'true' , 'confirmmessage' => $gLocale->getStr('eraseall.confirm') , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'processes' , '') , array('action' , 'eraseallpids' , '')))));
    $gToolbars[] = new WuiInnomaticToolBar('debugger', array('toolbars' => $gToolbars_array, 'toolbar' => 'true'));
    $gPage_content = new WuiXml('page', array('definition' => $xml_def));
}
function main_semaphores ($eventData)
{
    global $gLocale, $gPage_content, $gToolbars;
    $headers[0]['label'] = $gLocale->getStr('resource.header');
    $headers[1]['label'] = $gLocale->getStr('semaphore.header');
    $headers[2]['label'] = $gLocale->getStr('semaphorepid.header');
    $xml_def = '<table><name>semaphores</name>
          <args>
            <headers type="array">' . WuiXml::encode($headers) . '</headers>
            <rowsperpage>15</rowsperpage>
            <pagesactionfunction>processes_list_action_builder</pagesactionfunction>
            <pagenumber>' . ((is_array($eventData) and isset($eventData['processespage'])) ? $eventData['processespage'] : '') . '</pagenumber>
          </args>
          <children>';
    $row = 0;
    if ($handle = opendir(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/semaphores')) {
        $country = new LocaleCountry(InnomaticContainer::instance('innomaticcontainer')->getCountry());
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                $toolbar = array();
                $buf = file_get_contents(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/semaphores/' . $file);
                $content = unserialize($buf);
                $file_stats = stat(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/temp/semaphores/' . $file);
                $xml_def .= '<label row="' . $row . '" col="0"><name>pid</name><args><label type="encoded">' . urlencode($content['resource']) . '</label></args></label>';
                $xml_def .= '<label row="' . $row . '" col="1"><name>pid</name><args><label type="encoded">' . urlencode($file) . '</label></args></label>';
                $xml_def .= '<label row="' . $row . '" col="2"><name>pid</name><args><label type="encoded">' . urlencode($content['pid']) . '</label></args></label>';
                $xml_def .= '<label row="' . $row . '" col="3"><name>date</name><args><label>' . $country->FormatShortDate($file_stats[10]) . ' ' . $country->FormatTime($file_stats[10]) . '</label></args></label>';
                $toolbar['main']['remove'] = array('label' => $gLocale->getStr('remove_sem.button') , 'themeimage' => 'edittrash' , 'themeimagetype' => 'mini' , 'horiz' => 'true' , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'semaphores' , '') , array('action' , 'removesem' , array('semaphore' => $file)))) , 'needconfirm' => 'true' , 'confirmmessage' => $gLocale->getStr('remove_sem_confirm.label'));
                $xml_def .= '<innomatictoolbar row="' . $row . '" col="4"><name>toolbar</name><args><frame>false</frame><toolbars type="array">' . WuiXml::encode($toolbar) . '</toolbars></args></innomatictoolbar>';
                $row ++;
            }
        }
        closedir($handle);
    }
    $xml_def .= '</children></table>';
    $gToolbars_array['semaphores'] = array('eraseall' => array('label' => $gLocale->getStr('eraseall_sem.button') , 'themeimage' => 'edittrash' , 'needconfirm' => 'true' , 'horiz' => 'true' , 'confirmmessage' => $gLocale->getStr('eraseall_sem.confirm') , 'action' => WuiEventsCall::buildEventsCallString('', array(array('view' , 'semaphores' , '') , array('action' , 'eraseallsemaphores' , '')))));
    $gToolbars[] = new WuiInnomaticToolBar('semaphores', array('toolbars' => $gToolbars_array, 'toolbar' => 'true'));
    $gPage_content = new WuiXml('page', array('definition' => $xml_def));
}
function debugger_tab_action_builder ($tab)
{
    $tmp_main_disp = new WuiDispatcher('view');
    $event_data = $tmp_main_disp->getEventData();
    return WuiEventsCall::buildEventsCallString('', array(array('view' , 'debug' , array('activetab' => $tab , 'pid' => $event_data['pid']))));
}
function main_debug ($eventData)
{
    global $gLocale, $gPage_content;
    $innomatic = InnomaticContainer::instance('innomaticcontainer');
    if ($innomatic->getState() == InnomaticContainer::STATE_DEBUG) {
        $innomatic->setState(InnomaticContainer::STATE_DEVELOPMENT);
    }
    $debugger = new InnocoderInstanceDebugger($eventData['pid']);
    if ($debugger->CheckPidFile()) {
        $debugger->ReadPidFile();
        $appdata = $debugger->GuessApplication();
        $country = new LocaleCountry(InnomaticContainer::instance('innomaticcontainer')->getCountry());
        $rowa = 0;
        $rowb = 0;
        $rowc = 0;
        $rowd = 0;
        $rowe = 0;
        $rowf = 0;
        $log_events = '';
        while (list (, $log_event) = each($debugger->mLogEvents)) {
            $log_events .= $log_event . "\n";
        }
        $wui_events = array();
        while (list ($dispatcher, $event) = each($debugger->mWuiEvents)) {
            $wui_events[] = $dispatcher . '::' . $event['evn'];
            if (is_array($event['evd'])) {
                while (list ($eventdata_name, $eventdata_value) = each($event['evd'])) {
                    $wui_events[] = '- ' . $eventdata_name . '->' . $eventdata_value;
                }
            }
        }
        $tabs[0]['label'] = $gLocale->getStr('instance.label');
        $tabs[1]['label'] = $gLocale->getStr('environment.label');
        $tabs[2]['label'] = $gLocale->getStr('runtime.label');
        $tabs[3]['label'] = $gLocale->getStr('source.label');
        $tabs[4]['label'] = $gLocale->getStr('profiler.label');
        $tabs[5]['label'] = $gLocale->getStr('bugreport.label');
        arsort($debugger->mDbProfiler);
        $xml_def = '<tab><name>debugger</name><args>' . (isset($eventData['activetab']) ? '<activetab>' . $eventData['activetab'] . '</activetab>' : '') . '<tabactionfunction>debugger_tab_action_builder</tabactionfunction><tabs type="array">' . WuiXml::encode($tabs) . '</tabs></args><children>
                
                  <grid><name>debugger</name><children>
                
                    <label row="' . $rowa ++ . '" col="0"><name>instance</name><args><label type="encoded">' . urlencode($gLocale->getStr('instance.label')) . '</label><bold>true</bold></args></label>
                
                    <label row="' . $rowa . '" col="0"><name>pid</name><args><label type="encoded">' . urlencode($gLocale->getStr('pid.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>pid</name><args><readonly>true</readonly><value>' . $eventData['pid'] . '</value><size>32</size></args></string>
                
                    <label row="' . $rowa . '" col="0"><name>sessionid</name><args><label type="encoded">' . urlencode($gLocale->getStr('sessionid.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>sessionid</name><args><readonly>true</readonly><value>' . $debugger->mSessionId . '</value><size>32</size></args></string>
                
                    <label row="' . $rowa . '" col="0"><name>state</name><args><label type="encoded">' . urlencode($gLocale->getStr('state.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>state</name><args><readonly>true</readonly><value>' . $debugger->mState . '</value><size>15</size></args></string>
                
                    <label row="' . $rowa . '" col="0"><name>interface</name><args><label type="encoded">' . urlencode($gLocale->getStr('interface.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>interface</name><args><readonly>true</readonly><value>' . $debugger->mInterface . '</value><size>15</size></args></string>
                
                    <label row="' . $rowa . '" col="0"><name>mode</name><args><label type="encoded">' . urlencode($gLocale->getStr('mode.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>mode</name><args><readonly>true</readonly><value>' . $debugger->mMode . '</value><size>15</size></args></string>
                
                    <label row="' . $rowa . '" col="0"><name>pagename</name><args><label type="encoded">' . urlencode($gLocale->getStr('pagename.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>pagename</name><args><readonly>true</readonly><value>' . $debugger->mDesktopApplication . '</value><size>20</size></args></string>
                
                    <label row="' . $rowa . '" col="0"><name>domainid</name><args><label type="encoded">' . urlencode($gLocale->getStr('domainid.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>domainid</name><args><readonly>true</readonly><value>' . $debugger->mPidStructure['gEnv']['domain']['id'] . '</value><size>20</size></args></string>
                
                    <label row="' . $rowa . '" col="0"><name>userid</name><args><label type="encoded">' . urlencode($gLocale->getStr('userid.label')) . '</label></args></label>
                    <string row="' . $rowa ++ . '" col="1"><name>userid</name><args><readonly>true</readonly><value>' . $debugger->mPidStructure['gEnv']['user']['id'] . '</value><size>20</size></args></string>
                
                  </children></grid>
                
                  <grid><name>environment</name><children>
                
                    <label row="' . $rowb ++ . '" col="0"><name>environment</name><args><label type="encoded">' . urlencode($gLocale->getStr('environment.label')) . '</label><bold>true</bold></args></label>
                
                    <label row="' . $rowb . '" col="0"><name>memory</name><args><label type="encoded">' . urlencode($gLocale->getStr('memorylimit.label')) . '</label></args></label>
                    <string row="' . $rowb ++ . '" col="1"><name>memory</name><args><readonly>true</readonly><value>' . $debugger->mPidStructure['gEnv']['core']['php']['memorylimit'] . '</value><size>15</size></args></string>
                
                    <label row="' . $rowb . '" col="0"><name>timelimit</name><args><label type="encoded">' . urlencode($gLocale->getStr('timelimit.label')) . '</label></args></label>
                    <string row="' . $rowb ++ . '" col="1"><name>timelimit</name><args><readonly>true</readonly><value>' . $debugger->mPidStructure['gEnv']['core']['php']['timelimit'] . '</value><size>15</size></args></string>
                
                    <label row="' . $rowb . '" col="0"><name>sessionlifetime</name><args><label type="encoded">' . urlencode($gLocale->getStr('sessionlifetime.label')) . '</label></args></label>
                    <string row="' . $rowb ++ . '" col="1"><name>sessionlifetime</name><args><readonly>true</readonly><value>' . $debugger->mPidStructure['gEnv']['core']['session']['lifetime'] . '</value><size>15</size></args></string>
                
                    <label row="' . $rowb . '" col="0"><name>extensions</name><args><label type="encoded">' . urlencode($gLocale->getStr('extensions.label')) . '</label></args></label>
                    <listbox row="' . $rowb ++ . '" col="1"><name>extensions</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mLoadedExtensions) . '</elements><size>10</size></args></listbox>
                
                  </children></grid>
                
                  <grid><name>runtime</name><children>
                
                    <label row="' . $rowc ++ . '" col="0"><name>runtime</name><args><label type="encoded">' . urlencode($gLocale->getStr('runtime.label')) . '</label><bold>true</bold></args></label>
                                
                    <label row="' . $rowc . '" col="0"><name>logevents</name><args><label type="encoded">' . urlencode($gLocale->getStr('logevents.label')) . '</label></args></label>
                    <text row="' . $rowc ++ . '" col="1"><name>logevents</name><args><readonly>true</readonly><value type="encoded">' . urlencode($log_events) . '</value><rows>15</rows><cols>100</cols></args></text>
                
                    <label row="' . $rowc . '" col="0"><name>calledhooks</name><args><label type="encoded">' . urlencode($gLocale->getStr('calledhooks.label')) . '</label></args></label>
                    <listbox row="' . $rowc ++ . '" col="1"><name>calledhooks</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mCalledHooks) . '</elements><size>5</size></args></listbox>
                
                    <label row="' . $rowc . '" col="0"><name>wuievents</name><args><label type="encoded">' . urlencode($gLocale->getStr('wuievents.label')) . '</label></args></label>
                    <listbox row="' . $rowc ++ . '" col="1"><name>wuievents</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($wui_events) . '</elements><size>5</size></args></listbox>
                
                    <label row="' . $rowc . '" col="0"><name>queries</name><args><label type="encoded">' . urlencode($gLocale->getStr('queries.label')) . '</label></args></label>
                    <listbox row="' . $rowc ++ . '" col="1"><name>queries</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mExecutedQueries) . '</elements><size>10</size></args></listbox>
                
                    <label row="' . $rowc . '" col="0"><name>includedfiles</name><args><label type="encoded">' . urlencode($gLocale->getStr('includedfiles.label')) . '</label></args></label>
                    <listbox row="' . $rowc ++ . '" col="1"><name>includedfiles</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mIncludedFiles) . '</elements><size>5</size></args></listbox>
                    <label row="' . $rowc . '" col="0">
                              <args>
                                <label type="encoded">' . urlencode($gLocale->getStr('memoryusage.label')) . '</label>
                              </args>
                            </label>
                      <string row="' . $rowc ++ . '" col="1">
                      <args>
                        <value type="encoded">' . urlencode($country->FormatNumber($debugger->mMemoryUsage)) . '</value>
                        <readonly>true</readonly>
                        <size>15</size>
                      </args>
                    </string>
                
                    <label row="' . $rowc . '" col="0">
                              <args>
                                <label type="encoded">' . urlencode($gLocale->getStr('memorypeakusage.label')) . '</label>
                              </args>
                            </label>
                      <string row="' . $rowc ++ . '" col="1">
                      <args>
                        <value type="encoded">' . urlencode($country->FormatNumber($debugger->mMemoryPeakUsage)) . '</value>
                        <readonly>true</readonly>
                        <size>15</size>
                      </args>
                    </string>
                
                    </children></grid>
                
                  <grid><name>source</name><children>
                
                    <label row="' . $rowe ++ . '" col="0"><name>source</name><args><label type="encoded">' . urlencode($gLocale->getStr('source.label')) . '</label><bold>true</bold></args></label>
                
                    <label row="' . $rowe . '" col="0"><name>classes</name><args><label type="encoded">' . urlencode($gLocale->getStr('classes.label')) . '</label></args></label>
                    <listbox row="' . $rowe ++ . '" col="1"><name>classes</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mDefinedClasses) . '</elements><size>10</size></args></listbox>
                
                    <label row="' . $rowe . '" col="0"><name>functions</name><args><label type="encoded">' . urlencode($gLocale->getStr('functions.label')) . '</label></args></label>
                    <listbox row="' . $rowe ++ . '" col="1"><name>functions</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mDefinedFunctions) . '</elements><size>5</size></args></listbox>
                
                  </children></grid>
                
                  <grid><name>profiler</name><children>
                
                    <label row="' . $rowd ++ . '" col="0"><name>profiler</name><args><label type="encoded">' . urlencode($gLocale->getStr('profiler.label')) . '</label><bold>true</bold></args></label>
                
                    <label row="' . $rowd . '" col="0"><name>markers</name><args><label type="encoded">' . urlencode($gLocale->getStr('markers.label')) . '</label></args></label>
                    <listbox row="' . $rowd ++ . '" col="1"><name>markers</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mProfiler) . '</elements><size>20</size></args></listbox>
                
                    <label row="' . $rowd . '" col="0"><name>markers</name><args><label type="encoded">' . urlencode($gLocale->getStr('dbmarkers.label')) . '</label></args></label>
                    <listbox row="' . $rowd ++ . '" col="1"><name>markers</name><args><readonly>true</readonly><elements type="array">' . WuiXml::encode($debugger->mDbProfiler) . '</elements><size>20</size></args></listbox>
                    
                    <label row="' . $rowd . '" col="0"><name>dbload</name><args><label type="encoded">' . urlencode($gLocale->getStr('dbload.label')) . '</label></args></label>
                    <string row="' . $rowd ++ . '" col="1"><name>dbload</name><args><readonly>true</readonly><value>' . $debugger->mDbTotalLoad . '</value><size>20</size></args></string>
                
                    <label row="' . $rowd . '" col="0"><args><label type="encoded">' . urlencode($gLocale->getStr('executedqueries.label')) . '</label></args></label>
                    <string row="' . $rowd ++ . '" col="1"><name>executedqueries</name><args><readonly>true</readonly><value>' . count($debugger->mDbProfiler) . '</value><size>6</size></args></string>
                
                  </children></grid>
                
                  <form><name>bugreport</name><args><method>post</method><action type="encoded"></action></args><children>
                
                    <vertgroup><name>bugreport</name><children>
                
                      <grid><name>bugreport</name><children>
                
                        <label row="' . $rowf ++ . '" col="0"><name>bugreport</name><args><label type="encoded">' . urlencode($gLocale->getStr('bugreport.label')) . '</label><bold>true</bold></args></label>
                
                        <label row="' . $rowf . '" col="0"><name>application</name><args><label type="encoded">' . urlencode($gLocale->getStr('application.label')) . '</label></args></label>
                        <label row="' . $rowf ++ . '" col="1"><name>application</name><args><label type="encoded">' . urlencode($appdata['application']) . '</label></args></label>
                
                        <label row="' . $rowf . '" col="0"><name>bugsemail</name><args><label type="encoded">' . urlencode($gLocale->getStr('bugsemail.label')) . '</label></args></label>
                        <label row="' . $rowf ++ . '" col="1"><name>to</name><args><label type="encoded">' . urlencode($appdata['email']) . '</label></args></label>';
        if ($appdata['innomaticemail'] != $appdata['email'])
            $xml_def .= '        <label row="' . $rowf . '" col="0"><name>notify</name><args><label type="encoded">' . urlencode($gLocale->getStr('sendnotify.label')) . '</label></args></label>
                                <checkbox row="' . $rowf ++ . '" col="1"><name>notify</name><args><disp>action</disp></args></checkbox>';
        $xml_def .= '        <label row="' . $rowf . '" col="0"><name>email</name><args><label type="encoded">' . urlencode($gLocale->getStr('submitteremail.label')) . '</label></args></label>
                        <string row="' . $rowf ++ . '" col="1"><name>email</name><args><size>25</size><disp>action</disp></args></string>
                
                        <label row="' . $rowf . '" col="0"><name>message</name><args><label type="encoded">' . urlencode($gLocale->getStr('message.label')) . '</label></args></label>
                        <text row="' . $rowf ++ . '" col="1"><name>message</name><args><cols>80</cols><rows>10</rows><disp>action</disp></args></text>
                
                      </children></grid>
                
                      <horizbar><name>hb</name></horizbar>
                
                      <button><name>submit</name>
                        <args>
                          <formsubmit>bugreport</formsubmit>
                          <themeimage>button_ok</themeimage>
                          <frame>false</frame>
                          <horiz>true</horiz>
                          <label type="encoded">' . urlencode($gLocale->getStr('bugreport.submit')) . '</label>
                          <action type="encoded">' . urlencode(WuiEventsCall::buildEventsCallString('', array(array('view' , 'debug' , array('pid' => $eventData['pid'])) , array('action' , 'submitbugreport' , array('pid' => $eventData['pid']))))) . '</action>
                        </args>
                      </button>
                
                    </children></vertgroup>
                
                  </children></form>
                
                </children></tab>';
    }
    $gPage_content = new WuiXml('page', array('definition' => $xml_def));
}
function main_showrootlog ($eventData)
{
    global $gLocale, $gWui_mainstatus, $gPage_title, $gWui_mainvertgroup, $gPage_content, $gToolbars;
    $gPage_content = new WuiVertGroup('vgroup');
    $log_content = '';
    if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic.log')) {
        $cleanlog_action = new WuiEventsCall();
        $cleanlog_action->addEvent(new WuiEvent('view', 'showrootlog', ''));
        $cleanlog_action->addEvent(new WuiEvent('action', 'cleanrootlog', ''));
        $gToolbars_array['cleanlog'] = array('main' => array('label' => $gLocale->getStr('cleanlog_button') , 'themeimage' => 'editdelete' , 'horiz' => 'true' , 'action' => $cleanlog_action->getEventsCallString()));
        $gToolbars[] = new WuiInnomaticToolBar('main', array('toolbars' => $gToolbars_array, 'toolbar' => 'true'));
        if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic.log')) {
            $log_content = file_get_contents(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic.log');
        }
    }
    $gPage_content->addChild(new WuiText('rootlog', array('disp' => 'action' , 'readonly' => 'true' , 'value' => htmlentities($log_content) , 'rows' => '20' , 'cols' => '120')), 0, 1);
    $gPage_title .= ' - ' . $gLocale->getStr('rootlog_title');
}
function main_showrootwebserviceslog ($eventData)
{
    global $gLocale, $gWui_mainstatus, $gPage_title, $gWui_mainvertgroup, $gPage_content, $gToolbars;
    $gPage_content = new WuiVertGroup('vgroup');
    $log_content = '';
    if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/webservices.log')) {
        $cleanlog_action = new WuiEventsCall();
        $cleanlog_action->addEvent(new WuiEvent('view', 'showrootwebserviceslog', ''));
        $cleanlog_action->addEvent(new WuiEvent('action', 'cleanrootwebserviceslog', ''));
        $gToolbars_array['cleanlog'] = array('main' => array('label' => $gLocale->getStr('cleanlog_button') , 'themeimage' => 'editdelete' , 'horiz' => 'true' , 'action' => $cleanlog_action->getEventsCallString()));
        $gToolbars[] = new WuiInnomaticToolBar('main', array('toolbars' => $gToolbars_array));
        if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/webservices.log')) {
            $log_content = file_get_contents(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/webservices.log');
        }
    }
    $gPage_content->addChild(new WuiText('rootlog', array('disp' => 'action' , 'readonly' => 'true' , 'value' => htmlentities($log_content) , 'rows' => '20' , 'cols' => '120')), 0, 1);
    $gPage_title .= ' - ' . $gLocale->getStr('rootwebserviceslog_title');
}
function main_showrootdalog ($eventData)
{
    global $gLocale, $gWui_mainstatus, $gPage_title, $gWui_mainvertgroup, $gPage_content, $gToolbars;
    $gPage_content = new WuiVertGroup('vgroup');
    $log_content = '';
    if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic_root_db.log')) {
        $cleanlog_action = new WuiEventsCall();
        $cleanlog_action->addEvent(new WuiEvent('view', 'showrootdalog', ''));
        $cleanlog_action->addEvent(new WuiEvent('action', 'cleanrootdalog', ''));
        $gToolbars_array['cleanlog'] = array('main' => array('label' => $gLocale->getStr('cleanlog_button') , 'themeimage' => 'editdelete' , 'horiz' => 'true' , 'action' => $cleanlog_action->getEventsCallString()));
        $gToolbars[] = new WuiInnomaticToolBar('main', array('toolbars' => $gToolbars_array, 'toolbar' => 'true'));
        if (file_Exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic_root_db.log')) {
            $log_content = file_get_contents(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/innomatic_root_db.log');
        }
    }
    $gPage_content->addChild(new WuiText('rootdalog', array('disp' => 'action' , 'readonly' => 'true' , 'value' => htmlentities($log_content) , 'rows' => '20' , 'cols' => '120')), 0, 1);
    $gPage_title .= ' - ' . $gLocale->getStr('rootdalog_title');
}
function main_showphplog ($eventData)
{
    global $gLocale, $gWui_mainstatus, $gPage_title, $gWui_mainvertgroup, $gPage_content, $gToolbars;
    $gPage_content = new WuiVertGroup('vgroup');
    $log_content = '';
    if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/php.log')) {
        $cleanlog_action = new WuiEventsCall();
        $cleanlog_action->addEvent(new WuiEvent('view', 'showphplog', ''));
        $cleanlog_action->addEvent(new WuiEvent('action', 'cleanphplog', ''));
        $gToolbars_array['cleanlog'] = array('main' => array('label' => $gLocale->getStr('cleanlog_button') , 'themeimage' => 'editdelete' , 'horiz' => 'true' , 'action' => $cleanlog_action->getEventsCallString()));
        $gToolbars[] = new WuiInnomaticToolBar('main', array('toolbars' => $gToolbars_array, 'toolbar' => 'true'));
        if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/php.log')) {
            $log_content = file_get_contents(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/log/php.log');
        }
    }
    $gPage_content->addChild(new WuiText('phplog', array('disp' => 'action' , 'readonly' => 'true' , 'value' => htmlentities($log_content) , 'rows' => '20' , 'cols' => '120')), 0, 1);
    $gPage_title .= ' - ' . $gLocale->getStr('phplog_title');
}
function main_phpinfo ($eventData)
{
    phpinfo();
    InnomaticContainer::instance('innomaticcontainer')->halt();
}
function applications_list_action_builder ($pageNumber)
{
    return WuiEventsCall::buildEventsCallString('', array(array('view' , 'applications' , array('applicationspage' => $pageNumber))));
}
function applications_tab_action_builder ($tab)
{
    return WuiEventsCall::buildEventsCallString('', array(array('view' , 'applications' , array('activetab' => $tab))));
}
function main_applications ($eventData)
{
    global $wui_mainframe, $gLocale, $gLocale, $gPage_content, $gStatus;
    $applications_query = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute('SELECT * FROM applications ORDER BY category,appid');
    if ($applications_query->getNumberRows() > 0) {
        $headers[1]['label'] = $gLocale->getStr('appid_header');
        $headers[2]['label'] = $gLocale->getStr('modauthor_header');
        $headers[3]['label'] = $gLocale->getStr('appversion_header');
        $headers[4]['label'] = $gLocale->getStr('appdate_header');
        $row = 0;
        $current_category = '';
        while (! $applications_query->eof) {
            $tmp_data = $applications_query->getFields();
            if ($tmp_data['category'] == '')
                $tmp_data['category'] = 'various';
            $applications_array[$tmp_data['category']][] = $tmp_data;
            $applications_query->moveNext();
        }
        ksort($applications_array);
        $categories = array();
        while (list (, $tmp_data) = each($applications_array)) {
            while (list (, $data) = each($tmp_data)) {
                if ($data['category'] != $current_category) {
                    $wui_applications_table[$data['category']] = new WuiTable('applicationstable', array('headers' => $headers , 'rowsperpage' => '10' , 'pagesactionfunction' => 'applications_list_action_builder' , 'pagenumber' => (isset($eventData['applicationspage']) ? $eventData['applicationspage'] : '') , 'sessionobjectusername' => $data['category']));
                    $current_category = $data['category'];
                    $categories[] = $data['category'];
                    $row = 0;
                    //$wui_applications_table->addChild( new WuiLabel( 'modcategory'.$row, array( 'label' => '<strong><font color="red">'.ucfirst( $data['category'] ).'</font></strong>' ) ), $row, 0 );
                //$row++;
                }
                if (strlen($data['iconfile'])) {
                    $wui_applications_table[$data['category']]->addChild(new WuiImage('icon' . $row, array('hint' => $data['appid'] , 'imageurl' => InnomaticContainer::instance('innomaticcontainer')->getBaseUrl(false) . '/core/applications/' . $data['appid'] . '/' . $data['iconfile'])), $row, 0);
                }
                $wui_applications_table[$data['category']]->addChild(new WuiLabel('appidlabel' . $row, array('label' => '<strong>' . $data['appid'] . '</strong><br />' . $data['appdesc'])), $row, 1);
                $wui_applications_table[$data['category']]->addChild(new WuiLink('modauthorlabel' . $row, array('label' => $data['author'] , 'link' => $data['authorsite'])), $row, 2);
                $wui_applications_table[$data['category']]->addChild(new WuiLabel('appversionlabel' . $row, array('label' => $data['appversion'])), $row, 3);
                $wui_applications_table[$data['category']]->addChild(new WuiLabel('appdatedatelabel' . $row, array('label' => $data['appdate'])), $row, 4);
                $wui_application_toolbar[$data['category']][$row] = new WuiHorizGroup('applicationtoolbar' . $row);
                $details_action[$data['category']][$row] = new WuiEventsCall('applications');
                $details_action[$data['category']][$row]->addEvent(new WuiEvent('view', 'details', array('appid' => $data['id'])));
                $wui_details_button[$data['category']][$row] = new WuiButton('detailsbutton' . $row, array('label' => $gLocale->getStr('moddetails_label') , 'themeimage' => 'viewmag' , 'action' => $details_action[$data['category']][$row]->getEventsCallString() , 'horiz' => 'true'));
                $wui_application_toolbar[$data['category']][$row]->addChild($wui_details_button[$data['category']][$row]);
                $show_action[$data['category']][$row] = new WuiEventsCall();
                $show_action[$data['category']][$row]->addEvent(new WuiEvent('view', 'showapplication', array('appid' => $data['id'])));
                $wui_show_button[$data['category']][$row] = new WuiButton('showbutton' . $row, array('label' => $gLocale->getStr('showapplication_label') , 'themeimage' => 'viewmag+' , 'action' => $show_action[$data['category']][$row]->getEventsCallString() , 'horiz' => 'true'));
                $wui_application_toolbar[$data['category']][$row]->addChild($wui_show_button[$data['category']][$row]);
                $hooks_action[$data['category']][$row] = new WuiEventsCall();
                $hooks_action[$data['category']][$row]->addEvent(new WuiEvent('view', 'applicationhooks', array('appid' => $data['id'])));
                $wui_hooks_button[$data['category']][$row] = new WuiButton('hooksbutton' . $row, array('label' => $gLocale->getStr('applicationhooks.label') , 'themeimage' => 'attach' , 'action' => $hooks_action[$data['category']][$row]->getEventsCallString() , 'horiz' => 'true'));
                $wui_application_toolbar[$data['category']][$row]->addChild($wui_hooks_button[$data['category']][$row]);
                if (strcmp($data['appid'], 'innomatic')) {
                    $deps_action[$data['category']][$row] = new WuiEventsCall('applications');
                    $deps_action[$data['category']][$row]->addEvent(new WuiEvent('view', 'dependencies', array('appid' => $data['id'])));
                    $wui_deps_button[$data['category']][$row] = new WuiButton('depsbutton' . $row, array('label' => $gLocale->getStr('applicationdeps_label') , 'themeimage' => 'view_tree' , 'action' => $deps_action[$data['category']][$row]->getEventsCallString() , 'horiz' => 'true'));
                    $wui_application_toolbar[$data['category']][$row]->addChild($wui_deps_button[$data['category']][$row]);
                }
                if (file_exists(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/applications/' . $data['appid'] . '/application.log')) {
                    $log_action[$data['category']][$row] = new WuiEventsCall();
                    $log_action[$data['category']][$row]->addEvent(new WuiEvent('view', 'applicationlog', array('appid' => $data['id'])));
                    $wui_log_button[$data['category']][$row] = new WuiButton('logbutton' . $row, array('label' => $gLocale->getStr('modlog_label') , 'themeimage' => 'toggle_log' , 'action' => $log_action[$data['category']][$row]->getEventsCallString() , 'horiz' => 'true'));
                    $wui_application_toolbar[$data['category']][$row]->addChild($wui_log_button[$data['category']][$row]);
                }
                $wui_applications_table[$data['category']]->addChild($wui_application_toolbar[$data['category']][$row], $row, 5);
                $row ++;
            }
            while (list (, $category) = each($categories)) {
                $tabs[]['label'] = ucfirst($category);
            }
            reset($categories);
            $gPage_content = new WuiTab('applicationstab', array('tabactionfunction' => 'applications_tab_action_builder' , 'tabs' => $tabs , 'activetab' => (isset($eventData['activetab']) ? $eventData['activetab'] : '')));
            while (list (, $category) = each($categories)) {
                $gPage_content->addChild($wui_applications_table[$category]);
            }
        }
    } else {
        $gStatus = $gLocale->getStr('no_available_applications_status');
    }
}
function show_application_action_builder ($pageNumber)
{
    $tmp_main_disp = new WuiDispatcher('view');
    $event_data = $tmp_main_disp->getEventData();
    return WuiEventsCall::buildEventsCallString('', array(array('view' , 'showapplication' , array('pagenumber' => $pageNumber , 'appid' => $event_data['appid']))));
}
function main_showapplication ($eventData)
{
    global $gLocale, $gPage_title, $gPage_content;
    require_once ('innomatic/application/Application.php');
    $query = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute('SELECT appid FROM applications WHERE id=' . $eventData['appid'] . ' ');
    $application_data = $query->getFields();
    require_once ('innomatic/application/ApplicationStructureDefinition.php');
    $deffile = new ApplicationStructureDefinition(InnomaticContainer::instance('innomaticcontainer')->getDataAccess(), InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/');
    $deffile->load_DefFile(InnomaticContainer::instance('innomaticcontainer')->getHome() . 'core/applications/' . $application_data['appid'] . '/application.xml');
    $structure = $deffile->getStructure();
    ksort($structure);
    $headers[0]['label'] = $gLocale->getStr('componenttype_header');
    $headers[1]['label'] = $gLocale->getStr('componentname_header');
    $headers[2]['label'] = $gLocale->getStr('componentattrs_header');
    $row = 0;
    $gPage_content = new WuiTable('applicationstable', array('headers' => $headers , 'rowsperpage' => '20' , 'pagesactionfunction' => 'show_application_action_builder' , 'pagenumber' => (isset($eventData['pagenumber']) ? $eventData['pagenumber'] : '') , 'sessionobjectusername' => $application_data['appid']));
    while (list ($type, $elems) = each($structure)) {
        if (is_array($elems)) {
            asort($elems);
            while (list ($elem, $attrs) = each($elems)) {
                $attrs_string = '';
                while (list ($key, $val) = each($attrs)) {
                    if (strcmp($key, 'name'))
                        $attrs_string .= '<b>' . $key . '</b>: ' . $val . '. ';
                }
                $gPage_content->addChild(new WuiLabel('componenttypelabel' . $row, array('label' => $type)), $row, 0);
                $gPage_content->addChild(new WuiLabel('componentnamelabel' . $row, array('label' => $attrs['name'])), $row, 1);
                $gPage_content->addChild(new WuiLabel('componentattrslabel' . $row, array('label' => $attrs_string)), $row, 2);
                $row ++;
            }
        }
    }
    $gPage_title .= ' - ' . $application_data['appid'] . ' - ' . $gLocale->getStr('applicationstructure_title');
}
function main_applicationhooks ($eventData)
{
    global $wui_mainframe, $gLocale, $gPage_title, $gPage_content;
    $applications = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute('SELECT appid FROM applications WHERE id=' . $eventData['appid']);
    $hook_events = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute('SELECT function,event FROM hooks_events WHERE functionapplication=' . InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->formatText($applications->getFields('appid')) . ' ORDER BY function,event');
    $hooks = InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->execute('SELECT function,event,hookapplication FROM hooks WHERE functionapplication=' . InnomaticContainer::instance('innomaticcontainer')->getDataAccess()->formatText($applications->getFields('appid')) . ' ORDER BY hookapplication,function,event');
    $headers_events[0]['label'] = $gLocale->getStr('hook_function.header');
    $headers_events[1]['label'] = $gLocale->getStr('hook_event.header');
    $headers_hooks[0]['label'] = $gLocale->getStr('hook_application.header');
    $headers_hooks[1]['label'] = $gLocale->getStr('hook_function.header');
    $headers_hooks[2]['label'] = $gLocale->getStr('hook_event.header');
    $xml_def = '<horizgroup>
      <args>
        <align>top</align>
      </args>
      <children>
    
        <vertgroup>
          <children>
    
            <label>
              <args>
                <label>' . WuiXml::cdata($gLocale->getStr('hook_events.label')) . '</label>
                <bold>true</bold>
              </args>
            </label>
    
      <table>
      <name>hookevents</name>
      <args>
        <headers type="array">' . WuiXml::encode($headers_events) . '</headers>
      </args>
      <children>';
    $row = 0;
    while (! $hook_events->eof) {
        $xml_def .= '<label row="' . $row . '" col="0">
          <args>
            <label>' . WuiXml::cdata($hook_events->getFields('function')) . '</label>
            <compact>true</compact>
          </args>
        </label>
        <label row="' . $row . '" col="1">
          <args>
            <label>' . WuiXml::cdata($hook_events->getFields('event')) . '</label>
            <compact>true</compact>
          </args>
        </label>';
        $hook_events->moveNext();
        $row ++;
    }
    $xml_def .= '  </children>
    </table>
          </children>
        </vertgroup>
        <vertgroup>
          <children>
    
            <label>
              <args>
                <label>' . WuiXml::cdata($gLocale->getStr('hooks.label')) . '</label>
                <bold>true</bold>
              </args>
            </label>
    
      <table>
      <name>hooks</name>
      <args>
        <headers type="array">' . WuiXml::encode($headers_hooks) . '</headers>
      </args>
      <children>';
    $row = 0;
    while (! $hooks->eof) {
        $xml_def .= '<label row="' . $row . '" col="0">
          <args>
            <label>' . WuiXml::cdata($hooks->getFields('hookapplication')) . '</label>
            <compact>true</compact>
          </args>
        </label>
        <label row="' . $row . '" col="1">
          <args>
            <label>' . WuiXml::cdata($hooks->getFields('function')) . '</label>
            <compact>true</compact>
          </args>
        </label>
        <label row="' . $row . '" col="2">
          <args>
            <label>' . WuiXml::cdata($hooks->getFields('event')) . '</label>
            <compact>true</compact>
          </args>
        </label>';
        $hooks->moveNext();
        $row ++;
    }
    $xml_def .= '  </children>
    </table>
          </children>
        </vertgroup>
      </children>
    </horizgroup>';
    $gPage_content = new WuiXml('page', array('definition' => $xml_def));
}
function main_help ($eventData)
{
    global $gLocale, $gPage_content;
    $gPage_content = new WuiHelpNode('help', array('base' => 'innocoder-debugger' , 'node' => 'debugger.html#' . $eventData['node'] , 'language' => InnomaticContainer::instance('innomaticcontainer')->getLanguage()));
}
?>
