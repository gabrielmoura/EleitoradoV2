<?php

namespace App\Actions\Tools;

use Laravel\Cashier\Contracts\InvoiceRenderer;
use Laravel\Cashier\Invoice;

class TcpPdfInvoiceRenderer implements InvoiceRenderer
{
    public function render(Invoice $invoice, array $data = [], array $options = []): string
    {
        $html = $invoice->view($data)->render();

        \PDF::reset();
        \PDF::SetTitle('Invoice '.$invoice->toArray()['number']);
        \PDF::SetSubject('Invoice');
        \PDF::AddPage();
        \PDF::writeHTML($html, true, false, true, false, '');

        return \PDF::Output('', 'S');
    }
}
