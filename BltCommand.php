<?php

namespace Your_project\Blt\Plugin\Commands;

use Acquia\Blt\Robo\BltTasks;

/**
 * Defines commands.
 */
class BltCommand extends BltTasks {

  /**
   * Executes Rector suggestions for newer PHP features.
   *
   * This command will trigger Rector processing to check if any
   * new PHP features can be used in provided file list. This Rector
   * processing takes all the configuration provided in rector.php file
   * available in repository root. For more information please check:
   * https://github.com/rectorphp/rector.
   *
   * @param string $file_list
   *   A list of files to scan, separated by \n.
   *
   * @command tests:rector:validate
   *
   * @throws \Exception
   */
  public function sniffFileList($file_list) {
    $failed = FALSE;
    $this->say("Sniffing changed PHP files for upgraded feature usage...");
    $files = explode("\n", $file_list);
    // Filtering PHP files.
    $files = array_filter($files, fn($value) =>
      // Only track files inside docroot.
      str_starts_with($value, 'docroot') && (
        // Only take php files for validation.
        str_ends_with($value, '.php')
        || str_ends_with($value, '.module')
        || str_ends_with($value, '.install')
        || str_ends_with($value, '.inc')
        || str_ends_with($value, '.theme')
      )
    );
    if ($files) {
      $output = $this->_exec('cd ' . $this->getConfigValue('repo.root') . '; vendor/bin/rector process ' . implode(' ', $files) . ' --dry-run');
      if ($output->getExitCode() !== 0) {
        $failed = TRUE;
      }
    }

    // Throw exception if any upgradable PHP feature found.
    if ($failed) {
      throw new \Exception("Please use new PHP features as suggested by Rector.\n CAUTION!!! Rector suggestions do not provide proper code formatting as of now. E.g. Indentation, Bracket positions, Comment formats etc. Please use your best judgement while adding them. You can also validate using PHPCS.");
    }
  }
}
