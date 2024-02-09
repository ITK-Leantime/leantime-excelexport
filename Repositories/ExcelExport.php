<?php

namespace Leantime\Plugins\ExcelExport\Repositories;

use Illuminate\Contracts\Container\BindingResolutionException;
use Leantime\Domain\Timesheets\Repositories\Timesheets as TimesheetRepository;


/**
 * motivationalQuotes Repository
 */
class ExcelExport {
  private TimesheetRepository $timesheetRepository;

  /**
   * constructor
   *
   * @access public
   *
   */
  public function __construct(
    TimesheetRepository $timesheetRepository,
  ) {
    $this->timesheetRepository = $timesheetRepository;
  }

  /**
   * getAllQuotes
   *
   * @return array
   * @throws BindingResolutionException
   */
  public function getAllTimesheets($criteria): array {

    $projectId = (int) $criteria['project'];
    $kind = $criteria['kind'];
    $dateFrom = (\DateTime::createFromFormat('d/m/Y', $criteria['dateFrom']))->format('Y-m-d H:i:s');
    $dateTo = (\DateTime::createFromFormat('d/m/Y', $criteria['dateTo']))->format('Y-m-d H:i:s');
    $userId = (int) $criteria['userId'];
    $invEmpl = $criteria['invEmpl'] === 'on' ? '1' : '';
    $invComp = $criteria['invComp'] === 'on' ? '1' : '';
    $paid = $criteria['paid'] === 'on' ? '1' : '';
    $clientId = (int) $criteria['clientId'];

    $timesheetRepository = app()->make(TimesheetRepository::class);

    return $timesheetRepository->getAll($projectId, $kind, $dateFrom, $dateTo, $userId, $invEmpl, $invComp, $paid, $clientId, 0);

  }
}
