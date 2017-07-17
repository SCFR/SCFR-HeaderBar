<?php /*
Plugin Name: SCFR HeaderBar
Author URI: https://starcitizen.fr
Description: SCFR HeaderBar
Version: 0.1
Author: SCFR Team
Author URI: https://starcitizen.fr
License: Private
*/
namespace SCFR\HeaderBar;

require_once("api/main.php");
require_once("model/header-bar.php");

class Main {
  private $listener;

  function __construct() {
    $this->api = new api\Main();
  }
}

$HeaderBar = new Main();

?>
