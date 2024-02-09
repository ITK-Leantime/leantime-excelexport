<?php


use Leantime\Core\Events;
use Leantime\Plugins\ExcelExport\Services\ExcelExport;

Events::add_event_listener(
  "leantime.core.template.tpl.*.afterScriptLibTags",


  function () {
    if (isset($_SESSION['userdata']['id']) && !is_null($_SESSION['userdata']['id'])) {

      echo <<<STYLE
        <style>
        #excelExportButton, #CSVExportButton {
            background: var(--main-action-bg);
            border: 1px solid var(--main-action-bg);
            border-radius: var(--element-radius);
            box-shadow: none;
            color: var(--main-action-color);
            display: inline-block;
            font-size: var(--base-font-size);
            font-weight: 700;
            line-height: 21px;
            outline: 0;
            padding: 4px 14px;
            text-shadow: none;
            word-spacing: 2px;
            float: right;
            margin-left: 10px;
        }
        </style>
        STYLE;
      echo <<<SCRIPT
        <script>
        addEventListener('load', () => {
        const exportCSV = document.createElement('button');
        exportCSV.id = "CSVExportButton"
        exportCSV.innerHTML = "Export CSV";
        exportCSV.name = "export";
        exportCSV.value = "csv";
        exportCSV.addEventListener("click", function() {
            this.innerHTML += ' <i class="fa fa-refresh fa-spin" aria-hidden="true"></i>';

            setTimeout(() => {this.setAttribute("disabled", true);}, 1);
            setTimeout(() => {this.innerHTML = 'Export CSV'; this.removeAttribute("disabled");}, 2000);
        });
        const exportExcel = document.createElement('button');
        exportExcel.id = "excelExportButton"
        exportExcel.innerHTML = "Export Excel";
        exportExcel.name = "export";
        exportExcel.value = "excel";
        exportExcel.addEventListener("click", function() {
            this.innerHTML += ' <i class="fa fa-refresh fa-spin" aria-hidden="true"></i>';
            setTimeout(() => {this.setAttribute("disabled", true);}, 1);
            setTimeout(() => {this.innerHTML = 'Export Excel'; this.removeAttribute("disabled");}, 2000);
        });
       document.querySelector('#form').prepend(exportExcel,exportCSV);

        });
       </script>
       SCRIPT;
    }
  },
  5
);


Events::add_event_listener(
  "*.begin",

  function (array $context) {
    if ($context['current_route'] === 'timesheets.showAll' && isset($_POST['export'])) {
      $excelExport = app()->make(ExcelExport::class);
      $excelExport->exportData($_POST);
    }
  },
  5
);

