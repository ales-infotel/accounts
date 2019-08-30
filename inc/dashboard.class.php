<?php
/*
 * @version $Id: HEADER 15930 2011-10-30 15:47:55Z tsmr $
 -------------------------------------------------------------------------
 resources plugin for GLPI
 Copyright (C) 2009-2016 by the resources Development Team.

 https://github.com/InfotelGLPI/resources
 -------------------------------------------------------------------------

 LICENSE

 This file is part of resources.

 resources is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 resources is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with resources. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */

/**
 * Class PluginResourcesDashboard
 */
class PluginAccountsDashboard extends CommonGLPI {

   public $widgets = [];
   private $options;
   private $datas, $form;

   /**
    * PluginAccountsDashboard constructor.
    *
    * @param array $options
    */
   function __construct($options = []) {
      $this->options = $options;
      $this->interfaces = ["central"];
   }


   /**
    * @return array
    */
   function getWidgetsForItem() {
      return [
         $this->getType()."1" => __('Generate password', 'accounts') . "&nbsp;<i class='fa fa-table'></i>",

      ];
   }

   /**
    * @param $widgetId
    *
    * @return \PluginMydashboardDatatable
    */
   function getWidgetContentForItem($widgetId) {
      global $CFG_GLPI, $DB;

      switch ($widgetId) {
         case $this->getType()."1" :
            $content = "<table class='tab_cadre'><tr><td colspan='2'><input type='text' disabled name='hidden_password' id='hidden_password' size='30' ></td></tr></table><br>";
               $content .=  "<table class='tab_cadre'>
               <tbody>
               <tr class='tab_bg_1 center'><th colspan ='2'>" . __s('Generate password', 'accounts') . "</th></tr>
               <tr class='tab_bg_1'><td><input type=\"checkbox\" checked id=\"char-0\" /></td><td><label for=\"char-0\"> ".__("Numbers","accounts")." <small>(0123456789)</small></label></td></tr>
               <tr class='tab_bg_1'><td><input type=\"checkbox\" checked id=\"char-1\" /></td><td><label for=\"char-1\"> ".__("Lowercase","accounts")." <small>(abcdefghijklmnopqrstuvwxyz)</small></label></td></tr>
               <tr class='tab_bg_1'><td><input type=\"checkbox\" checked id=\"char-2\" /></td><td><label for=\"char-2\"> ".__("Uppercase","accounts")." <small>(ABCDEFGHIJKLMNOPQRSTUVWXYZ)</small></label></td></tr>
               <tr class='tab_bg_1'><td><input type=\"checkbox\" id=\"char-3\" /></td><td><label for=\"char-3\"> ".__("Special characters","accounts")." <small>(!\"#$%&amp;'()*+,-./:;&lt;=&gt;?@[\]^_`{|}~)</small></label></td></tr>
               <tr class='tab_bg_1'>
                        <td><label for='length'>".__("Length","accounts")."</label></td>
                        <td><input type='number' min='1' value='8' step='1' id='length' style='width:4em'  /> ".__(" characters","accounts")."</td>
                     </tr>
               <tr id='fakeupdate'></tr>
               <tr class='tab_bg_2 center'><td colspan='2'>&nbsp;<input type='button' id='generatePass' name='generatePass' class='submit' style='background-color: #fec95c;color: #4b2f03;border: 2px solid #4b2f03;padding: 5px;' value='" . __s('Generate', 'accounts') . "'
                     class='submit'></td></tr>
               </tbody>
               </table>";
               $content .= Ajax::updateItemOnEvent("generatePass","fakeupdate",$CFG_GLPI["root_doc"]."/plugins/accounts/ajax/generatepassword.php",["password"=>1],["click"],$minsize = -1, $buffertime = -1,
                                     $forceloadfor = [], $display = false);
               $widget = new PluginMydashboardHtml();
               $widget->setWidgetHeader("");
               $widget->setWidgetHtmlContent($content);

               $widget->toggleWidgetRefresh();
               $widget->setWidgetTitle(__('Generate password', 'accounts'));
               return $widget;
             break;
      }
   }
}
