<?php
/*
  Plugin Panier PayPal Pour Piwigo
  Copyright (C) 2011 www.queguineur.fr � Tous droits r�serv�s.
  
  Ce programme est un logiciel libre ; vous pouvez le redistribuer ou le
  modifier suivant les termes de la �GNU General Public License� telle que
  publi�e par la Free Software Foundation : soit la version 3 de cette
  licence, soit (� votre gr�) toute version ult�rieure.
  
  Ce programme est distribu� dans l�espoir qu�il vous sera utile, mais SANS
  AUCUNE GARANTIE : sans m�me la garantie implicite de COMMERCIALISABILIT�
  ni d�AD�QUATION � UN OBJECTIF PARTICULIER. Consultez la Licence G�n�rale
  Publique GNU pour plus de d�tails.
  
  Vous devriez avoir re�u une copie de la Licence G�n�rale Publique GNU avec
  ce programme ; si ce n�est pas le cas, consultez :
  <http://www.gnu.org/licenses/>.
*/

if (!defined('PHPWG_ROOT_PATH')) die('Hacking attempt!');

defined('PPPPP_ID') or define('PPPPP_ID', basename(dirname(__FILE__)));
include_once(PHPWG_PLUGINS_PATH.PPPPP_ID.'/include/install.inc.php');

/**
 * plugin installation
 *
 * perform here all needed step for the plugin installation
 * such as create default config, add database tables, 
 * add fields to existing tables, create local folders...
 */
function plugin_install() 
{
  ppppp_install();
  define('ppppp_installed', true);
}

/**
 * plugin activation
 *
 * this function is triggered adter installation, by manual activation
 * or after a plugin update
 * for this last case you must manage updates tasks of your plugin in this function
 */
function plugin_activate()
{
  if (!defined('ppppp_installed')) // a plugin is activated just after its installation
  {
    ppppp_install();
  }
}

/**
 * plugin unactivation
 *
 * triggered before uninstallation or by manual unactivation
 */
function plugin_unactivate()
{
}

function plugin_uninstall()
{
  global $prefixeTable;
 
  $query = "DROP TABLE ".$prefixeTable."ppppp_size;";
  pwg_query($query);
  
  $query = "DROP TABLE ".$prefixeTable."ppppp_config;"; 
  pwg_query($query);

  // delete configuration
  pwg_query('DELETE FROM `'. CONFIG_TABLE .'` WHERE param = "PayPalShoppingCart";');
  
  // delete field
  pwg_query('ALTER TABLE `'. CATEGORIES_TABLE .'` DROP COLUMN paypal_active;');
}
?>