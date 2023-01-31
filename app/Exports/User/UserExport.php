<?php

namespace App\Exports\User;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use App\User;
use App\Exports\User\UserSheetExport;
use App\Exports\User\DinamizadorSheetExport;
use App\Exports\User\GestorSheetExport;
use App\Exports\User\InfocenterSheetExport;
use App\Exports\User\TalentoSheetExport;
use App\Exports\User\IngresoSheetExport;

class UserExport implements WithMultipleSheets
{
    use Exportable, SerializesModels;

    private $request;
    private $query;

    public function __construct($request, $query)
    {
        $this->request = $request;
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        if ($this->request->filled('filter_role') && $this->request->filter_role == User::IsDinamizador()) {
            $sheets[] = new DinamizadorSheetExport($this->request, $this->query);
        } else if ($this->request->filled('filter_role') && $this->request->filter_role == User::IsExperto()) {
            $sheets[] = new GestorSheetExport($this->request, $this->query);
        } else if ($this->request->filled('filter_role') && $this->request->filter_role == User::IsInfocenter()) {
            $sheets[] = new InfocenterSheetExport($this->request, $this->query);
        } else if ($this->request->filled('filter_role') && $this->request->filter_role == User::IsTalento()) {
            $sheets[] = new TalentoSheetExport($this->request, $this->query);
        } else if ($this->request->filled('filter_role') && $this->request->filter_role == User::IsIngreso()) {
            $sheets[] = new IngresoSheetExport($this->request, $this->query);
        } else {
            $sheets[] = new UserSheetExport($this->request, $this->query);
        }
        return $sheets;
    }

    public function failed(Throwable $exception): void
    {
        alert()->error($exception->message())->toToast()->autoClose(10000);
    }
}
