<?php
/*
  Plugin Name: Crudiator
  Plugin URI: https://crudiator.com/
  Description: This plugin allows you to easily Create, Read, Update, Delete, etc. tables in the database with a WordPress-like UI.
  Version: 2.0.1
  Author: Takafu
  Author URI: https://twitter.com/kahoo365
  License: GPL2
  Text Domain: crudiator
  Domain Path: /languages/
*/

namespace Crudiator;

require_once __DIR__ . "/vendor/autoload.php";

new CrudiatorPlugin();
