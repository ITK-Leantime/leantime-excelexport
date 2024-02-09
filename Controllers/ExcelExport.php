<?php

namespace Leantime\Plugins\ExcelExport\Controllers;

use Leantime\Core\Controller;
use Symfony\Component\HttpFoundation\Response;
use Leantime\Domain\Timesheets\Repositories\Timesheets as TimesheetRepository;

/**
 * Export Controller
 *
 * @package    leantime
 * @subpackage plugins
 */
class ExcelExport extends Controller {
  private TimesheetRepository $timesheetRepository;

  /**
   * constructor
   *
   * @access public
   *
   */
  public function init(
    TimesheetRepository $timesheetRepository,
  ) {
    $this->timesheetRepository = $timesheetRepository;
  }

/**
   * get
   *
   * @return Response
   */
  public function getTimesheets(): Response {
    // $hest = $this->timesheetRepository->getAll("", "", "", "", "", "-1", "-1", "-1", "", "");

    die('<pre>'.print_r("test",true).'</pre>');

  }

}
