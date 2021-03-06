<?php
/**
 * Run the coreylib tests.
 */
 
error_reporting(E_ALL); 
ini_set('display_errors', true);
// error_reporting(E_ERROR);

// build and test, or test source?
$source = @$argv[1];
// which test file should be run? (nothing for run all)
$run_only = @$argv[2];

if ($source == 'source') {
  require('src/coreylib.php');
} else {
  // build coreylib.php
  require('build.php');
  // load the library
  require('coreylib.php');
}

// run the tests
require('lib/simpletest/autorun.php');

class AllTests extends TestSuite {
  function AllTests() {
    global $source, $run_only;
    
    parent::TestSuite();
    $dir = opendir(dirname(__FILE__).'/tests');
    while ($entry = readdir($dir)) {
      if (preg_match('/tests\.php$/i', $entry) && (!$run_only || strtolower($run_only).'.php' == strtolower($entry))) {
        $this->addFile('tests/'.$entry);
      }
    }
    closedir($dir);
  }
}
