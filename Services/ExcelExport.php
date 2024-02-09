<?php

namespace Leantime\Plugins\ExcelExport\Services;

use Leantime\Plugins\ExcelExport\Repositories\ExcelExport as ExcelExportRepository;


class ExcelExport {

  private ExcelExportRepository $excelExportRepo;

  /**
   * constructor
   *
   * @param ExcelExportRepository $excelExportRepo
   * @return void
   */
  public function __construct(ExcelExportRepository $excelExportRepo) {
    $this->excelExportRepo = $excelExportRepo;
  }

  public function install() {

  }

  public function uninstall() {

  }

  /**
   * Gets timesheet data from repository and exports as given filetype.
   *
   * @return string
   */
  public function exportData($criteria): void {
    switch ($criteria['export']) {
      case "excel":
        $data = $this->excelExportRepo->getAllTimesheets($criteria);
        if (empty($data)) {
          header("Refresh:0");
          exit;
        }
        $data = array_map(
          static fn(array $row) => array_filter($row, static fn($key) => !is_int($key), ARRAY_FILTER_USE_KEY),
          $data);
        $stdOut = fopen('php://output', 'w');
        ob_start();
        fputs($stdOut, "sep=," . PHP_EOL);
        fputcsv($stdOut, array_keys(reset($data)));

        foreach ($data as $row) {
          fputcsv($stdOut, $row);
        }
        fclose($stdOut);
        $result = ob_get_clean();
        header('Content-type: text/csv');
        header('Content-Disposition: attachment;filename="leantime_timesheets_'.$criteria['dateFrom'].'-'.$criteria['dateTo'].'.csv"');
        echo $result;
        die();
      case "csv":
        $data = $this->excelExportRepo->getAllTimesheets($criteria);
        if (empty($data)) {
          header("Refresh:0");
          exit;
        }
        $data = array_map(
          static fn(array $row) => array_filter($row, static fn($key) => !is_int($key), ARRAY_FILTER_USE_KEY),
          $data);
        $stdOut = fopen('php://output', 'w');
        ob_start();
        fputcsv($stdOut, array_keys(reset($data)));

        foreach ($data as $row) {
          fputcsv($stdOut, $row);
        }
        fclose($stdOut);
        $result = ob_get_clean();
        header('Content-type: text/csv');
        header('Content-Disposition: attachment;filename="leantime_timesheets_'.$criteria['dateFrom'].'-'.$criteria['dateTo'].'.csv"');
        echo $result;
        die();
      default:
        break;
    }
  }
}
