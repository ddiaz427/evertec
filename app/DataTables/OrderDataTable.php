<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class OrderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'orders.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Order $model)
    {
        if(Auth::user()->is_customer == 0)
        {
            return $model->newQuery();
        }
        else
        {
            return $model->newQuery()->where('user_id',$this->user_id);
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['title' => 'Opciones', 'width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'export', 'text' => 'Exportar', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'print', 'text' => 'Imprimir', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reset', 'text' => 'Restablecer', 'className' => 'btn btn-default btn-sm no-corner',],
                    ['extend' => 'reload', 'text' => 'Refrescar', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'Nombre' => ['name' => 'customer_name', 'data' => 'customer_name'],
            'Email' => ['name' => 'customer_email', 'data' => 'customer_email'],
            'Celular' => ['name' => 'customer_mobile', 'data' => 'customer_mobile'],
            'Estado' => ['name' => 'status', 'data' => 'status'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'orders_datatable_' . time();
    }
}
